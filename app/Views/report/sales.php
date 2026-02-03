<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Laporan Penjualan</h4>
        <p class="text-muted mb-0">Analisa penjualan berdasarkan periode</p>
    </div>
    <a href="<?= base_url('report/export/sales-pdf') ?>?date_from=<?= $dateFrom ?>&date_to=<?= $dateTo ?>"
        class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf me-1"></i> Export PDF
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="<?= base_url('report/sales') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="date_from" value="<?= $dateFrom ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" name="date_to" value="<?= $dateTo ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card primary">
            <i class="fas fa-receipt stat-icon"></i>
            <div class="stat-value">
                <?= count($transactions) ?>
            </div>
            <div class="stat-label">Total Transaksi</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card success">
            <i class="fas fa-coins stat-icon"></i>
            <div class="stat-value">
                <?= number_format($totalSales, 0, ',', '.') ?>
            </div>
            <div class="stat-label">Total Penjualan (Rp)</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card info">
            <i class="fas fa-chart-line stat-icon"></i>
            <div class="stat-value">
                <?= count($transactions) > 0 ? number_format($totalSales / count($transactions), 0, ',', '.') : 0 ?>
            </div>
            <div class="stat-label">Rata-rata per Transaksi (Rp)</div>
        </div>
    </div>
</div>

<!-- Transaction List -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list text-primary me-2"></i>
            Daftar Transaksi
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($transactions)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-receipt fa-3x mb-3"></i>
                <p class="mb-0">Tidak ada transaksi pada periode ini</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Pembayaran</th>
                            <th class="text-end">Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $trans): ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url('transaction/show/' . $trans['id']) ?>" class="text-decoration-none">
                                        <code><?= esc($trans['invoice_no']) ?></code>
                                    </a>
                                </td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($trans['created_at'])) ?>
                                </td>
                                <td>
                                    <?= esc($trans['customer_name'] ?? 'Umum') ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= ucfirst($trans['payment_method']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">Rp
                                    <?= number_format($trans['grand_total'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-primary">
                            <th colspan="4" class="text-end">Total Penjualan</th>
                            <th class="text-end">Rp
                                <?= number_format($totalSales, 0, ',', '.') ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>