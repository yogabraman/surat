<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['tgl_berangkat'] == "" ||
            $_REQUEST['pegawai'] == "" ||
            $_REQUEST['tgl_pulang'] == "" ||
            $_REQUEST['nama_kab'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $tgl_berangkat = $_REQUEST['tgl_berangkat'];
            $pegawai = $_REQUEST['pegawai'];
            $tgl_pulang = $_REQUEST['tgl_pulang'];
            $tujuan = $_REQUEST['nama_kab'];

            //cek tanggal berangkat
            $cek_brgkt = mysqli_query($config, "SELECT * FROM `tbl_spt` WHERE pegawai LIKE '%$pegawai%' AND ((tgl_berangkat='$tgl_berangkat') OR (tgl_pulang='$tgl_berangkat'))");
            $result1 = mysqli_num_rows($cek_brgkt);

            if ($result1 > 0) {
                $_SESSION['tgl_berangkat'] = 'Tanggal sudah dipakai!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {
                //cek tanggal pulang
                $cek_plg = mysqli_query($config, "SELECT * FROM `tbl_spt` WHERE pegawai LIKE '%$pegawai%' AND ((tgl_berangkat='$tgl_pulang') OR (tgl_pulang='$tgl_pulang'))");
                $result2 = mysqli_num_rows($cek_plg);

                if ($result2 > 0) {
                    $_SESSION['tgl_pulang'] = 'Tanggal sudah dipakai!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {
                    //tombol simpan akan mengeksekusi script dibawah ini
                    $query = mysqli_query($config, "INSERT INTO tbl_spt(tgl_berangkat,tgl_pulang,pegawai,tujuan) 
                    VALUES('$tgl_berangkat','$tgl_pulang','$pegawai','$tujuan')");

                    if ($query == true) {
                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                        header("Location: ./admin.php?page=spt");
                        die();
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">window.history.back();</script>';
                    }
                }
            }
        }
    } else { ?>

        <!-- Tampilan Tambah Surat -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=spt&act=add" class="judul"><i class="material-icons">event</i> Tambah SPT</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Secondary Nav END -->
        </div>
        <!-- Row END -->

        <?php
        if (isset($_SESSION['errQ'])) {
            $errQ = $_SESSION['errQ'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['errQ']);
        }
        if (isset($_SESSION['errEmpty'])) {
            $errEmpty = $_SESSION['errEmpty'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errEmpty . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['errEmpty']);
        }
        ?>

        <!-- Row form Start -->
        <div class="row jarak-form">

            <form class="col s12" method="POST" action="?page=spt&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_berangkat" type="text" name="tgl_berangkat" class="datepicker" required>
                        <?php
                        if (isset($_SESSION['tgl_berangkat'])) {
                            $tgl_berangkat = $_SESSION['tgl_berangkat'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_berangkat . '</div>';
                            unset($_SESSION['tgl_berangkat']);
                        }
                        ?>
                        <label for="tgl_berangkat">Tanggal Berangkat</label>
                    </div>
                    <!-- <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">people</i>
                        <input id="pegawai" type="text" class="validate" name="pegawai" required>
                        <?php
                        if (isset($_SESSION['pegawai'])) {
                            $pegawai = $_SESSION['pegawai'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pegawai . '</div>';
                            unset($_SESSION['pegawai']);
                        }
                        ?>
                        <label for="pegawai">Pegawai</label>
                    </div> -->
                    <div class="control-group after-add-more">
                        <div class="input-field col s4 after-add-more">
                            <i class="material-icons prefix md-prefix">people</i>
                            <input id="pegawai" type="text" class="validate" name="pegawai" required>
                            <?php
                            if (isset($_SESSION['pegawai'])) {
                                $pegawai = $_SESSION['pegawai'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pegawai . '</div>';
                                unset($_SESSION['pegawai']);
                            }
                            ?>
                            <label for="pegawai">Pegawai</label>
                        </div>
                        <button class="btn btn-success add-more" type="button">
                            <i class="glyphicon glyphicon-plus"></i> Add
                        </button>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_pulang" type="text" name="tgl_pulang" class="datepicker" required>
                        <?php
                        if (isset($_SESSION['tgl_pulang'])) {
                            $tgl_pulang = $_SESSION['tgl_pulang'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_pulang . '</div>';
                            unset($_SESSION['tgl_pulang']);
                        }
                        ?>
                        <label for="tgl_pulang">Tanggal Pulang</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">place</i>
                        <input id="nama_kab" type="text" class="validate" name="nama_kab" required>
                        <?php
                        if (isset($_SESSION['tujuan'])) {
                            $tujuan = $_SESSION['tujuan'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tujuan . '</div>';
                            unset($_SESSION['tujuan']);
                        }
                        ?>
                        <label for="nama_kab">Tujuan</label>
                    </div>
                </div>
                <!-- Row in form END -->

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=spt" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                    </div>
                </div>

            </form>
            <!-- Form END -->

        </div>
        <!-- Row form END -->

<?php
    }
}
?>