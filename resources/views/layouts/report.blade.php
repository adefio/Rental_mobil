<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $judul }} - RentalMobil</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .report-body {
            background: #e2e8f0;
            font-family: 'Nunito', sans-serif;
            color: #1e293b;
            padding: 2rem 1rem;
        }

        .report-sheet {
            max-width: 940px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
            padding: 2.5rem 2.75rem;
        }

        .report-toolbar {
            max-width: 940px;
            margin: 0 auto 1rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .report-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1.1rem;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .report-btn:hover {
            transform: translateY(-1px);
        }

        .report-btn-primary {
            background: #4f46e5;
            color: #fff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .report-btn-secondary {
            background: #fff;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .report-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
            padding-bottom: 1.25rem;
            border-bottom: 3px solid #4f46e5;
        }

        .report-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .report-brand-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .report-brand-icon .icon {
            width: 24px;
            height: 24px;
        }

        .report-brand-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.1;
        }

        .report-brand-tagline {
            font-size: 0.78rem;
            color: #64748b;
        }

        .report-title-block {
            text-align: right;
        }

        .report-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #4f46e5;
            margin: 0 0 0.25rem;
        }

        .report-meta {
            font-size: 0.8rem;
            color: #64748b;
        }

        .report-meta strong {
            color: #334155;
        }

        .report-info-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.7rem 1rem;
            margin: 1.25rem 0;
        }

        .report-info-item {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.85rem;
            color: #475569;
        }

        .report-info-item .icon {
            color: #4f46e5;
        }

        .report-info-item strong {
            color: #1e293b;
        }

        .report-table-wrap {
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .report-table thead th {
            background: #1e293b;
            color: #fff;
            font-weight: 700;
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 0.9rem;
            text-align: left;
            white-space: nowrap;
        }

        .report-table thead th:first-child {
            border-radius: 8px 0 0 0;
        }

        .report-table thead th:last-child {
            border-radius: 0 8px 0 0;
        }

        .report-table tbody td {
            padding: 0.7rem 0.9rem;
            border-bottom: 1px solid #eef2f7;
            vertical-align: top;
        }

        .report-table tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        .report-table tbody tr:hover td {
            background: #eef2ff;
        }

        .report-table td.num,
        .report-table th.num {
            text-align: right;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }

        .report-table td.center,
        .report-table th.center {
            text-align: center;
        }

        .report-badge {
            display: inline-block;
            padding: 0.25em 0.75em;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .report-badge-success { background: #dcfce7; color: #15803d; }
        .report-badge-warning { background: #fef3c7; color: #b45309; }
        .report-badge-danger  { background: #fee2e2; color: #b91c1c; }
        .report-badge-primary { background: #e0e7ff; color: #4338ca; }
        .report-badge-info    { background: #e0f2fe; color: #0369a1; }
        .report-badge-neutral { background: #f1f5f9; color: #475569; }

        .report-summary {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.25rem;
        }

        .report-summary-box {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            text-align: center;
        }

        .report-summary-box .label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6366f1;
            font-weight: 700;
        }

        .report-summary-box .value {
            font-size: 1.35rem;
            font-weight: 800;
            color: #1e293b;
            font-variant-numeric: tabular-nums;
        }

        .report-sign {
            margin-top: 3.5rem;
            text-align: right;
        }

        .report-sign p {
            margin: 0;
            color: #475569;
            font-size: 0.9rem;
        }

        .report-sign-space {
            height: 64px;
        }

        .report-sign-name {
            font-weight: 800;
            color: #1e293b;
            border-top: 1.5px solid #94a3b8;
            padding-top: 0.4rem;
            display: inline-block;
            min-width: 220px;
            text-align: center;
        }

        .report-sign-role {
            color: #64748b;
            font-size: 0.82rem;
            margin-top: 0.15rem;
        }

        @media print {
            body {
                background: #fff !important;
                padding: 0 !important;
            }

            .report-toolbar {
                display: none !important;
            }

            .report-sheet {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
                padding: 0;
            }

            .report-table thead {
                display: table-header-group;
            }

            .report-table tr {
                page-break-inside: avoid;
            }

            @page {
                margin: 18mm;
            }
        }

        @media (max-width: 576px) {
            .report-title-block {
                text-align: left;
            }

            .report-sheet {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body class="report-body">
    <div class="report-toolbar no-print">
        <button class="report-btn report-btn-secondary" onclick="window.close()">
            <x-icon name="x" class="icon-sm" /> Tutup
        </button>
        <button class="report-btn report-btn-primary" onclick="window.print()">
            <x-icon name="file-text" class="icon-sm" /> Cetak / Simpan PDF
        </button>
    </div>

    <div class="report-sheet">
        <header class="report-header">
            <div class="report-brand">
                <span class="report-brand-icon"><x-icon name="car" /></span>
                <div>
                    <div class="report-brand-name">RentalMobil</div>
                    <div class="report-brand-tagline">Layanan Penyewaan Mobil Terpercaya</div>
                </div>
            </div>
            <div class="report-title-block">
                <h1 class="report-title">{{ $judul }}</h1>
                <div class="report-meta">Dicetak: <strong>{{ now()->translatedFormat('d F Y') }}</strong>
                    pukul <strong>{{ now()->format('H:i') }}</strong> WIB</div>
            </div>
        </header>

        @yield('report-content')

        <div class="report-sign">
            <p>Mengetahui,</p>
            <div class="report-sign-space"></div>
            <span class="report-sign-name">Admin</span>
            <div class="report-sign-role">Administrator RentalMobil</div>
        </div>
    </div>
</body>

</html>
