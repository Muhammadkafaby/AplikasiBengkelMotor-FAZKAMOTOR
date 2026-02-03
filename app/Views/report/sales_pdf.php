<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Penjualan - FAZKAMOTOR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #1a237e;
        }

        .header h1 {
            font-size: 24px;
            color: #1a237e;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            color: #666;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-title h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .report-title .period {
            font-size: 12px;
            color: #666;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 10px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .summary-table .label {
            font-size: 11px;
            color: #666;
        }

        .summary-table .value {
            font-size: 16px;
            font-weight: bold;
            color: #1a237e;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.main-table thead {
            background-color: #1a237e;
            color: white;
        }

        table.main-table th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        table.main-table th.text-end {
            text-align: right;
        }

        table.main-table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        table.main-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }

        table.main-table td.text-end {
            text-align: right;
        }

        table.main-table tfoot {
            background-color: #e8eaf6;
            font-weight: bold;
        }

        table.main-table tfoot td {
            padding: 10px;
            border-top: 2px solid #1a237e;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            border-radius: 3px;
            color: white;
        }

        .badge-cash {
            background-color: #4caf50;
        }

        .badge-qris {
            background-color: #2196f3;
        }

        .badge-transfer {
            background-color: #ff9800;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>FAZKAMOTOR</h1>
        <p>Your Ride, Our Pride</p>
        <p>JL. Tentara Pelajar, Jatibarang, Indramayu | Telp: 0852-1846-7447</p>
    </div>

    <div class="report-title">
        <h2>LAPORAN PENJUALAN</h2>
        <p class="period">
            Periode:
            <?= date('d F Y', strtotime($dateFrom)) ?> -
            <?= date('d F Y', strtotime($dateTo)) ?>
        </p>
    </div>

    <div class="summary">
        <table class="summary-table">
            <tr>
                <td>
                    <div class="label">Total Transaksi</div>
                    <div class="value">
                        <?= $totalTransactions ?>
                    </div>
                </td>
                <td>
                    <div class="label">Total Penjualan</div>
                    <div class="value">Rp
                        <?= number_format($totalSales, 0, ',', '.') ?>
                    </div>
                </td>
                <td>
                    <div class="label">Rata-rata per Transaksi</div>
                    <div class="value">Rp
                        <?= $totalTransactions > 0 ? number_format($totalSales / $totalTransactions, 0, ',', '.') : 0 ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <?php if (empty($transactions)): ?>
        <div class="no-data">
            Tidak ada transaksi pada periode ini
        </div>
    <?php else: ?>
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Invoice</th>
                    <th style="width: 20%;">Tanggal</th>
                    <th style="width: 20%;">Customer</th>
                    <th style="width: 15%;">Pembayaran</th>
                    <th style="width: 20%;" class="text-end">Grand Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($transactions as $trans): ?>
                    <tr>
                        <td>
                            <?= $no++ ?>
                        </td>
                        <td>
                            <?= esc($trans['invoice_no']) ?>
                        </td>
                        <td>
                            <?= date('d/m/Y H:i', strtotime($trans['created_at'])) ?>
                        </td>
                        <td>
                            <?= esc($trans['customer_name'] ?? 'Umum') ?>
                        </td>
                        <td>
                            <span class="badge badge-<?= strtolower($trans['payment_method']) ?>">
                                <?= ucfirst($trans['payment_method']) ?>
                            </span>
                        </td>
                        <td class="text-end">Rp
                            <?= number_format($trans['grand_total'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;">Total Penjualan</td>
                    <td class="text-end">Rp
                        <?= number_format($totalSales, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

    <div class="footer">
        <p>Dicetak pada:
            <?= date('d F Y H:i:s') ?>
        </p>
        <p>©
            <?= date('Y') ?> FAZKAMOTOR - Laporan ini digenerate secara otomatis oleh sistem
        </p>
    </div>
</body>

</html>