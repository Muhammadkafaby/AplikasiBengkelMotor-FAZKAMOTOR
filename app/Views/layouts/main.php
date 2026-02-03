<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? 'FAZKAMOTOR' ?> - FAZKAMOTOR
    </title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #1e3a5f 0%, #0d1b2a 100%);
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #0f172a;
            --bs-body-color: #e2e8f0;
            --card-bg: #1e293b;
            --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #020617 100%);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f1f5f9;
            min-height: 100vh;
        }

        [data-bs-theme="dark"] body {
            background: #0f172a;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: var(--transition);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
        }

        .sidebar-brand span {
            color: #60a5fa;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            padding: 0.5rem 1.5rem;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
            margin: 2px 0;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left-color: #60a5fa;
        }

        .sidebar-nav .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        [data-bs-theme="dark"] .top-navbar {
            background: #1e293b;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        [data-bs-theme="dark"] .page-title {
            color: #e2e8f0;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        [data-bs-theme="dark"] .card {
            background: #1e293b;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
            font-weight: 600;
        }

        [data-bs-theme="dark"] .card-header {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        /* Stat Cards */
        .stat-card {
            border-radius: var(--border-radius);
            padding: 1.5rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
        }

        .stat-card.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-card.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-card.danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .stat-card.info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }

        .stat-card .stat-icon {
            font-size: 3rem;
            opacity: 0.3;
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-card .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        [data-bs-theme="dark"] .table th {
            color: #94a3b8;
            border-bottom-color: #334155;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.625rem 1rem;
            transition: var(--transition);
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
            border-radius: 6px;
        }

        /* User Dropdown */
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
        }

        /* Theme Toggle */
        .theme-toggle {
            padding: 0.5rem;
            border-radius: 8px;
            background: #f1f5f9;
            cursor: pointer;
            transition: var(--transition);
        }

        [data-bs-theme="dark"] .theme-toggle {
            background: #334155;
        }

        .theme-toggle:hover {
            background: #e2e8f0;
        }

        [data-bs-theme="dark"] .theme-toggle:hover {
            background: #475569;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: var(--border-radius);
        }

        /* Low Stock Warning */
        .low-stock {
            color: #dc2626;
            font-weight: 600;
        }

        /* Product Image */
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-img-placeholder {
            width: 50px;
            height: 50px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><span>FAZKA</span>MOTOR</h4>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Menu Utama</div>
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="<?= base_url('pos') ?>" class="nav-link <?= uri_string() == 'pos' ? 'active' : '' ?>">
                <i class="fas fa-cash-register"></i> Kasir (POS)
            </a>

            <div class="nav-section">Inventory</div>
            <a href="<?= base_url('product') ?>"
                class="nav-link <?= str_starts_with(uri_string(), 'product') ? 'active' : '' ?>">
                <i class="fas fa-box"></i> Produk
            </a>
            <a href="<?= base_url('category') ?>"
                class="nav-link <?= str_starts_with(uri_string(), 'category') ? 'active' : '' ?>">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="<?= base_url('stock') ?>"
                class="nav-link <?= str_starts_with(uri_string(), 'stock') ? 'active' : '' ?>">
                <i class="fas fa-warehouse"></i> Manajemen Stok
            </a>

            <div class="nav-section">Master Data</div>
            <a href="<?= base_url('supplier') ?>"
                class="nav-link <?= str_starts_with(uri_string(), 'supplier') ? 'active' : '' ?>">
                <i class="fas fa-truck"></i> Supplier
            </a>
            <a href="<?= base_url('customer') ?>"
                class="nav-link <?= str_starts_with(uri_string(), 'customer') ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Customer
            </a>

            <div class="nav-section">Transaksi</div>
            <a href="<?= base_url('transaction') ?>"
                class="nav-link <?= str_starts_with(uri_string(), 'transaction') ? 'active' : '' ?>">
                <i class="fas fa-receipt"></i> Riwayat Transaksi
            </a>

            <div class="nav-section">Laporan</div>
            <a href="<?= base_url('report/sales') ?>"
                class="nav-link <?= uri_string() == 'report/sales' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Laporan Penjualan
            </a>
            <a href="<?= base_url('report/stock') ?>"
                class="nav-link <?= uri_string() == 'report/stock' ? 'active' : '' ?>">
                <i class="fas fa-boxes"></i> Laporan Stok
            </a>
            <a href="<?= base_url('report/best-selling') ?>"
                class="nav-link <?= uri_string() == 'report/best-selling' ? 'active' : '' ?>">
                <i class="fas fa-medal"></i> Produk Terlaris
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link d-lg-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">
                    <?= $title ?? 'Dashboard' ?>
                </h1>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="theme-toggle" onclick="toggleTheme()">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </div>

                <div class="dropdown">
                    <div class="user-dropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <?= strtoupper(substr(session()->get('name') ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="fw-semibold">
                                <?= session()->get('name') ?? 'User' ?>
                            </div>
                            <div class="text-muted small">
                                <?= ucfirst(session()->get('role') ?? 'Guest') ?>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i
                                    class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area fade-in">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li>
                                <?= $error ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('themeIcon');

            if (html.getAttribute('data-bs-theme') === 'dark') {
                html.setAttribute('data-bs-theme', 'light');
                icon.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-bs-theme', 'dark');
                icon.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        if (savedTheme === 'dark') {
            document.getElementById('themeIcon').classList.replace('fa-moon', 'fa-sun');
        }

        // Sidebar Toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // DataTables default config
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            pageLength: 10,
            responsive: true
        });

        // Initialize DataTables
        $(document).ready(function () {
            if ($.fn.DataTable) {
                $('.datatable').DataTable();
            }
        });

        // Format currency
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        // Confirm delete
        function confirmDelete(url, name = 'item ini') {
            Swal.fire({
                title: 'Hapus ' + name + '?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>