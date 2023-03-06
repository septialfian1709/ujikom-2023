<?php
// SESSION
session_start();
include('../../config/database.php');
if (empty($_SESSION['username'])) {
    @header('location:../modul-auth/index.php');
} else {
    if ($_SESSION['level'] == 'masyarakat') {
        $nik = $_SESSION['nik'];
    }
}
// CRUD
if (isset($_POST['tambahPengaduan'])) {
    $isi_laporan = $_POST['isi_laporan'];
    $tgl = $_POST['tgl_pengaduan'];
    //upload
    $ekstensi_diperbolehkan = array('jpg', 'png');
    $foto = $_FILES['foto']['name'];
    $x = explode(".", $foto);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['foto']['tmp_name'];
    if (!empty($foto)) {
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $q = "INSERT INTO `pengaduan`(id_pengaduan, tgl_pengaduan, nik, isi_laporan, foto, `status`) VALUES ('', '$tgl', '$nik', '$isi_laporan', '$foto', '0')";
            $r = mysqli_query($con, $q);
            if ($r) {
                move_uploaded_file($file_tmp, '../../assets/images/masyarakat/' . $foto);
            }
        }
    } else {
        $q = "INSERT INTO `pengaduan`(id_pengaduan, tgl_pengaduan, nik, isi_laporan, foto, `status`) VALUES ('', '$tgl', '$nik', '$isi_laporan', '', '0')";
        $r = mysqli_query($con, $q);
    }
}

// hapus pengaduan
if (isset($_POST['hapus'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    if ($id_pengaduan != '') {
        $q = "SELECT `foto` FROM `pengaduan` WHERE id_pengaduan = $id_pengaduan";
        $r = mysqli_query($con, $q);
        $d = mysqli_fetch_object($r);
        unlink('../../assets/images/masyarakat/' . $d->foto);
    }
    $q = "DELETE FROM `pengaduan` WHERE id_pengaduan = $id_pengaduan";
    $r = mysqli_query($con, $q);
}

// rubah status pengaduan
if (isset($_POST['proses_pengaduan'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $status = $_POST['status'];
    $q = "UPDATE `pengaduan` SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'";
    $r = mysqli_query($con, $q);
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include('../../assets/header.php') ?>


<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php include('../../assets/sidebar.php') ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="profil.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/img2.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Pengaduan Baru</h6>
                                        <small>10 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Pengaduan Baru</h6>
                                        <small>22 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Pengaduan Baru</h6>
                                        <small>1 hour ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">semuanya..../a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/no-hp.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">
                                <?php if ($_SESSION['level'] == 'masyarakat') { ?>
                                    <?= $_SESSION['nama'] ?>
                                <?php } ?>

                                <?php if ($_SESSION['level'] == 'petugas' || $_SESSION['level'] == 'admin') { ?>
                                    <?= $_SESSION['nama_petugas'] ?>
                                <?php } ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="index.php" class="dropdown-item">My Profile</a>
                            <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/sispemass/modul/modul-auth/logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Modul Pengaduan</h6>
                    <div class="table-responsive">
                        <?php if ($_SESSION['level'] == 'masyarakat') { ?>
                            <button type="button" data-toggle="modal" data-target="#modal-lg" class="btn btn-primary m-2">+ Pengaduan</i></button>
                        <?php } ?>


                        <!-- modal -->
                        <div class="modal fade" id="modal-lg">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Buat Pengaduan
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input hidden name="nik" value="">
                                            <div class="form-group">
                                                <label for="isi_laporan">Isi Laporan</label>
                                                <textarea name="isi_laporan" class="form-control" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_pengaduan">Tanggal Pengaduan</label>
                                                <input type="date" name="tgl_pengaduan" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="foto">Foto</label>
                                                <input type="file" name="foto" class="form-control">
                                            </div>
                                            <input type="submit" name="tambahPengaduan" value="simpan" class="btn btn-success">
                                        </form>
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->
                        <table class="table" id="dataTablesNya">
                            <thead>
                                <tr>
                                    <th scope="col" sttyle="text-align-center">No.</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">NIK</th>
                                    <th scope="col">Isi Laporan</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Status</th>
                                    <?php if ($_SESSION['level'] == 'masyarakat') { ?>

                                        <th scope="col">hapus</th>
                                    <?php } ?>

                                    <?php if ($_SESSION['level'] == 'petugas') { ?>
                                        <th scope="col">Proses Pengaduan</th>
                                    <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_SESSION['level'] == 'masyarakat') {
                                    $q = "SELECT * FROM `pengaduan` WHERE `nik` = $nik";
                                } else {
                                    $q = "SELECT * FROM `pengaduan`";
                                }
                                $r = mysqli_query($con, $q);
                                $no = 1;
                                while ($d = mysqli_fetch_object($r)) {
                                ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $d->tgl_pengaduan ?>
                                        </td>
                                        <td>
                                            <?= $d->nik ?>
                                        </td>
                                        <td>
                                            <?= $d->isi_laporan ?>
                                        </td>
                                        <td>
                                            <?php if ($d->foto == '') {
                                                echo '<img style="max-height:100px" class="img img-thumbnail" src="../../assets/images/no-foto.png">';
                                            } else {
                                                echo '<img style="max-height:100px" class="img img-thumbnail" src="../../assets/images/masyarakat/' . $d->foto . '">';
                                            } ?>
                                        </td>
                                        <td>
                                            <?= $d->status ?>
                                        </td>
                                        <?php if ($_SESSION['level'] == 'masyarakat') { ?>

                                            <td>
                                                <form action="" method="post"><input type="hidden" name="id_pengaduan" value="<?= $d->id_pengaduan ?>"><button type="submit" name="hapus" class="btn btn-danger"><i class="fa fa-trash"></i></button></form>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <?php if ($_SESSION['level'] == 'petugas') { ?>
                                                <form action="" method="post">
                                                    <input type="hidden" name="id_pengaduan" value="<?= $d->id_pengaduan ?>">
                                                    <select class="form-control" name="status">
                                                        <option value="0"> 0 </option>
                                                        <option value="proses"> proses </option>
                                                        <option value="selesai"> selesai </option>
                                                    </select><br>
                                                    <button type="submit" name="proses_pengaduan" class="btn btn-success">ubah</button>
                                                </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php $no++;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <?php include('../../assets/footer.php') ?>

</body>

</html>