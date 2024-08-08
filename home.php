<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <!-- Breadcrumb -->
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="index.php">Laundry</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <!-- Page Title -->
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Data Pelanggan -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="mdi mdi-account"></i>
                                </div>
                            </div>
                            <div class="col-8 text-center align-self-center">
                                <div class="m-l-1">
                                    <h5 class="mt-0 round-inner"><?= htmlspecialchars($jmlDataPelanggan); ?></h5>
                                    <p class="mb-0 text-muted">Data Pelanggan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Karyawan (hanya ditampilkan jika level admin) -->
            <?php if ($_SESSION['level'] == 'admin') : ?>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="mdi mdi-account-multiple"></i>
                                    </div>
                                </div>
                                <div class="col-8 text-center align-self-center">
                                    <div class="m-l-1">
                                        <h5 class="mt-0 round-inner"><?= htmlspecialchars($jmlDataUser); ?></h5>
                                        <p class="mb-0 text-muted">Data Karyawan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Transaksi Laundry -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="mdi mdi-cart"></i>
                                </div>
                            </div>
                            <div class="col-8 align-self-center text-center">
                                <div class="m-l-10">
                                    <h5 class="mt-0 round-inner"><?= htmlspecialchars($jmllaundry); ?></h5>
                                    <p class="mb-0 text-muted">Transaksi Laundry</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pengeluaran -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="col-3 align-self-center">
                                <div class="round">
                                    <i class="mdi mdi-cash"></i>
                                </div>
                            </div>
                            <div class="col-8 align-self-center text-center">
                                <div class="m-l-10">
                                    <h5 class="mt-0 round-inner"><?= htmlspecialchars($jmlpengeluaran); ?></h5>
                                    <p class="mb-0 text-muted">Data Pengeluaran</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Akun yang Sedang Login -->
        <div class="card mb-3" style="max-width: 520px;">
            <div class="row g-0">
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <!-- Tampilkan foto user jika ada, jika tidak tampilkan default -->
                    <?php if (!empty($tampilusers['userfoto'])) : ?>
                        <img src="fotouser/<?= htmlspecialchars($tampilusers['userfoto']); ?>" class="img-fluid rounded-start" alt="Foto Profil" style="width: 200px;">
                    <?php else : ?>
                        <img src="fotouser/default.svg" class="img-fluid rounded-start" alt="Foto Profil Default" style="width: 200px;">
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">Akun yang Sedang Login</h4>
                        <p class="card-text">
                            <b>Username:</b> <?= htmlspecialchars($tampilusers['username']); ?><br>
                            <b>Nama Lengkap:</b> <?= htmlspecialchars($tampilusers['nama']); ?><br>
                            <b>Role:</b> <?= htmlspecialchars($tampilusers['level']); ?>
                        </p>
                        <p class="card-text"><small class="text-muted">Waktu login: <?= date('d-m-Y H:i:s', strtotime($_SESSION['tgllogin'])); ?></small></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>