<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ResourceController extends Controller
{
    private function definition(string $resource): array
    {
        abort_unless(array_key_exists($resource, config('admin_resources')), 404);

        return config("admin_resources.{$resource}");
    }

    public function index(Request $request, string $resource)
    {
        $definition = $this->definition($resource);
        $query = $definition['model']::query()->with($definition['with'] ?? []);
        if ($request->filled('q')) {
            $query->where(function ($builder) use ($request, $definition) {
                foreach ($definition['search'] as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method.'Raw'}("LOWER({$column}) LIKE ?", ['%'.mb_strtolower($request->q).'%']);
                }
            });
        }

        return view('admin.resources.index', compact('resource', 'definition') + ['records' => $query->latest()->paginate(15)->withQueryString()]);
    }

    public function create(string $resource)
    {
        $definition = $this->definition($resource);

        return view('admin.resources.form', compact('resource', 'definition') + ['record' => new $definition['model'], 'options' => $this->options($definition)]);
    }

    public function store(Request $request, string $resource, ImageUploadService $images)
    {
        $definition = $this->definition($resource);
        $data = $this->validated($request, $definition);
        $record = $definition['model']::create($this->prepare($request, $data, $definition, $images, null, $resource));
        $this->syncRelations($record, $data, $definition);

        return redirect()->route('admin.resources.index', $resource)->with('success', "{$definition['label']} berhasil ditambahkan.");
    }

    public function edit(string $resource, int $record)
    {
        $definition = $this->definition($resource);
        $item = $definition['model']::with($definition['with'] ?? [])->findOrFail($record);

        return view('admin.resources.form', compact('resource', 'definition') + ['record' => $item, 'options' => $this->options($definition)]);
    }

    public function update(Request $request, string $resource, int $record, ImageUploadService $images)
    {
        $definition = $this->definition($resource);
        $item = $definition['model']::findOrFail($record);
        $data = $this->validated($request, $definition, $item->id);
        $item->update($this->prepare($request, $data, $definition, $images, $item, $resource));
        $this->syncRelations($item, $data, $definition);

        return redirect()->route('admin.resources.index', $resource)->with('success', "{$definition['label']} berhasil diperbarui.");
    }

    public function destroy(string $resource, int $record, ImageUploadService $images)
    {
        $definition = $this->definition($resource);
        $item = $definition['model']::findOrFail($record);
        foreach ($definition['fields'] as $name => $field) {
            if ($field['type'] === 'image') {
                $images->delete($item->{$name});
            }
        }
        $item->delete();

        return back()->with('success', "{$definition['label']} berhasil dihapus.");
    }

    private function validated(Request $request, array $definition, ?int $id = null): array
    {
        $rules = [];
        foreach ($definition['fields'] as $name => $field) {
            $fieldRules = $field['rules'];
            if ($field['type'] === 'image' && $id) {
                $fieldRules = array_map(fn ($rule) => $rule === 'required' ? 'nullable' : $rule, $fieldRules);
            }
            if ($name === 'slug') {
                $fieldRules[] = Rule::unique('products', 'slug')->ignore($id);
            }
            $rules[$name] = $fieldRules;
            if (isset($field['item_rules'])) {
                $rules[$name.'.*'] = $field['item_rules'];
            }
        }

        return $request->validate($rules);
    }

    private function prepare(Request $request, array $data, array $definition, ImageUploadService $images, $record, string $resource): array
    {
        foreach ($definition['fields'] as $name => $field) {
            if ($field['type'] === 'boolean') {
                $data[$name] = $request->boolean($name);
            }
            if ($field['type'] === 'image') {
                unset($data[$name]);
                if ($request->hasFile($name)) {
                    $images->delete($record?->{$name});
                    $data[$name] = $images->store($request->file($name), $resource);
                }
            }
            if ($field['type'] === 'multiselect') {
                unset($data[$name]);
            }
        }
        if ($resource === 'products' && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $data;
    }

    private function syncRelations($record, array $data, array $definition): void
    {
        foreach ($definition['fields'] as $name => $field) {
            if ($field['type'] === 'multiselect') {
                $record->{$field['relation']}()->sync($data[$name] ?? []);
            }
        }
    }

    private function options(array $definition): array
    {
        $options = [];
        foreach ($definition['fields'] as $name => $field) {
            if (in_array($field['type'], ['select', 'multiselect'])) {
                $options[$name] = $field['model']::orderBy($field['option'])->get();
            }
        }

        return $options;
    }
}
