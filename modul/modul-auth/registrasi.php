<?php
include('../../config/database.php');
if (isset($_POST['simpan'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $telp = $_POST['telp'];
    $q = mysqli_query($con, "INSERT INTO `masyarakat` (nik, nama, username, password, telp, verifikasi) VALUES ('$nik', '$nama', '$username', '$password', '$telp', 0)");
    if ($q) {
        echo '<div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                Registrasi Berhasil Tunggu verifikasi oleh admin
                </div>';
    }
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


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <form action="" method="post">

                        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <a class="">
                                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>REGISTER</h3>
                                </a>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="nama" id="floatingText" placeholder="jhondoe">
                                <label for="floatingText">Nama Lengkap KTP</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="nik" id="floatingText" placeholder="jhondoe">
                                <label for="floatingText">nik</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" name="telp" id="floatingPassword" placeholder="no telp">
                                <label for="floatingPassword">No Telepon</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                            </div>
                            <button name="simpan" type="simpan" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                            <p class="text-center mb-0">sudah mempunyai akun? <a href="index.php">login</a></p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <?php include('../../assets/footer.php') ?>

</body>

</html>