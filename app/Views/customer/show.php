<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Detail Customer</h4>
        <p class="text-muted mb-0">Informasi lengkap customer</p>
    </div>
    <a href="<?= base_url('customer') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px;">
                        <span class="text-white fs-1">
                            <?= strtoupper(substr($customer['name'], 0, 1)) ?>
                        </span>
                    </div>
                </div>
                <h5 class="mb-1">
                    <?= esc($customer['name']) ?>
                </h5>
                <p class="text-muted mb-3">
                    <?= esc($customer['phone'] ?? '-') ?>
                </p>

                <div class="d-flex justify-content-center gap-2">
                    <a href="<?= base_url('customer/edit/' . $customer['id']) ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-footer bg-light">
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <div class="fs-4 fw-bold text-primary">
                            <?= $stats['total_transaction'] ?? 0 ?>
                        </div>
                        <small class="text-muted">Transaksi</small>
                    </div>
                    <div class="col-6">
                        <div class="fs-4 fw-bold text-success">Rp
                            <?= number_format($stats['total_spent'] ?? 0, 0, ',', '.') ?>
                        </div>
                        <small class="text-muted">Total Belanja</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Informasi Kontak</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label small text-muted">Email</label>
                    <div>
                        <?= esc($customer['email'] ?? '-') ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Telepon</label>
                    <div>
                        <?= esc($customer['phone'] ?? '-') ?>
                    </div>
                </div>
                <div>
                    <label class="form-label small text-muted">Alamat</label>
                    <div>
                        <?= esc($customer['address'] ?? '-') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-receipt text-primary me-2"></i>
                    Riwayat Transaksi
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($transactions)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-receipt fa-3x mb-3"></i>
                        <p class="mb-0">Belum ada transaksi</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $trans): ?>
                                    <tr>
                                        <td>
                                            <code><?= esc($trans['invoice_no']) ?></code>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y H:i', strtotime($trans['created_at'])) ?>
                                        </td>
                                        <td class="fw-semibold">Rp
                                            <?= number_format($trans['grand_total'], 0, ',', '.') ?>
                                        </td>
                                        <td>
                                            <?php if ($trans['status'] == 'completed'): ?>
                                                <span class="badge bg-success">Selesai</span>
                                            <?php elseif ($trans['status'] == 'pending'): ?>
                                                <span class="badge bg-warning">Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Batal</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('transaction/show/' . $trans['id']) ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>