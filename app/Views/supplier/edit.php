<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">
            <?= $title ?>
        </h4>
        <p class="text-muted mb-0">Edit data supplier</p>
    </div>
    <a href="<?= base_url('supplier') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('supplier/update/' . $supplier['id']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name"
                                value="<?= old('name', $supplier['name']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="phone"
                                value="<?= old('phone', $supplier['phone']) ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= old('email', $supplier['email']) ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="address"
                                rows="3"><?= old('address', $supplier['address']) ?></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="<?= base_url('supplier') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>