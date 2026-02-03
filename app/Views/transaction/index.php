<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Riwayat Transaksi</h4>
        <p class="text-muted mb-0">Daftar semua transaksi penjualan</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Kasir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $trans): ?>
                        <tr>
                            <td><code><?= esc($trans['invoice_no']) ?></code></td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($trans['created_at'])) ?>
                            </td>
                            <td>
                                <?= esc($trans['customer_name'] ?? 'Umum') ?>
                            </td>
                            <td class="fw-semibold">Rp
                                <?= number_format($trans['grand_total'], 0, ',', '.') ?>
                            </td>
                            <td>
                                <?php
                                $paymentBadges = [
                                    'cash' => 'bg-success',
                                    'transfer' => 'bg-info',
                                    'qris' => 'bg-primary'
                                ];
                                ?>
                                <span class="badge <?= $paymentBadges[$trans['payment_method']] ?? 'bg-secondary' ?>">
                                    <?= ucfirst($trans['payment_method']) ?>
                                </span>
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
                                <?= esc($trans['cashier_name'] ?? '-') ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('transaction/show/' . $trans['id']) ?>"
                                        class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('transaction/print/' . $trans['id']) ?>"
                                        class="btn btn-sm btn-outline-info" title="Cetak" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <?php if ($trans['status'] == 'completed'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmCancel('<?= base_url('transaction/cancel/' . $trans['id']) ?>')"
                                            title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function confirmCancel(url) {
        Swal.fire({
            title: 'Batalkan Transaksi?',
            text: 'Stok akan dikembalikan ke semula',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
<?= $this->endSection() ?>