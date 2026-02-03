<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Stock Out</h4>
        <p class="text-muted mb-0">Kurangi stok produk (selain penjualan)</p>
    </div>
    <a href="<?= base_url('stock') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('stock/out') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Produk <span class="text-danger">*</span></label>
                            <select class="form-select" name="product_id" id="productSelect" required>
                                <option value="">Pilih Produk</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['id'] ?>" data-stock="<?= $product['stock'] ?>">
                                        <?= esc($product['code']) ?> -
                                        <?= esc($product['name']) ?> (Stok:
                                        <?= $product['stock'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="qty" id="qtyInput" min="1" required>
                            <small class="text-muted">Stok tersedia: <span id="availableStock">0</span></small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Referensi</label>
                            <input type="text" class="form-control" name="reference"
                                placeholder="No. Dokumen / Keterangan">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="note" rows="3"
                                placeholder="Alasan stock out (rusak, expired, dll)..."></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-arrow-up me-1"></i> Proses Stock Out
                        </button>
                        <a href="<?= base_url('stock') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('productSelect').addEventListener('change', function () {
        const option = this.options[this.selectedIndex];
        const stock = option.dataset.stock || 0;
        document.getElementById('availableStock').textContent = stock;
        document.getElementById('qtyInput').max = stock;
    });
</script>
<?= $this->endSection() ?>