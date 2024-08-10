<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $base_url ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= $base_url ?>assets/images/frame-24.svg">
        </div>
        <div class="sidebar-brand-text mx-3">Finanseira</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= $title === 'Dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $base_url ?>">
            <i class="fas fa-home"></i>
            <span>Dashboard</span></a>
    </li>
    <?php if ($account['role'] === 'admin') : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Features
        </div>
        <li class="nav-item <?= $title === 'Akun' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>data_akun">
                <i class="fas fa-users"></i>
                <span>Account Data</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Piutang' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>piutang">
                <i class="fas fa-funnel-dollar"></i>
                <span>Receivables</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Pajak' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>pajak">
                <i class="fas fa-search-dollar"></i>
                <span>Tax</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Analisis Keuangan' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>analisis_keuangan">
                <i class="fas fa-chart-line"></i>
                <span>Financial Analysis</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Tentang Kami' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>tentang-kami.php">
                <i class="fas fa-info-circle"></i>
                <span>About Apps</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Customer Support' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>customer_support">
                <i class="fas fa-headset"></i>
                <span>Customer Support</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Laporan' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>laporan">
                <i class="fas fa-print"></i>
                <span>Recap Report</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Laporan Detail' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>detail_laporan">
                <i class="fas fa-print"></i>
                <span>Financial Report</span>
            </a>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="transactionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="nav-icon fas fa-database"></i>
        <span>Transaction Data</span>
    </a>
    <ul class="dropdown-menu" aria-labelledby="transactionDropdown">
        <li class="dropdown-item">
            <a href="<?= $base_url ?>sell" class="nav-link">
                <i class="fa fa-book nav-icon"></i>
                <span>Sales Data</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="<?= $base_url ?>buyyer" class="nav-link">
                <i class="fa fa-certificate nav-icon"></i>
                <span>Buy Data</span>
            </a>
        </li>
        <li class="dropdown-item">
            <a href="<?= $base_url ?>beban" class="nav-link">
                <i class="fa fa-plus nav-icon"></i>
                <span>Expense Data</span>
            </a>
        </li>
    </ul>
    <?php elseif ($account['role'] === 'user') : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Features
        </div>
        <li class="nav-item <?= $title === 'Piutang' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>piutang">
                <i class="fas fa-funnel-dollar"></i>
                <span>Piutang</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Pajak' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>pajak">
                <i class="fas fa-search-dollar"></i>
                <span>Pajak</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Tentang Kami' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>tentang-kami.php">
                <i class="fas fa-info-circle"></i>
                <span>About App</span>
            </a>
        </li>
        <li class="nav-item <?= $title === 'Customer Support' ? 'active' : '' ?>">
            <a class="nav-link" href="<?= $base_url ?>customer_support">
                <i class="fas fa-headset"></i>
                <span>Customer Support</span>
            </a>
        </li>
    <?php else : ?>
    <?php endif; ?>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>