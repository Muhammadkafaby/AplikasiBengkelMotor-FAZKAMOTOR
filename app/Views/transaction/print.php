<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=80mm">
    <title>Struk -
        <?= esc($transaction['invoice_no']) ?>
    </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Courier New', monospace;
        }

        body {
            width: 80mm;
            padding: 5mm;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
        }

        .info {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .items {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .item {
            margin-bottom: 5px;
        }

        .item-name {
            font-weight: bold;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            padding-left: 10px;
        }

        .summary {
            margin-bottom: 10px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .summary-row.total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
        }

        .footer p {
            margin-bottom: 3px;
        }

        @media print {
            body {
                width: 80mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>FAZKAMOTOR</h1>
        <p>Your Ride, Our Pride</p>
        <p>JL. Tentara Pelajar, Jatibarang, Indramayu</p>
        <p>Telp: 0852-1846-7447</p>
    </div>

    <div class="info">
        <div class="info-row">
            <span>No. Invoice:</span>
            <span>
                <?= esc($transaction['invoice_no']) ?>
            </span>
        </div>
        <div class="info-row">
            <span>Tanggal:</span>
            <span>
                <?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?>
            </span>
        </div>
        <div class="info-row">
            <span>Kasir:</span>
            <span>
                <?= esc($transaction['cashier_name']) ?>
            </span>
        </div>
        <div class="info-row">
            <span>Customer:</span>
            <span>
                <?= esc($transaction['customer_name'] ?? 'Umum') ?>
            </span>
        </div>
    </div>

    <div class="items">
        <?php foreach ($transaction['details'] as $item): ?>
            <div class="item">
                <div class="item-name">
                    <?= esc($item['product_name']) ?>
                </div>
                <div class="item-detail">
                    <span>
                        <?= $item['qty'] ?> x
                        <?= number_format($item['price'], 0, ',', '.') ?>
                    </span>
                    <span>
                        <?= number_format($item['subtotal'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="summary">
        <div class="summary-row">
            <span>Subtotal</span>
            <span>Rp
                <?= number_format($transaction['total'], 0, ',', '.') ?>
            </span>
        </div>
        <?php if ($transaction['discount'] > 0): ?>
            <div class="summary-row">
                <span>Diskon</span>
                <span>-Rp
                    <?= number_format($transaction['discount'], 0, ',', '.') ?>
                </span>
            </div>
        <?php endif; ?>
        <?php if ($transaction['tax'] > 0): ?>
            <div class="summary-row">
                <span>Pajak</span>
                <span>Rp
                    <?= number_format($transaction['tax'], 0, ',', '.') ?>
                </span>
            </div>
        <?php endif; ?>
        <div class="summary-row total">
            <span>TOTAL</span>
            <span>Rp
                <?= number_format($transaction['grand_total'], 0, ',', '.') ?>
            </span>
        </div>
        <div class="summary-row">
            <span>Bayar (
                <?= ucfirst($transaction['payment_method']) ?>)
            </span>
            <span>Rp
                <?= number_format($transaction['paid'], 0, ',', '.') ?>
            </span>
        </div>
        <div class="summary-row">
            <span>Kembali</span>
            <span>Rp
                <?= number_format($transaction['change_amount'], 0, ',', '.') ?>
            </span>
        </div>
    </div>

    <div class="footer">
        <p>================================</p>
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>Barang yang sudah dibeli</p>
        <p>tidak dapat dikembalikan</p>
        <p>================================</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">
            🖨️ Cetak Struk
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">
            ❌ Tutup
        </button>
    </div>

    <script>
        // Auto print on load
        window.onload = function () {
            // window.print();
        };
    </script>
</body>

</html>