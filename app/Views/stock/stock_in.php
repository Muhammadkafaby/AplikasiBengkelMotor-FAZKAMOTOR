<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Stock In</h4>
        <p class="text-muted mb-0">Tambah stok produk dari pembelian atau penerimaan barang</p>
    </div>
    <a href="<?= base_url('stock') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('stock/in') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Produk <span class="text-danger">*</span></label>
                            <select class="form-select" name="product_id" required>
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
                            <input type="number" class="form-control" name="qty" min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Referensi</label>
                            <input type="text" class="form-control" name="reference"
                                placeholder="No. PO / No. Surat Jalan">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="note" rows="3"
                                placeholder="Keterangan tambahan..."></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-arrow-down me-1"></i> Proses Stock In
                        </button>
                        <a href="<?= base_url('stock') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>