<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Daftar Kategori</h4>
        <p class="text-muted mb-0">Kelola kategori produk bengkel</p>
    </div>
    <a href="<?= base_url('category/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Produk</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $i => $category): ?>
                        <tr>
                            <td>
                                <?= $i + 1 ?>
                            </td>
                            <td class="fw-semibold">
                                <?= esc($category['name']) ?>
                            </td>
                            <td>
                                <?= esc($category['description'] ?? '-') ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    <?= $category['product_count'] ?? 0 ?> Produk
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('category/edit/' . $category['id']) ?>"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('<?= base_url('category/delete/' . $category['id']) ?>', '<?= esc($category['name']) ?>')"
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