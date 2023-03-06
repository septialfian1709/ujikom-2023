<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">SISPEMAS</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/pict2.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0"></h6>
                <span><?= $_SESSION['username'] ?></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <?php if ($_SESSION['level'] == 'masyarakat') { ?>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-pengaduan" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Pengaduan</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-tanggapan" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Tanggapan</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-auth/logout.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Logout</a>
            <?php } ?>

            <?php if ($_SESSION['level'] == 'admin') { ?>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-masyarakat" class="nav-item nav-link active"><i class="fa fa-user-edit me-2"></i></i>Masyarakat</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-pengaduan" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Pengaduan</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-tanggapan" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Tanggapan</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-petugas" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Petugas</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-auth/logout.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Logout</a>
            <?php } ?>


            <?php if ($_SESSION['level'] == 'petugas') { ?>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-pengaduan" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Pengaduan</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-tanggapan" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Tanggapan</a>
                <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-auth/logout.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Logout</a>
            <?php } ?>



        </div>
    </nav>
</div>