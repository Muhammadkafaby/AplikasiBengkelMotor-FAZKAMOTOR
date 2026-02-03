<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Detail Transaksi</h4>
        <p class="text-muted mb-0">
            <?= esc($transaction['invoice_no']) ?>
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('transaction/print/' . $transaction['id']) ?>" class="btn btn-info" target="_blank">
            <i class="fas fa-print me-1"></i> Cetak Struk
        </a>
        <a href="<?= base_url('transaction') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list text-primary me-2"></i>
                    Item Transaksi
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaction['details'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold">
                                            <?= esc($item['product_name']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= esc($item['product_code']) ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?= $item['qty'] ?>
                                    </td>
                                    <td class="text-end">Rp
                                        <?= number_format($item['price'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-end fw-semibold">Rp
                                        <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">Subtotal</td>
                                <td class="text-end">Rp
                                    <?= number_format($transaction['total'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php if ($transaction['discount'] > 0): ?>
                                <tr>
                                    <td colspan="3" class="text-end">Diskon</td>
                                    <td class="text-end text-danger">-Rp
                                        <?= number_format($transaction['discount'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($transaction['tax'] > 0): ?>
                                <tr>
                                    <td colspan="3" class="text-end">Pajak</td>
                                    <td class="text-end">Rp
                                        <?= number_format($transaction['tax'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr class="table-primary">
                                <td colspan="3" class="text-end fw-bold">Grand Total</td>
                                <td class="text-end fw-bold fs-5">Rp
                                    <?= number_format($transaction['grand_total'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Informasi Transaksi
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label small text-muted">No. Invoice</label>
                    <div class="fw-semibold"><code><?= esc($transaction['invoice_no']) ?></code></div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Tanggal</label>
                    <div>
                        <?= date('d F Y, H:i', strtotime($transaction['created_at'])) ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Customer</label>
                    <div>
                        <?= esc($transaction['customer_name'] ?? 'Umum') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Kasir</label>
                    <div>
                        <?= esc($transaction['cashier_name']) ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Metode Pembayaran</label>
                    <div>
                        <span class="badge bg-primary">
                            <?= ucfirst($transaction['payment_method']) ?>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Status</label>
                    <div>
                        <?php if ($transaction['status'] == 'completed'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php elseif ($transaction['status'] == 'pending'): ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Dibatalkan</span>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label small text-muted">Dibayar</label>
                    <div class="fw-semibold text-success">Rp
                        <?= number_format($transaction['paid'], 0, ',', '.') ?>
                    </div>
                </div>

                <div>
                    <label class="form-label small text-muted">Kembalian</label>
                    <div class="fw-semibold">Rp
                        <?= number_format($transaction['change_amount'], 0, ',', '.') ?>
                    </div>
                </div>

                <?php if ($transaction['notes']): ?>
                    <hr>
                    <div>
                        <label class="form-label small text-muted">Catatan</label>
                        <div>
                            <?= esc($transaction['notes']) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>