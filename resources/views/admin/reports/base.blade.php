<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #292524
        }

        h1 {
            color: #64258f;
            margin-bottom: 4px
        }

        p {
            margin-top: 0;
            color: #78716c
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px
        }

        th,
        td {
            border: 1px solid #d6d3d1;
            padding: 7px;
            text-align: left;
            vertical-align: top
        }

        th {
            background: #f4ebff;
            color: #522274
        }

        footer {
            position: fixed;
            bottom: 0;
            font-size: 9px;
            color: #a8a29e
        }
    </style>
</head>

<body>
    <h1>@yield('report_title')</h1>
    <p>Kedai Ubi Ungu · Dicetak {{ now()->format('d M Y H:i') }}</p>@yield('report_content')<footer>Laporan dihasilkan otomatis oleh sistem Kedai Ubi Ungu.</footer>
</body>

</html>