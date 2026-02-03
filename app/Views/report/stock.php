<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Laporan Stok</h4>
        <p class="text-muted mb-0">Kondisi stok produk saat ini</p>
    </div>
    <a href="<?= base_url('report/export/stock-excel') ?>" class="btn btn-success">
        <i class="fas fa-file-excel me-1"></i> Export Excel
    </a>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <i class="fas fa-box stat-icon"></i>
            <div class="stat-value">
                <?= count($products) ?>
            </div>
            <div class="stat-label">Total Produk</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <i class="fas fa-boxes stat-icon"></i>
            <div class="stat-value">
                <?= array_sum(array_column($products, 'stock')) ?>
            </div>
            <div class="stat-label">Total Stok</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <i class="fas fa-exclamation-triangle stat-icon"></i>
            <div class="stat-value">
                <?= count(array_filter($products, fn($p) => $p['stock'] <= $p['min_stock'] && $p['type'] == 'sparepart')) ?>
            </div>
            <div class="stat-label">Stok Menipis</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <i class="fas fa-times-circle stat-icon"></i>
            <div class="stat-value">
                <?= count(array_filter($products, fn($p) => $p['stock'] == 0 && $p['type'] == 'sparepart')) ?>
            </div>
            <div class="stat-label">Stok Habis</div>
        </div>
    </div>
</div>

<!-- Stock List -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-warehouse text-primary me-2"></i>
            Daftar Stok Produk
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Min. Stok</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th class="text-end">Nilai Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><code><?= esc($product['code']) ?></code></td>
                            <td class="fw-semibold">
                                <?= esc($product['name']) ?>
                            </td>
                            <td>
                                <?= esc($product['category_name'] ?? '-') ?>
                            </td>
                            <td>
                                <?php if ($product['type'] == 'sparepart'): ?>
                                    <span class="badge bg-primary">Sparepart</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Jasa</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?= $product['type'] == 'jasa' ? '-' : $product['stock'] ?>
                            </td>
                            <td class="text-center">
                                <?= $product['type'] == 'jasa' ? '-' : $product['min_stock'] ?>
                            </td>
                            <td>
                                <?= esc($product['unit'] ?? 'pcs') ?>
                            </td>
                            <td>
                                <?php if ($product['type'] == 'jasa'): ?>
                                    <span class="badge bg-secondary">N/A</span>
                                <?php elseif ($product['stock'] == 0): ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php elseif ($product['stock'] <= $product['min_stock']): ?>
                                    <span class="badge bg-warning">Menipis</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Aman</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <?php if ($product['type'] == 'sparepart'): ?>
                                    Rp
                                    <?= number_format($product['buy_price'] * $product['stock'], 0, ',', '.') ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-primary">
                        <th colspan="8" class="text-end">Total Nilai Stok</th>
                        <th class="text-end">
                            Rp
                            <?= number_format(array_sum(array_map(function ($p) {
                                return $p['type'] == 'sparepart' ? $p['buy_price'] * $p['stock'] : 0;
                            }, $products)), 0, ',', '.') ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>