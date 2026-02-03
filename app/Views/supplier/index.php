<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Daftar Supplier</h4>
        <p class="text-muted mb-0">Kelola data supplier bengkel</p>
    </div>
    <a href="<?= base_url('supplier/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Supplier
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Supplier</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suppliers as $i => $supplier): ?>
                        <tr>
                            <td>
                                <?= $i + 1 ?>
                            </td>
                            <td class="fw-semibold">
                                <?= esc($supplier['name']) ?>
                            </td>
                            <td>
                                <?= esc($supplier['phone'] ?? '-') ?>
                            </td>
                            <td>
                                <?= esc($supplier['email'] ?? '-') ?>
                            </td>
                            <td>
                                <?= esc($supplier['address'] ?? '-') ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('supplier/edit/' . $supplier['id']) ?>"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('<?= base_url('supplier/delete/' . $supplier['id']) ?>', '<?= esc($supplier['name']) ?>')"
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