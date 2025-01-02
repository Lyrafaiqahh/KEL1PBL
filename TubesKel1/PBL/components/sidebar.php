<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class='sidebar-brand' href='index.php'>
            <span class="align-middle">SiBeta</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'dashboard' ? 'active' : ''  ?>">
                <a class='sidebar-link' href='dashboard.php'>
                    <i class="align-middle fa fa-home" aria-hidden="true""></i> <span class="fs -4 ms -3 align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'skkm' ? 'active' : ''  ?>">
                <a class='sidebar-link' href='skkm.php'>
                    <i class="align-middle fa fa-file" aria-hidden="true"></i> <span class="fs -4 ms -3 align-middle">SKKM</span>
                </a>
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'kompen' ? 'active' : ''  ?>">
                <a class='sidebar-link' href='kompen.php'>
                    <i class="align-middle fa fa-file" aria-hidden="true"></i> <span class="fs -4 ms -3 align-middle">KOMPENSASI</span>
                </a>
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'pkl' ? 'active' : ''  ?>">
                <a class='sidebar-link' href='pkl.php'>
                    <i class="align-middle fa fa-file" aria-hidden="true"></i> <span class="fs -4 ms -3 align-middle">PKL</span>
                </a>
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'skripsi' ? 'active' : ''  ?>">
                <a class='sidebar-link' href='skripsi.php'>
                    <i class="align-middle fa fa-file" aria-hidden="true"></i> <span class="fs -4 ms -3 align-middle">SKRIPSI</span>
                </a>
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'formbeta' ? 'active' : ''  ?>">
                <a class='sidebar-link' href='formbeta.php'>
                    <i class="align-middle  fa fa-file" aria-hidden="true"></i> <span class="fs- 4 ms- 3 align-middle">FORM BETA</span>
                </a>
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'faq' ? 'active' : ''  ?>">
                <a class='sidebar-link' href='faq.php'>
                    <i class="align-middle  fa fa-question-circle" aria-hidden="true"></i> <span class="fs- 4 ms- 3 align-middle">FAQ</span>
                </a>
            </li>

        </ul>
    </div>
</nav>