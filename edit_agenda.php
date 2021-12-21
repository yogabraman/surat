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
            $_REQUEST['no_agenda'] == "" || $_REQUEST['no_surat'] == "" || $_REQUEST['asal_surat'] == "" || $_REQUEST['isi'] == ""
            || $_REQUEST['kode'] == "" || $_REQUEST['tgl_surat'] == ""  || $_REQUEST['keterangan'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_agenda = $_REQUEST['no_agenda'];
            $no_surat = $_REQUEST['no_surat'];
            $asal_surat = $_REQUEST['asal_surat'];
            $isi = $_REQUEST['isi'];
            $kode = substr($_REQUEST['kode'], 0, 30);
            $nkode = trim($kode);
            $tgl_surat = $_REQUEST['tgl_surat'];
            $keterangan = $_REQUEST['keterangan'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[0-9]*$/", $no_agenda)) {
                $_SESSION['eno_agenda'] = 'Form Nomor Agenda harus diisi angka!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_surat)) {
                    $_SESSION['eno_surat'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $asal_surat)) {
                        $_SESSION['easal_surat'] = 'Form Asal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-),kurung() dan garis miring(/)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi)) {
                            $_SESSION['eisi'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9., ]*$/", $nkode)) {
                                $_SESSION['ekode'] = 'Form Kode Klasifikasi hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan koma(,)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (!preg_match("/^[0-9.-]*$/", $tgl_surat)) {
                                    $_SESSION['etgl_surat'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $keterangan)) {
                                        $_SESSION['eketerangan'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
                                        $file = $_FILES['file']['name'];
                                        $x = explode('.', $file);
                                        $eks = strtolower(end($x));
                                        $ukuran = $_FILES['file']['size'];
                                        $target_dir = "upload/surat_masuk/";

                                        //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                        if ($file != "") {

                                            $rand = rand(1, 10000);
                                            $nfile = $rand . "-" . $file;

                                            //validasi file
                                            if (in_array($eks, $ekstensi) == true) {
                                                if ($ukuran < 2300000) {

                                                    $id_surat = $_REQUEST['id_surat'];
                                                    $query = mysqli_query($config, "SELECT file FROM tbl_surat_masuk WHERE id_surat='$id_surat'");
                                                    list($file) = mysqli_fetch_array($query);

                                                    //jika file tidak kosong akan mengeksekusi script dibawah ini
                                                    if (!empty($file)) {
                                                        unlink($target_dir . $file);

                                                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                                        $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_agenda='$no_agenda',no_surat='$no_surat',asal_surat='$asal_surat',isi='$isi',kode='$nkode',tgl_surat='$tgl_surat',file='$nfile',keterangan='$keterangan',id_user='$id_user' WHERE id_surat='$id_surat'");

                                                        if ($query == true) {
                                                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                            header("Location: ./admin.php?page=txa");
                                                            die();
                                                        } else {
                                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        }
                                                    } else {

                                                        //jika file kosong akan mengeksekusi script dibawah ini
                                                        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                                        $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_agenda='$no_agenda',no_surat='$no_surat',asal_surat='$asal_surat',isi='$isi',kode='$nkode',tgl_surat='$tgl_surat',file='$nfile',keterangan='$keterangan',id_user='$id_user' WHERE id_surat='$id_surat'");

                                                        if ($query == true) {
                                                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                            header("Location: ./admin.php?page=txa");
                                                            die();
                                                        } else {
                                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        }
                                                    }
                                                } else {
                                                    $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                }
                                            } else {
                                                $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            }
                                        } else {

                                            //jika form file kosong akan mengeksekusi script dibawah ini
                                            $id_surat = $_REQUEST['id_surat'];

                                            $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_agenda='$no_agenda',no_surat='$no_surat',asal_surat='$asal_surat',isi='$isi',kode='$nkode',tgl_surat='$tgl_surat',keterangan='$keterangan',id_user='$id_user' WHERE id_surat='$id_surat'");

                                            if ($query == true) {
                                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                header("Location: ./admin.php?page=txa");
                                                die();
                                            } else {
                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {

        $id_agenda = mysqli_real_escape_string($config, $_REQUEST['id_agenda']);
        $query = mysqli_query($config, "SELECT id_agenda, asal, isi, tgl_agenda, waktu_agenda, tempat, dispo, id_user FROM tbl_agenda WHERE id_agenda='$id_agenda'");
        list($id_agenda, $asal, $isi, $tgl_agenda, $waktu_agenda, $tempat, $dispo, $id_user) = mysqli_fetch_array($query);

        if ($_SESSION['id_user'] != $id_user and $_SESSION['id_user'] != 1 and $_SESSION['admin'] != 4) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=txa";
                  </script>';
        } else { ?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Data Agenda</a></li>
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
                <form class="col s12" method="POST" action="?page=txa&act=edit" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_agenda" type="text" name="tgl_agenda" class="datepicker"  value="<?php echo $tgl_agenda ;?>" required>
                            <?php
                            if (isset($_SESSION['tgl_agenda'])) {
                                $tgl_agenda = $_SESSION['tgl_agenda'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_agenda . '</div>';
                                unset($_SESSION['tgl_agenda']);
                            }
                            ?>
                            <label for="tgl_agenda">Tanggal Acara</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">place</i>
                            <input id="tempat" type="text" class="validate" name="tempat"  value="<?php echo $tempat ;?>" required>
                            <?php
                            if (isset($_SESSION['tempat'])) {
                                $tempat = $_SESSION['tempat'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tempat . '</div>';
                                unset($_SESSION['tempat']);
                            }
                            ?>
                            <label for="tempat">Tempat Acara</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">alarm</i><br><br><label>Waktu Acara :</label>
                            <input id="waktu_agenda" type="time" name="waktu_agenda" class=""  value="<?php echo $waktu_agenda ;?>" required>
                            <?php
                            if (isset($_SESSION['waktu_agenda'])) {
                                $waktu_agenda = $_SESSION['waktu_agenda'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $waktu_agenda . '</div>';
                                unset($_SESSION['waktu_agenda']);
                            }
                            ?>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">dashboard</i>
                            <input id="asal" type="text" class="validate" name="asal"  value="<?php echo $asal ;?>" required>
                            <?php
                            if (isset($_SESSION['asal'])) {
                                $asal = $_SESSION['asal'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $asal . '</div>';
                                unset($_SESSION['asal']);
                            }
                            ?>
                            <label for="asal">Dari</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">description</i>
                            <textarea id="isi" class="materialize-textarea validate" name="isi" required><?php echo $isi ;?></textarea>
                                <?php
                                    if(isset($_SESSION['eisi'])){
                                        $eisi = $_SESSION['eisi'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$eisi.'</div>';
                                        unset($_SESSION['eisi']);
                                    }
                                ?>
                            <label for="isi">Isi Ringkas</label>
                        </div>
                    </div>
                    <!-- Row in form END -->

                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=txa" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
?>