<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">
            <?= $title ?>
        </h4>
        <p class="text-muted mb-0">Edit informasi produk</p>
    </div>
    <a href="<?= base_url('product') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('product/update/' . $product['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="code"
                                value="<?= old('code', $product['code']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipe <span class="text-danger">*</span></label>
                            <select class="form-select" name="type" id="productType" required>
                                <option value="sparepart" <?= $product['type'] == 'sparepart' ? 'selected' : '' ?>
                                    >Sparepart</option>
                                <option value="jasa" <?= $product['type'] == 'jasa' ? 'selected' : '' ?>>Jasa</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name"
                                value="<?= old('name', $product['name']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="category_id">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                        <?= esc($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Supplier</label>
                            <select class="form-select" name="supplier_id">
                                <option value="">Pilih Supplier</option>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?= $supplier['id'] ?>" <?= $product['supplier_id'] == $supplier['id'] ? 'selected' : '' ?>>
                                        <?= esc($supplier['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description"
                                rows="3"><?= old('description', $product['description']) ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga Beli</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="buy_price"
                                    value="<?= old('buy_price', $product['buy_price']) ?>" min="0">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="sell_price"
                                    value="<?= old('sell_price', $product['sell_price']) ?>" min="1" required>
                            </div>
                        </div>

                        <div class="col-md-6 stock-field"
                            style="<?= $product['type'] == 'jasa' ? 'display:none' : '' ?>">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="number" class="form-control" value="<?= $product['stock'] ?>" disabled>
                            <small class="text-muted">Gunakan menu Manajemen Stok untuk mengubah stok</small>
                        </div>

                        <div class="col-md-6 stock-field"
                            style="<?= $product['type'] == 'jasa' ? 'display:none' : '' ?>">
                            <label class="form-label">Stok Minimum</label>
                            <input type="number" class="form-control" name="min_stock"
                                value="<?= old('min_stock', $product['min_stock']) ?>" min="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" name="unit"
                                value="<?= old('unit', $product['unit']) ?>">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Gambar Produk</label>
                    <div class="text-center p-4 border rounded mb-3" id="imagePreviewContainer">
                        <?php if ($product['image']): ?>
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>" class="img-fluid rounded"
                                style="max-height: 200px;">
                        <?php else: ?>
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Tidak ada gambar</p>
                        <?php endif; ?>
                    </div>
                    <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Produk
                </button>
                <a href="<?= base_url('product') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('productType').addEventListener('change', function () {
        const stockFields = document.querySelectorAll('.stock-field');
        if (this.value === 'jasa') {
            stockFields.forEach(el => el.style.display = 'none');
        } else {
            stockFields.forEach(el => el.style.display = 'block');
        }
    });

    document.getElementById('imageInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagePreviewContainer').innerHTML =
                    '<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 200px;">';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?= $this->endSection() ?>