<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }
        
        .invoice-container {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 20mm;
            background: white;
            position: relative;
        }
        
        /* Header Section */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 3px solid #8B4513;
            padding-bottom: 20px;
        }
        
        .header-left {
            display: table-cell;
            vertical-align: top;
            width: 60%;
        }
        
        .header-right {
            display: table-cell;
            vertical-align: top;
            width: 40%;
            text-align: right;
        }
        
        .logo-container {
            width: 80px;
            height: 80px;
            background: #f5f5f5;
            border: 2px dashed #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: 600;
            color: #8B4513;
            margin-bottom: 5px;
        }
        
        .company-tagline {
            font-size: 11px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .company-details {
            font-size: 10px;
            color: #666;
            line-height: 1.4;
        }
        
        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        
        .invoice-number {
            font-size: 13px;
            color: #8B4513;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #F5E6D3;
            color: #8B4513;
            border-radius: 15px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            border: 1px solid #D2B48C;
        }
        
        /* Info Cards */
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            table-layout: fixed;
        }
        
        .info-card {
            display: table-cell;
            width: 48%;
            vertical-align: top;
            padding: 15px 0;
        }
        
        .info-card:first-child {
            margin-right: 4%;
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }
        
        .info-card:last-child {
            padding-left: 20px;
        }
        
        .info-card-title {
            font-size: 12px;
            font-weight: 600;
            color: #8B4513;
            margin-bottom: 15px;
            border-bottom: 1px solid #D2B48C;
            padding-bottom: 8px;
        }
        
        .info-item {
            margin-bottom: 8px;
            font-size: 10px;
        }
        
        .info-label {
            font-weight: 600;
            color: #333;
            display: inline-block;
            width: 80px;
        }
        
        .info-value {
            color: #666;
        }
        
        /* Service Section */
        .service-section {
            margin-bottom: 30px;
        }
        
        .service-header {
            background: #8B4513;
            color: white;
            padding: 12px 15px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .service-content {
            padding: 20px 15px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        
        .service-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        
        .service-col {
            display: table-cell;
            width: 48%;
            vertical-align: top;
            padding-right: 15px;
        }
        
        .service-col:first-child {
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }
        
        .service-col:last-child {
            padding-left: 20px;
            padding-right: 0;
        }
        
        .service-item {
            margin-bottom: 10px;
            font-size: 10px;
        }
        
        .service-item-label {
            font-weight: 600;
            color: #333;
            display: inline-block;
            width: 90px;
        }
        
        .service-item-value {
            color: #666;
        }
        
        /* Billing Table */
        .billing-section {
            margin-bottom: 20px;
        }
        
        .billing-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }
        
        .billing-table th {
            background: #8B4513;
            color: white;
            padding: 12px 15px;
            font-size: 11px;
            font-weight: 600;
            text-align: left;
            border: 1px solid #8B4513;
        }
        
        .billing-table th.text-center {
            text-align: center;
        }
        
        .billing-table th.text-right {
            text-align: right;
        }
        
        .billing-table td {
            padding: 15px;
            border: 1px solid #ddd;
            font-size: 10px;
            background: white;
        }
        
        .service-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .service-details {
            color: #666;
            font-size: 9px;
            line-height: 1.4;
        }
        
        /* Total Section */
        .total-section {
            float: right;
            width: 220px;
            margin-top: 15px;
        }
        
        .total-card {
            border: 2px solid #8B4513;
        }
        
        .total-header {
            background: #8B4513;
            color: white;
            padding: 10px 15px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }
        
        .total-amount {
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #8B4513;
            background: white;
        }
        
        /* Notes */
        .notes-section {
            clear: both;
            margin-top: 25px;
            padding: 15px;
            background: #FFF8E1;
            border-left: 4px solid #DAA520;
        }
        
        .notes-title {
            font-size: 12px;
            font-weight: 600;
            color: #DAA520;
            margin-bottom: 8px;
        }
        
        .notes-content {
            font-size: 10px;
            color: #666;
            line-height: 1.5;
        }
        
        /* Footer */
        .footer {
            position: absolute;
            bottom: 20mm;
            left: 20mm;
            right: 20mm;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        
        .footer-brand {
            color: #8B4513;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        /* Utilities */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-5 { margin-bottom: 5px; }
        .mb-10 { margin-bottom: 10px; }
        
        /* Print specific */
        @media print {
            .invoice-container {
                margin: 0;
                padding: 20mm;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <div class="logo-container">
                    Logo<br>Photo<br>Here
                </div>
                <div class="company-name">PT. Hilaw Konsultasi Hukum Indonesia</div>
                <div class="company-tagline">Konsultasi Hukum Terpercaya & Profesional</div>
                <div class="company-details">
                    Jl. Hukum Raya No. 88, Jakarta Pusat 10110<br>
                    Telp: (021) 2345-6789 | Email: admin@hilaw.id<br>
                    NPWP: 12.345.678.9-012.000
                </div>
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                <div class="status-badge">{{ strtoupper($invoice->status) }}</div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="info-section">
            <div class="info-card">
                <div class="info-card-title">Informasi Klien</div>
                <div class="info-item">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $invoice->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $invoice->user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat:</span>
                    <span class="info-value">{{ $invoice->user->alamat ?? '-' }}</span>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-card-title">Detail Invoice</div>
                <div class="info-item">
                    <span class="info-label">No. Invoice:</span>
                    <span class="info-value">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ $invoice->issued_at->format('d M Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">{{ ucfirst($invoice->status) }}</span>
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <div class="service-section">
            <div class="service-header">Detail Layanan Konsultasi Hukum</div>
            <div class="service-content">
                <div class="service-grid">
                    <div class="service-col">
                        <div class="service-item">
                            <span class="service-item-label">Pengacara:</span>
                            <span class="service-item-value">{{ $invoice->dokter->name }}</span>
                        </div>
                        <div class="service-item">
                            <span class="service-item-label">Keahlian:</span>
                            <span class="service-item-value">{{ $invoice->dokter->keahlian ?? 'Hukum Umum' }}</span>
                        </div>
                        <div class="service-item">
                            <span class="service-item-label">Keluhan:</span>
                            <span class="service-item-value">{{ Str::limit($invoice->consultation->keluhan, 50) }}</span>
                        </div>
                    </div>
                    <div class="service-col">
                        <div class="service-item">
                            <span class="service-item-label">Lulusan:</span>
                            <span class="service-item-value">{{ $invoice->dokter->lulusan_universitas ?? '-' }}</span>
                        </div>
                        <div class="service-item">
                            <span class="service-item-label">Konsultasi:</span>
                            <span class="service-item-value">{{ $invoice->consultation->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <div class="service-item">
                            <span class="service-item-label">Durasi:</span>
                            <span class="service-item-value">
                                @if($invoice->consultation->duration_hours || $invoice->consultation->duration_minutes)
                                    {{ $invoice->consultation->duration_hours ? $invoice->consultation->duration_hours . ' jam ' : '' }}{{ $invoice->consultation->duration_minutes ? $invoice->consultation->duration_minutes . ' menit' : '' }}
                                @else
                                    -
                                @endif

        <!-- Footer -->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing Table -->
        <div class="billing-section">
            <table class="billing-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Deskripsi Layanan</th>
                        <th class="text-center" style="width: 10%;">Qty</th>
                        <th class="text-right" style="width: 20%;">Tarif</th>
                        <th class="text-right" style="width: 20%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="service-name">Konsultasi Hukum Online</div>
                            <div class="service-details">
                                Dengan {{ $invoice->dokter->name }}<br>
                                {{ $invoice->dokter->keahlian ?? 'Hukum Umum' }}<br>
                                {{ $invoice->consultation->created_at->format('d F Y, H:i') }} WIB
                            </div>
                        </td>
                        <td class="text-center">1</td>
                        <td class="text-right">Rp {{ number_format($invoice->consultation->tarif, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-card">
                <div class="total-header">TOTAL PEMBAYARAN</div>
                <div class="total-amount">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="notes-section">
            <div class="notes-title">Catatan</div>
            <div class="notes-content">
                {{ $invoice->notes }}
            </div>
        </div>
        @endif
        <div class="footer">
            <div class="footer-brand">Hilaw - Solusi Hukum Terpercaya</div>
            <div>Terima kasih telah mempercayakan masalah hukum Anda kepada kami!</div>
            <div style="margin-top: 8px; font-size: 8px;">
                Invoice ini dibuat secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB
            </div>
        </div>
    </div>
</body>
</html>