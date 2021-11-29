<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_surat = $_REQUEST['id_surat'];
        echo '$id_surat';
        $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");
        // list($id_surat) = mysqli_fetch_array($query);
        $colNames = mysqli_fetch_array($query);

        //validasi form kosong
        if (
            $_REQUEST['tujuan'] == "" ||
            $_REQUEST['isi_disposisi'] == "" ||
            $_REQUEST['sifat'] == "" ||
            // $_REQUEST['tgl_dispo'] == ""|| 
            $_REQUEST['catatan'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_disposisi = $_REQUEST['id_disposisi'];
            $tujuan = json_encode($_REQUEST['tujuan']);
            $perintah = json_encode($_REQUEST['perintah']);
            $isi_disposisi = $_REQUEST['isi_disposisi'];
            $sifat = $_REQUEST['sifat'];
            // $tgl_dispo = $_REQUEST['tgl_dispo'];
            $catatan = $_REQUEST['catatan'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            // if(!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $tujuan)){
            //     $_SESSION['tujuan'] = 'Form Tujuan Disposisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
            //     echo '<script language="javascript">window.history.back();</script>';
            // } else {

            if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi_disposisi)) {
                $_SESSION['isi_disposisi'] = 'Form Isi Disposisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                // if(!preg_match("/^[0-9 -]*$/", $tgl_dispo)){
                //     $_SESSION['tgl_dispo'] = 'Form Tanggal Disposisi hanya boleh mengandung karakter huruf dan minus(-)';
                //     echo '<script language="javascript">window.history.back();</script>';
                // } else {

                if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $catatan)) {
                    $_SESSION['catatan'] = 'Form catatan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-) garis miring(/), dan kurung()';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0 ]*$/", $sifat)) {
                        $_SESSION['catatan'] = 'Form SIFAT hanya boleh mengandung karakter huruf dan spasi';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {
                        //tipe surat
                        $tipe = $colNames['tipe_surat'];

                        $query = mysqli_query($config, "UPDATE tbl_disposisi SET tujuan='$tujuan', perintah='$perintah', isi_disposisi='$isi_disposisi', sifat='$sifat', tgl_dispo=NOW(), catatan='$catatan', id_surat='$id_surat', id_user='$id_user' WHERE id_disposisi='$id_disposisi'");

                        if ($query == true) {
                            if($tipe==1){
                                $query_und = mysqli_query($config, "UPDATE tbl_agenda SET dispo='$tujuan' WHERE id_surat='$id_surat'");
                            }
                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                            echo '<script language="javascript">
                                                window.location.href="./admin.php?page=tsm&act=disp&id_surat=' . $id_surat . '";
                                              </script>';
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    }
                }
                // }
            }
            // }
        }
    } else {

        $id_disposisi = mysqli_real_escape_string($config, $_REQUEST['id_disposisi']);
        $query = mysqli_query($config, "SELECT * FROM tbl_disposisi WHERE id_disposisi='$id_disposisi'");
        if (mysqli_num_rows($query) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_array($query)) { ?>

                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Disposisi Surat</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
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
                ?>

                <!-- Row form Start -->
                <div class="row jarak-form">

                    <!-- Form START -->
                    <form class="col s12" method="post" action="">

                        <!-- Row in form START -->
                        <div class="row">
                            <input type="hidden" value="<?php echo $row['id_disposisi']; ?>">
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">supervisor_account</i><label>Kepada Yth:</label><br />
                                <?php
                                $query_struk = mysqli_query($config, "SELECT * FROM tbl_struktural");
                                if (mysqli_num_rows($query_struk) > 0) {
                                    while ($row = mysqli_fetch_array($query_struk)) {
                                ?>
                                        <input id="struk_<?= $row['id_struk'] ?>" type="checkbox" class="validate" name="tujuan[]" value="<?= $row['nama'] ?>">
                                        <label for="struk_<?= $row['id_struk'] ?>"><?= $row['nama'] ?></label>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">assignment</i><label>Untuk :</label><br />
                                <?php
                                $query_per = mysqli_query($config, "SELECT * FROM tbl_perintah");
                                if (mysqli_num_rows($query_per) > 0) {
                                    while ($row = mysqli_fetch_array($query_per)) {
                                ?>
                                        <input id="<?= $row['id_perintah'] ?>" type="checkbox" class="validate" name="perintah[]" value="<?= $row['perintah'] ?>">
                                        <label for="<?= $row['id_perintah'] ?>"><?= $row['perintah'] ?></label>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">alarm</i>
                                <input id="tgl_dispo" type="text" name="tgl_dispo" class="datepicker" value="<?php echo $row['tgl_dispo']; ?>"required>
                                    <?php
                                    if (isset($_SESSION['tgl_dispo'])) {
                                        $tgl_dispo = $_SESSION['tgl_dispo'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_dispo . '</div>';
                                        unset($_SESSION['tgl_dispo']);
                                    }
                                    ?>
                                <label for="tgl_dispo">Tanggal Disposisipo</label>
                            </div> -->
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">description</i>
                                <textarea id="isi_disposisi" class="materialize-textarea validate" name="isi_disposisi" required><?php echo $row['isi_disposisi']; ?></textarea>
                                <?php
                                if (isset($_SESSION['isi_disposisi'])) {
                                    $isi_disposisi = $_SESSION['isi_disposisi'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $isi_disposisi . '</div>';
                                    unset($_SESSION['isi_disposisi']);
                                }
                                ?>
                                <label for="isi_disposisi">Isi Disposisi</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">featured_play_list </i>
                                <input id="catatan" type="text" class="validate" name="catatan" value="<?php echo $row['catatan']; ?>" required>
                                <?php
                                if (isset($_SESSION['catatan'])) {
                                    $catatan = $_SESSION['catatan'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $catatan . '</div>';
                                    unset($_SESSION['catatan']);
                                }
                                ?>
                                <label for="catatan">Catatan</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">low_priority</i><label>Pilih Sifat Disposisi</label><br />
                                <div class="input-field col s11 right">
                                    <select class="browser-default validate" name="sifat" id="sifat" required>
                                        <option value="<?php echo $row['sifat']; ?>"><?php echo $row['sifat']; ?></option>
                                        <option value="Biasa">Biasa</option>
                                        <option value="Penting">Penting</option>
                                        <option value="Segera">Segera</option>
                                        <option value="Rahasia">Rahasia</option>
                                    </select>
                                </div>
                                <?php
                                if (isset($_SESSION['sifat'])) {
                                    $sifat = $_SESSION['sifat'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $sifat . '</div>';
                                    unset($_SESSION['sifat']);
                                }
                                ?>
                            </div>
                            <!-- Row in form END -->

                            <div class="row">
                                <div class="col 6">
                                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                </div>
                                <div class="col 6">
                                    <a href="?page=tsm&act=disp&id_surat=<?php echo $row['id_surat']; ?>" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                </div>
                            </div>

                    </form>
                    <!-- Form END -->

                </div>
                <!-- Row form END -->

<?php
            }
        }
    }
}
?>