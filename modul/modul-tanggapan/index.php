<?php
// SESSION
session_start();
include('../../config/database.php');
if (empty($_SESSION['username'])) {
    @header('location:../modul-auth/index.php');
} else {
    if ($_SESSION['level'] == 'masyarakat') {
        $nik = $_SESSION['nik'];
    } else {
        $id_petugas = $_SESSION['id_petugas'];
    }
}
// tambah tanggapan
if (isset($_POST['tambah_tanggapan'])) {
    $id_pengaduan = $_POST['id_pengaduan'];
    $tgl_tanggapan = $_POST['tgl_tanggapan'];
    $id_petugas = $_POST['id_petugas'];
    $tanggapan = $_POST['tanggapan'];
    $q = "INSERT INTO `tanggapan` (id_tanggapan, id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES ('','$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')";
    $r = mysqli_query($con, $q);
}
// hapus tanggapan
if (isset($_POST['hapusTanggapan'])) {
    $id_tanggapan = $_POST['id_tanggapan'];
    mysqli_query($con, "DELETE FROM `tanggapan` WHERE id_tanggapan = '$id_tanggapan'");
}
// update tanggapan
if (isset($_POST['ubahTanggapan'])) {
    $id_tanggapan =  $_POST['id_tanggapan'];
    $tgl_tanggapan = $_POST['tgl_tanggapan'];
    $tanggapan = $_POST['tanggapan'];
    mysqli_query($con, "UPDATE `tanggapan` SET tgl_tanggapan = '$tgl_tanggapan', tanggapan = '$tanggapan' WHERE `id_tanggapan` = '$id_tanggapan'");
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
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
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
                                    <img class="rounded-circle" src="img/no-hp.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Tanggapan Baru</h6>
                                        <small>2 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/no-hp.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Tanggapan Baru</h6>
                                        <small>5 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/no-hp.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Tanggapan Baru</h6>
                                        <small>30 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
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

            <!-- content start-->
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4"> Modul Tanggapan</h6>
                    <?php if ($_SESSION['level'] == 'petugas') { ?>
                        <button type="button" class="btn btn-success m-2" data-toggle="modal" data-target="#addRowModal">+ Tanggapan</button>
                    <?php } ?>

                    <!-- Modal -->
                    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header no-bd">
                                    <h5 class="modal-title">
                                        <span class="fw-mediumbold">
                                            Add</span>
                                        <span class="fw-light">
                                            Tanggapan
                                        </span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input class="form-control" name="id_tanggapan" type="hidden">
                                                <div class="form-group form-group-default">
                                                    <label for="id_pengaduan"> Beri Tanggapan</label>
                                                    <textarea class="form-control" name="tanggapan" id="" cols="30" rows="10"></textarea>
                                                </div>

                                                <div class="form-group form-group-default">
                                                    <label for="id_pengaduan"> Pilih Id Pengaduan</label>
                                                    <select name="id_pengaduan" class="form-control">
                                                        <?php
                                                        $q = "SELECT * FROM pengaduan JOIN `masyarakat` WHERE pengaduan.nik = masyarakat.nik";
                                                        $r = mysqli_query($con, $q);
                                                        while ($d = mysqli_fetch_object($r)) { ?>
                                                            <option value="<?= $d->id_pengaduan ?>"><?= $d->id_pengaduan . '|' . $d->nik . '|' . $d->nama ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pr-0">
                                                <div class="form-group form-group-default">
                                                    <label>Tanggal</label>
                                                    <input class="form-control" type="date" name="tgl_tanggapan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>ID Petugas</label>
                                                    <input name="id_petugas" type="text" class="form-control" value="<?= $id_petugas ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer no-bd">
                                            <button name="tambah_tanggapan" type="submit" id="addRowButton" class="btn btn-primary">Tambahkan</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">

                        <table class="table" id="dataTablesNya">
                            <thead>
                                <tr>
                                    <th scope="col" sttyle="text-align-center">No</th>
                                    <th scope="col">ID Pengaduan</th>
                                    <th scope="col">Tanggal Tanggapan</th>
                                    <th scope="col">Isi Tanggapan</th>
                                    <th scope="col">Petugas</th>
                                    <?php if ($_SESSION['level'] == 'petugas') { ?>
                                        <th scope="col">hapus</th>
                                        <th scope="col">edit</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $q = "SELECT * FROM `tanggapan` JOIN `petugas` JOIN `pengaduan`
                             WHERE tanggapan.id_petugas = petugas.id_petugas 
                             AND tanggapan.id_pengaduan = pengaduan.id_pengaduan";
                                $r = mysqli_query($con, $q);
                                while ($d = mysqli_fetch_object($r)) { ?>
                                    <tr>
                                        <td>
                                            <?= $no ?>
                                        </td>
                                        <td>
                                            <?= $d->id_pengaduan ?>
                                        </td>
                                        <td>
                                            <?= $d->tgl_tanggapan ?>
                                        </td>
                                        <td>
                                            <?= $d->tanggapan ?>
                                        </td>
                                        <td>
                                            <?= $d->nama_petugas ?>
                                        </td>
                                        <?php if ($_SESSION['level'] == 'petugas') { ?>
                                            <td>
                                                <form action="" method="post"><input type="hidden" name="id_tanggapan" value="<?= $d->id_tanggapan ?>"><button name="hapusTanggapan" class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>&nbsp;hapus</button></form>
                                            </td>
                                        <?php } ?>
                                        <?php if ($_SESSION['level'] == 'petugas') { ?>
                                            <td>
                                                <button class="btn btn-success" data-toggle="modal" data-target="#modal-lg<?= $d->id_pengaduan ?>" class="btn btn-success"><i class="fa fa-pen"></i>&nbsp;Edit</button>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <div class="modal fade" id="modal-lg<?= $d->id_pengaduan ?>">
                                        <div class="modal-dialog modal-lg<?= $d->id_pengaduan ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    Edit Pengaduan
                                                </div>
                                                <form a ction="" method="post">
                                                    <div class="modal-body">
                                                        <input class="form-control" name="id_tanggapan" type="hidden" value="<?= $d->id_tanggapan ?>">
                                                        <label for="id_pengaduan">ID Pengaduan</label><br>
                                                        <select class="form-control" name="id_pengaduan">
                                                            <?php
                                                            $result = mysqli_query($con, "SELECT * FROM `pengaduan` JOIN `masyarakat` WHERE pengaduan.nik = masyarakat.nik");
                                                            while ($data = mysqli_fetch_object($result)) { ?>
                                                                <option value="<?= $data->id_pengaduan ?>" <?php if ($d->id_pengaduan == $data->id_pengaduan) {
                                                                                                                echo 'selected';
                                                                                                            } ?>><?= $data->id_pengaduan . '|' . $data->nik . '|' . $data->nama ?></option>
                                                            <?php } ?>
                                                        </select><br>
                                                        <label for="tgl_tanggapan">Tanggal Tanggapan</label>
                                                        <input class="form-control" name="tgl_tanggapan" class="form-control" type="date" name="" value="<?= $d->tgl_tanggapan ?>">
                                                        <label for="tanggapan">Tanggapan</label>
                                                        <textarea class="form-control" name="tanggapan" id="" cols="30" rows="10"><?= $d->tanggapan ?></textarea>
                                                        <br>
                                                        <button name="ubahTanggapan" type="submit" class="btn btn-info">Update</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
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