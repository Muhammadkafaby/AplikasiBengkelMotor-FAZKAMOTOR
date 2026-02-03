<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Produk Terlaris</h4>
        <p class="text-muted mb-0">Analisa produk dengan penjualan terbanyak</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="<?= base_url('report/best-selling') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="date_from" value="<?= $dateFrom ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" name="date_to" value="<?= $dateTo ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah Produk</label>
                <select class="form-select" name="limit">
                    <option value="10" <?= ($limit ?? 20) == 10 ? 'selected' : '' ?>>10 Produk</option>
                    <option value="20" <?= ($limit ?? 20) == 20 ? 'selected' : '' ?>>20 Produk</option>
                    <option value="50" <?= ($limit ?? 20) == 50 ? 'selected' : '' ?>>50 Produk</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- Chart -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie text-primary me-2"></i>
                    Grafik Penjualan
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($products)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-chart-pie fa-3x mb-3"></i>
                        <p class="mb-0">Tidak ada data penjualan</p>
                    </div>
                <?php else: ?>
                    <canvas id="bestSellingChart" height="300"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-medal text-warning me-2"></i>
                    Ranking Produk
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($products)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-trophy fa-3x mb-3"></i>
                        <p class="mb-0">Tidak ada data penjualan</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th class="text-center">Terjual</th>
                                    <th class="text-end">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $i => $product): ?>
                                    <tr>
                                        <td>
                                            <?php if ($i < 3): ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-trophy"></i> <?= $i + 1 ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= $i + 1 ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?= esc($product['name']) ?></div>
                                            <small class="text-muted"><?= esc($product['code']) ?></small>
                                        </td>
                                        <td class="text-center"><?= $product['total_sold'] ?></td>
                                        <td class="text-end fw-semibold">Rp
                                            <?= number_format($product['total_revenue'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (!empty($products)): ?>
    <script>
        const chartData = <?= json_encode(array_slice($products, 0, 10)) ?>;
        const labels = chartData.map(item => item.name.substring(0, 15));
        const data = chartData.map(item => item.total_sold);

        const colors = [
            '#667eea', '#764ba2', '#f59e0b', '#10b981', '#ef4444',
            '#06b6d4', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'
        ];

        new Chart(document.getElementById('bestSellingChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>