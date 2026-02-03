<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Daftar Customer</h4>
        <p class="text-muted mb-0">Kelola data customer bengkel</p>
    </div>
    <a href="<?= base_url('customer/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Customer
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Customer</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $i => $customer): ?>
                        <tr>
                            <td>
                                <?= $i + 1 ?>
                            </td>
                            <td class="fw-semibold">
                                <?= esc($customer['name']) ?>
                            </td>
                            <td>
                                <?= esc($customer['phone'] ?? '-') ?>
                            </td>
                            <td>
                                <?= esc($customer['email'] ?? '-') ?>
                            </td>
                            <td>
                                <?= esc($customer['address'] ?? '-') ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('customer/show/' . $customer['id']) ?>"
                                        class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('customer/edit/' . $customer['id']) ?>"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('<?= base_url('customer/delete/' . $customer['id']) ?>', '<?= esc($customer['name']) ?>')"
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