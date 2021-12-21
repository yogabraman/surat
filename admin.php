<?php
ob_start();
//cek session
session_start();

if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
?>

    <!doctype html>
    <html lang="en">

    <!-- Include Head START -->
    <?php include('include/head.php'); ?>
    <!-- Include Head END -->

    <!-- Body START -->

    <body class="bg">

        <!-- Header START -->
        <header>

            <!-- Include Navigation START -->
            <?php include('include/menu.php'); ?>
            <!-- Include Navigation END -->

        </header>
        <!-- Header END -->

        <!-- Main START -->
        <main>

            <!-- container START -->
            <div class="container">

                <?php
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                    switch ($page) {
                        case 'tsm':
                            include "transaksi_surat_masuk.php";
                            break;
                        case 'txa':
                            include "transaksi_agenda.php";
                            break;
                        case 'lsa':
                            include "agenda_list.php";
                            break;
                        case 'ctk':
                            include "cetak_disposisi.php";
                            break;
                        case 'tsk':
                            include "transaksi_surat_keluar.php";
                            break;
                        case 'asm':
                            include "agenda_surat_masuk.php";
                            break;
                        case 'ask':
                            include "agenda_surat_keluar.php";
                            break;
                        case 'ref':
                            include "referensi.php";
                            break;
                        case 'spt':
                            include "spt.php";
                            break;
                        case 'sett':
                            include "pengaturan.php";
                            break;
                        case 'fsm':
                            include "file_sm.php";
                            break;
                        case 'fsk':
                            include "file_sk.php";
                            break;
                    }
                } else {
                ?>
                    <!-- Row START -->
                    <div class="row">

                        <!-- Include Header Instansi START -->
                        <?php include('include/header_instansi.php'); ?>
                        <!-- Include Header Instansi END -->

                        <!-- Welcome Message START -->
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <h4>Selamat Datang <?php echo $_SESSION['nama']; ?></h4>
                                    <p class="description">Anda login sebagai
                                        <?php
                                        if ($_SESSION['admin'] == 1) {
                                            echo "<strong>Admin</strong>. Anda memiliki akses penuh terhadap sistem.";
                                        } elseif ($_SESSION['admin'] == 4) {
                                            echo "<strong>Tata Usaha</strong>. Anda memiliki akses penuh terhadap sistem kecuali kelola user";
                                        } elseif ($_SESSION['admin'] == 2) {
                                            echo "<strong>Pimpinan</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                        } else {
                                            echo "<strong>Pegawai</strong>. Berikut adalah statistik data yang tersimpan dalam sistem.";
                                        } ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Welcome Message END -->

                        <?php
                        //menghitung jumlah surat masuk
                        $count1 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_masuk"));

                        //menghitung jumlah surat keluar
                        $count2 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_keluar"));

                        //menghitung jumlah disposisi
                        $count3 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE status_dispo=0"));

                        //menghitung jumlah disposisi
                        $count4 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE status_dispo=1"));

                        //menghitung jumlah klasifikasi
                        $count5 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_klasifikasi"));

                        //menghitung jumlah user
                        $count6 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_user"));
                        ?>

                        <!-- Info Statistic START -->
                        <div class="col s12 m4">
                            <div class="card blue-grey ">
                                <div class="card-content">
                                    <span class="card-title white-text"><i class="material-icons md-36">mail</i> Jumlah Surat Masuk</span>
                                    <?php echo '<h5 class="white-text link">' . $count1 . ' Surat Masuk</h5>'; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col s12 m4">
                            <div class="card blue-grey">
                                <div class="card-content">
                                    <span class="card-title white-text"><i class="material-icons md-36">drafts</i> Jumlah Surat Keluar</span>
                                    <?php echo '<h5 class="white-text link">' . $count2 . ' Surat Keluar</h5>'; ?>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 4 || $_SESSION['admin'] == 3) { ?>
                            <div class="col s12 m4">
                                <div class="card blue-grey">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">inbox</i> Jumlah Belum Disposisi</span>
                                        <?php echo '<h5 class="white-text link">' . $count3 . ' Disposisi</h5>'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 4 || $_SESSION['admin'] == 3) { ?>
                            <div class="col s12 m4">
                                <div class="card blue-grey">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">description</i> Jumlah Disposisi</span>
                                        <?php echo '<h5 class="white-text link">' . $count4 . ' Disposisi</h5>'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 4) { ?>
                            <div class="col s12 m4">
                                <div class="card blue-grey">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">class</i> Jumlah Klasifikasi Surat</span>
                                        <?php echo '<h5 class="white-text link">' . $count5 . ' Klasifikasi Surat</h5>'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 4) { ?>
                            <div class="col s12 m4">
                                <div class="card blue-grey">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">people</i> Jumlah Pengguna</span>
                                        <?php echo '<h5 class="white-text link">' . $count6 . ' Pengguna</h5>'; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Info Statistic START -->
                        <?php
                        }
                        ?>

                    </div>
                    <!-- Row END -->
                <?php
                }
                ?>
            </div>
            <!-- container END -->

        </main>
        <!-- Main END -->

        <!-- Include Footer START -->
        <?php include('include/footer.php'); ?>
        <!-- Include Footer END -->

    </body>
    <!-- Body END -->

    </html>

<?php
}
?>