<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Stock Adjustment</h4>
        <p class="text-muted mb-0">Sesuaikan stok produk berdasarkan hasil stock opname</p>
    </div>
    <a href="<?= base_url('stock') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('stock/adjustment') ?>" method="POST">
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
                            <label class="form-label">Stok Sistem</label>
                            <input type="text" class="form-control" id="currentStock" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stok Aktual <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="actual_stock" id="actualStock" min="0"
                                required>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info" id="adjustmentInfo" style="display: none;">
                                <i class="fas fa-info-circle me-2"></i>
                                <span id="adjustmentText"></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="note" rows="3" placeholder="Alasan penyesuaian stok..."
                                required></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-sync me-1"></i> Proses Adjustment
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
    let currentStock = 0;

    document.getElementById('productSelect').addEventListener('change', function () {
        const option = this.options[this.selectedIndex];
        currentStock = parseInt(option.dataset.stock) || 0;
        document.getElementById('currentStock').value = currentStock;
        updateAdjustmentInfo();
    });

    document.getElementById('actualStock').addEventListener('input', updateAdjustmentInfo);

    function updateAdjustmentInfo() {
        const actual = parseInt(document.getElementById('actualStock').value) || 0;
        const diff = actual - currentStock;
        const infoDiv = document.getElementById('adjustmentInfo');
        const infoText = document.getElementById('adjustmentText');

        if (document.getElementById('actualStock').value === '') {
            infoDiv.style.display = 'none';
            return;
        }

        infoDiv.style.display = 'block';

        if (diff > 0) {
            infoDiv.classList.remove('alert-warning', 'alert-info');
            infoDiv.classList.add('alert-success');
            infoText.textContent = `Stok akan ditambah sebanyak ${diff} unit`;
        } else if (diff < 0) {
            infoDiv.classList.remove('alert-success', 'alert-info');
            infoDiv.classList.add('alert-warning');
            infoText.textContent = `Stok akan dikurangi sebanyak ${Math.abs(diff)} unit`;
        } else {
            infoDiv.classList.remove('alert-success', 'alert-warning');
            infoDiv.classList.add('alert-info');
            infoText.textContent = 'Tidak ada perubahan stok';
        }
    }
</script>
<?= $this->endSection() ?>