<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4 mb-4">
    <!-- Stat Cards -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card primary">
            <i class="fas fa-coins stat-icon"></i>
            <div class="stat-value">
                <?= number_format($todaySales['total'], 0, ',', '.') ?>
            </div>
            <div class="stat-label">Penjualan Hari Ini</div>
            <div class="mt-2 small opacity-75">
                <i class="fas fa-receipt me-1"></i>
                <?= $todaySales['count'] ?> Transaksi
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card success">
            <i class="fas fa-chart-line stat-icon"></i>
            <div class="stat-value">
                <?= number_format($monthlySales['total'], 0, ',', '.') ?>
            </div>
            <div class="stat-label">Penjualan Bulan Ini</div>
            <div class="mt-2 small opacity-75">
                <i class="fas fa-receipt me-1"></i>
                <?= $monthlySales['count'] ?> Transaksi
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card info">
            <i class="fas fa-hand-holding-usd stat-icon"></i>
            <div class="stat-value">
                <?= number_format($todayProfit['profit'], 0, ',', '.') ?>
            </div>
            <div class="stat-label">Laba Hari Ini</div>
            <div class="mt-2 small opacity-75">
                <i class="fas fa-money-bill-wave me-1"></i>
                Modal: Rp <?= number_format($todayProfit['cost'], 0, ',', '.') ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card warning">
            <i class="fas fa-piggy-bank stat-icon"></i>
            <div class="stat-value">
                <?= number_format($monthlyProfit['profit'], 0, ',', '.') ?>
            </div>
            <div class="stat-label">Laba Bulan Ini</div>
            <div class="mt-2 small opacity-75">
                <i class="fas fa-money-bill-wave me-1"></i>
                Modal: Rp <?= number_format($monthlyProfit['cost'], 0, ',', '.') ?>
            </div>
        </div>
    </div>
</div>

<!-- Summary Row for Products & Customers -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                    <i class="fas fa-box text-primary fa-lg"></i>
                </div>
                <div>
                    <div class="h4 mb-0"><?= $totalProducts ?></div>
                    <small class="text-muted">Total Produk Aktif</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                    <i class="fas fa-users text-success fa-lg"></i>
                </div>
                <div>
                    <div class="h4 mb-0"><?= $totalCustomers ?></div>
                    <small class="text-muted">Total Customer</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                    <i class="fas fa-shopping-cart text-info fa-lg"></i>
                </div>
                <div>
                    <div class="h4 mb-0"><?= number_format($todayProfit['revenue'], 0, ',', '.') ?></div>
                    <small class="text-muted">Omset Hari Ini</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                    <i class="fas fa-percentage text-warning fa-lg"></i>
                </div>
                <div>
                    <?php
                    $marginPercent = $todayProfit['revenue'] > 0
                        ? ($todayProfit['profit'] / $todayProfit['revenue']) * 100
                        : 0;
                    ?>
                    <div class="h4 mb-0"><?= number_format($marginPercent, 1) ?>%</div>
                    <small class="text-muted">Margin Laba Hari Ini</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sales Chart -->
    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-area text-primary me-2"></i>
                    Grafik Penjualan 7 Hari Terakhir
                </h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Stok Menipis
                </h5>
                <span class="badge bg-danger">
                    <?= count($lowStock) ?>
                </span>
            </div>
            <div class="card-body p-0">
                <?php if (empty($lowStock)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <p class="mb-0">Semua stok aman!</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($lowStock, 0, 5) as $product): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">
                                        <?= esc($product['name']) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= esc($product['code']) ?>
                                    </small>
                                </div>
                                <span class="badge bg-danger rounded-pill">
                                    <?= $product['stock'] ?>
                                    <?= $product['unit'] ?? 'pcs' ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($lowStock) > 5): ?>
                        <div class="p-3 text-center">
                            <a href="<?= base_url('product/low-stock') ?>" class="btn btn-sm btn-outline-danger">
                                Lihat Semua (
                                <?= count($lowStock) ?>)
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-0">
    <!-- Best Selling Products -->
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-medal text-warning me-2"></i>
                    Produk Terlaris
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($bestSelling)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p class="mb-0">Belum ada data penjualan</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Terjual</th>
                                    <th class="text-end">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bestSelling as $index => $product): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-<?= $index < 3 ? 'warning' : 'secondary' ?> me-2">
                                                    #
                                                    <?= $index + 1 ?>
                                                </span>
                                                <div>
                                                    <div class="fw-semibold">
                                                        <?= esc($product['name']) ?>
                                                    </div>
                                                    <small class="text-muted">
                                                        <?= esc($product['code']) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?= $product['total_sold'] ?>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp
                                            <?= number_format($product['total_revenue'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-receipt text-info me-2"></i>
                    Transaksi Terakhir
                </h5>
                <a href="<?= base_url('transaction') ?>" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentTransactions)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-receipt fa-3x mb-3"></i>
                        <p class="mb-0">Belum ada transaksi</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentTransactions as $transaction): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('transaction/show/' . $transaction['id']) ?>"
                                                class="text-decoration-none">
                                                <?= esc($transaction['invoice_no']) ?>
                                            </a>
                                            <div class="small text-muted">
                                                <?= date('d/m/Y H:i', strtotime($transaction['created_at'])) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?= esc($transaction['customer_name'] ?? 'Umum') ?>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp
                                            <?= number_format($transaction['grand_total'], 0, ',', '.') ?>
                                        </td>
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

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Aksi Cepat
                </h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('pos') ?>" class="btn btn-primary">
                        <i class="fas fa-cash-register me-1"></i> Buka Kasir
                    </a>
                    <a href="<?= base_url('product/create') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Produk
                    </a>
                    <a href="<?= base_url('stock/in') ?>" class="btn btn-outline-success">
                        <i class="fas fa-arrow-down me-1"></i> Stock In
                    </a>
                    <a href="<?= base_url('customer/create') ?>" class="btn btn-outline-info">
                        <i class="fas fa-user-plus me-1"></i> Tambah Customer
                    </a>
                    <a href="<?= base_url('report/sales') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-file-alt me-1"></i> Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Sales Chart
    const chartData = <?= json_encode($chartData) ?>;
    const labels = chartData.map(item => item.date);
    const data = chartData.map(item => item.total);

    const ctx = document.getElementById('salesChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
    gradient.addColorStop(1, 'rgba(102, 126, 234, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penjualan',
                data: data,
                borderColor: '#667eea',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>