<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Manajemen Stok</h4>
        <p class="text-muted mb-0">Riwayat pergerakan stok produk</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('stock/in') ?>" class="btn btn-success">
            <i class="fas fa-arrow-down me-1"></i> Stock In
        </a>
        <a href="<?= base_url('stock/out') ?>" class="btn btn-warning">
            <i class="fas fa-arrow-up me-1"></i> Stock Out
        </a>
        <a href="<?= base_url('stock/adjustment') ?>" class="btn btn-info">
            <i class="fas fa-sync me-1"></i> Adjustment
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Tipe</th>
                        <th>Qty</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Referensi</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movements as $movement): ?>
                        <tr>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($movement['created_at'])) ?>
                            </td>
                            <td>
                                <div class="fw-semibold">
                                    <?= esc($movement['product_name']) ?>
                                </div>
                                <small class="text-muted">
                                    <?= esc($movement['product_code']) ?>
                                </small>
                            </td>
                            <td>
                                <?php
                                $badges = [
                                    'in' => 'bg-success',
                                    'out' => 'bg-warning',
                                    'sale' => 'bg-primary',
                                    'adjustment' => 'bg-info'
                                ];
                                $labels = [
                                    'in' => 'Stock In',
                                    'out' => 'Stock Out',
                                    'sale' => 'Penjualan',
                                    'adjustment' => 'Adjustment'
                                ];
                                ?>
                                <span class="badge <?= $badges[$movement['type']] ?? 'bg-secondary' ?>">
                                    <?= $labels[$movement['type']] ?? $movement['type'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($movement['type'] == 'in'): ?>
                                    <span class="text-success fw-bold">+
                                        <?= $movement['qty'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-danger fw-bold">-
                                        <?= $movement['qty'] ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $movement['stock_before'] ?>
                            </td>
                            <td>
                                <?= $movement['stock_after'] ?>
                            </td>
                            <td>
                                <?php if ($movement['reference']): ?>
                                    <code><?= esc($movement['reference']) ?></code>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= esc($movement['user_name']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>