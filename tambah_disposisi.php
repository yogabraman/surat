<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $id_surat = $_REQUEST['id_surat'];
        $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");
        $no = 1;
        $colNames = mysqli_fetch_array($query);
        // list($id_surat) = mysqli_fetch_array($query);

        //validasi form kosong
        if (
            $_REQUEST['tujuan'] == "" ||
            $_REQUEST['isi_disposisi'] == "" ||
            $_REQUEST['sifat'] == "" ||
            // $_REQUEST['tgl_dispo'] == "" || 
            $_REQUEST['catatan'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $tujuan = json_encode($_REQUEST['tujuan']);
            $perintah = json_encode($_REQUEST['perintah']);
            $isi_disposisi = $_REQUEST['isi_disposisi'];
            $sifat = $_REQUEST['sifat'];
            // $tgl_dispo = $_REQUEST['tgl_dispo'];
            $catatan = $_REQUEST['catatan'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            // if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $tujuan)) {
            //     $_SESSION['tujuan'] = 'Form Tujuan Disposisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,) minus(-). kurung() dan garis miring(/)';
            //     echo '<script language="javascript">window.history.back();</script>';
            // } else {

            if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi_disposisi)) {
                $_SESSION['isi_disposisi'] = 'Form Isi Disposisi hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan(&), underscore(_), kurung(), persen(%) dan at(@)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                // if (!preg_match("/^[0-9 -]*$/", $tgl_dispo)) {
                //     $_SESSION['tgl_dispo'] = 'Form Batas Waktu hanya boleh mengandung karakter huruf dan minus(-)<br/>';
                //     echo '<script language="javascript">window.history.back();</script>';
                // } else {

                if (!preg_match("/^[a-zA-Z0-9.,()%@\/ -]*$/", $catatan)) {
                    $_SESSION['catatan'] = 'Form catatan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-) garis miring(/), dan kurung()';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0 ]*$/", $sifat)) {
                        $_SESSION['sifat'] = 'Form SIFAT hanya boleh mengandung karakter huruf dan spasi';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {
                        //tipe surat
                        $tipe = $colNames['tipe_surat'];

                        $query = mysqli_query($config, "INSERT INTO tbl_disposisi(tujuan,perintah,isi_disposisi,sifat,tgl_dispo,catatan,id_surat,id_user)
                                        VALUES('$tujuan','$perintah','$isi_disposisi','$sifat',NOW(),'$catatan','$id_surat','$id_user')");

                        $query_dispo = mysqli_query($config, "UPDATE tbl_surat_masuk SET status_dispo=1 WHERE id_surat='$id_surat'");

                        if ($query == true) {
                            if ($tipe == 1) {
                                $query_und = mysqli_query($config, "UPDATE tbl_agenda SET dispo='$tujuan' WHERE id_surat='$id_surat'");
                            }
                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                            echo '<script language="javascript">
                                                window.location.href="./admin.php?page=tsm&act=disp&id_surat=' . $id_surat . '";
                                              </script>';
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query disposisi';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    }
                }
                // }
            }
            // }
        }
    } else { ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">description</i> Tambah Disposisi Surat</a></li>
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

            <!-- Form START -->
            <form class="col s12" method="post" action="">
                <div class="col s12">
                    <div class="card blue lighten-5">
                        <div class="card-content">
                            <p class="description">Lihat Dokumen: </p> 
                            <?php 
                                // echo $_REQUEST['id_surat']; 
                                $id_surat = mysqli_real_escape_string($config, $_REQUEST['id_surat']);
                                $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");
                                if(mysqli_num_rows($query) > 0){
                                    while($row = mysqli_fetch_array($query)){
                                        if(empty($row['file'])){
                                            echo '';
                                        } else {
                                            $files = explode('-', $row['file']);
                                            echo '<a class="blue-text" href="./upload/surat_masuk/'.$row['file'].'" target="_blank">'.$files[1].'</a>';
                                        }
                                    }
                                }
                            ?> 
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">supervisor_account</i><label>Kepada Yth:</label><br />
                        <?php
                        $query = mysqli_query($config, "SELECT * FROM tbl_struktural");
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
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
                        $query = mysqli_query($config, "SELECT * FROM tbl_perintah");
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
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
                            <input id="tgl_dispo" type="text" name="tgl_dispo" class="datepicker" required>
                                <?php
                                if (isset($_SESSION['tgl_dispo'])) {
                                    $tgl_dispo = $_SESSION['tgl_dispo'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_dispo . '</div>';
                                    unset($_SESSION['tgl_dispo']);
                                }
                                ?>
                            <label for="tgl_dispo">Batas Waktu</label>
                        </div> -->
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">description</i>
                        <textarea id="isi_disposisi" class="materialize-textarea validate" name="isi_disposisi"></textarea>
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
                        <input id="catatan" type="text" class="validate" name="catatan">
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
                            <select class="browser-default validate" name="sifat" id="sifat">
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
                </div>
                <!-- Row in form END -->

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <button type="reset" onclick="window.history.back();" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></button>
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