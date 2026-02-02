<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos</title>

    <style>
        @page {
            margin: 25px 25px 30px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        /* ================= HEADER ================= */
        .header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 0.5px;
        }

        .header small {
            color: #6b7280;
        }

        /* ================= INFO ================= */
        .info {
            margin-bottom: 10px;
            font-size: 10.5px;
        }

        .info table {
            width: 100%;
        }

        /* ================= TABLE ================= */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            display: table-header-group;
        }

        th {
            background-color: #f3f4f6;
            border: 1px solid #9ca3af;
            padding: 6px;
            font-size: 10px;
            text-transform: uppercase;
        }

        td {
            border: 1px solid #e5e7eb;
            padding: 6px;
        }

        tr {
            page-break-inside: avoid;
        }

        /* ================= ALIGN ================= */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* ================= BADGES ================= */
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
            color: #fff;
            font-weight: bold;
        }

        .entrada {
            background: #15803d;
        }

        .salida {
            background: #b91c1c;
        }

        /* ================= FOOTER ================= */
        .footer {
            margin-top: 15px;
            font-size: 9px;
            color: #6b7280;
            border-top: 1px solid #d1d5db;
            padding-top: 5px;
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>Reporte de Movimientos</h1>
        <small>Sistema de Almacén</small>
    </div>

    {{-- INFO --}}
    <div class="info">
        <table>
            <tr>
                <td><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                <td class="text-right">
                    <strong>Total:</strong> {{ $movimientos->count() }}
                </td>
            </tr>
        </table>
    </div>

    {{-- TABLA --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Proyecto</th>
                <th>Orden</th>
                <th>Usuario</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $i => $mov)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>
                        {{ $mov->producto->nombre }}<br>
                        <small>{{ $mov->producto->codigo }}</small>
                    </td>
                    <td>{{ $mov->proyecto_nombre }}</td>
                    <td>{{ $mov->orden_compra_numero }}</td>
                    <td>{{ $mov->usuario->name }}</td>
                    <td class="text-right">{{ $mov->cantidad }}</td>
                    <td class="text-center">
                        <span class="badge {{ $mov->tipo }}">
                            {{ strtoupper($mov->tipo) }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $mov->created_at->format('d/m/Y H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Documento generado automáticamente — Sistema de Inventarios
    </div>

</body>
</html>
