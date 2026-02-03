<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Daftar Produk</h4>
        <p class="text-muted mb-0">Kelola semua produk dan sparepart bengkel</p>
    </div>
    <a href="<?= base_url('product/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if ($product['image']): ?>
                                    <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                        alt="<?= esc($product['name']) ?>" class="product-img">
                                <?php else: ?>
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-box"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><code><?= esc($product['code']) ?></code></td>
                            <td>
                                <div class="fw-semibold">
                                    <?= esc($product['name']) ?>
                                </div>
                                <?php if ($product['description']): ?>
                                    <small class="text-muted">
                                        <?= esc(substr($product['description'], 0, 50)) ?>...
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($product['category_name']): ?>
                                    <span class="badge bg-light text-dark">
                                        <?= esc($product['category_name']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($product['type'] == 'sparepart'): ?>
                                    <span class="badge bg-primary">Sparepart</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Jasa</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($product['type'] == 'jasa'): ?>
                                    <span class="text-muted">-</span>
                                <?php elseif ($product['stock'] <= $product['min_stock']): ?>
                                    <span class="low-stock">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <?= $product['stock'] ?>
                                        <?= $product['unit'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-success">
                                        <?= $product['stock'] ?>
                                        <?= $product['unit'] ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold">Rp
                                <?= number_format($product['sell_price'], 0, ',', '.') ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('product/edit/' . $product['id']) ?>"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('<?= base_url('product/delete/' . $product['id']) ?>', '<?= esc($product['name']) ?>')"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
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