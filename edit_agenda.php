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
            $_REQUEST['tgl_acara'] == "" ||
            $_REQUEST['wkt_acara'] == "" ||
            $_REQUEST['tempat'] == "" ||
            $_REQUEST['dari'] == "" ||
            $_REQUEST['isi'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $tgl_acara = $_REQUEST['tgl_acara'];
            $wkt_acara = $_REQUEST['wkt_acara'];
            $tempat = $_REQUEST['tempat'];
            $dari = $_REQUEST['dari'];
            $isi = $_REQUEST['isi'];
            $id_surat = $_REQUEST['id_surat'];
            $id_user = $_SESSION['id_user'];
            if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 4) {
                // $id_bidang = $_REQUEST['bidang'];
                // $bidang = mysqli_query($config, "SELECT nama FROM `tbl_struktural` WHERE id_struk=$id_bidang")->fetch_row()[0];
                $bidang = json_encode($_REQUEST['tujuan']);
            } else {
                $bidang = json_encode(array($_SESSION['nip']));
            }

            // print_r(array($tgl_acara,$wkt_acara,$tempat,$dari,$isi,$id_surat,$id_user,$bidang));
            // echo $_REQUEST['id_agenda'];

            //validasi input data
            if (!preg_match("/^[0-9.-]*$/", $tgl_acara)) {
                $_SESSION['tgl_acara'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[0-9.-:]*$/", $wkt_acara)) {
                    $_SESSION['wkt_acara'] = 'Form Waktu Acara kurang benar';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $tempat)) {
                        $_SESSION['tempat'] = 'Form Asal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-),kurung() dan garis miring(/)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $dari)) {
                            $_SESSION['dari'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi)) {
                                $_SESSION['isi'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                //tombol simpan akan mengeksekusi script dibawah ini
                                // $id_agenda = mysqli_real_escape_string($config, $_REQUEST['id_agenda']);
                                $id_agenda = $_REQUEST['id_agenda'];
                                $query = mysqli_query($config, "UPDATE tbl_agenda SET 
                                asal='$dari',
                                isi='$isi',
                                tgl_agenda='$tgl_acara',
                                waktu_agenda='$wkt_acara',
                                tempat='$tempat',
                                dispo='$bidang',
                                id_surat='$id_surat',
                                id_user='$id_user'
                                WHERE id_agenda='$id_agenda'");

                                if ($query == true) {
                                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
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
    } else {

        $id_agenda = mysqli_real_escape_string($config, $_REQUEST['id_agenda']);
        // echo $id_agenda;
        $query = mysqli_query($config, "SELECT id_agenda, asal, isi, tgl_agenda, waktu_agenda, tempat, dispo, id_surat, id_user FROM tbl_agenda WHERE id_agenda='$id_agenda'");
        list($id_agenda, $asal, $isi, $tgl_agenda, $waktu_agenda, $tempat, $dispo, $id_surat, $id_user) = mysqli_fetch_array($query);

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
                        <input type="hidden" name="id_agenda" value="<?php echo $id_agenda; ?>">
                        <input type="hidden" name="id_surat" value="<?php echo $id_surat; ?>">
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_acara" type="text" name="tgl_acara" class="datepicker" value="<?php echo $tgl_agenda; ?>" required>
                            <?php
                            if (isset($_SESSION['tgl_acara'])) {
                                $tgl_acara = $_SESSION['tgl_acara'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_acara . '</div>';
                                unset($_SESSION['tgl_acara']);
                            }
                            ?>
                            <label for="tgl_acara">Tanggal Acara</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">place</i>
                            <input id="tempat" type="text" class="validate" name="tempat" value="<?php echo $tempat; ?>" required>
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
                            <input id="wkt_acara" type="time" name="wkt_acara" class="" value="<?php echo $waktu_agenda; ?>" required>
                            <?php
                            if (isset($_SESSION['wkt_acara'])) {
                                $wkt_acara = $_SESSION['wkt_acara'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $wkt_acara . '</div>';
                                unset($_SESSION['wkt_acara']);
                            }
                            ?>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">dashboard</i>
                            <input id="dari" type="text" class="validate" name="dari" value="<?php echo $asal; ?>" required>
                            <?php
                            if (isset($_SESSION['dari'])) {
                                $dari = $_SESSION['dari'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $dari . '</div>';
                                unset($_SESSION['dari']);
                            }
                            ?>
                            <label for="dari">Dari</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">description</i>
                            <textarea id="isi" class="materialize-textarea validate" name="isi" required><?php echo $isi; ?></textarea>
                            <?php
                            if (isset($_SESSION['eisi'])) {
                                $eisi = $_SESSION['eisi'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eisi . '</div>';
                                unset($_SESSION['eisi']);
                            }
                            ?>
                            <label for="isi">Isi Ringkas</label>
                        </div>
                        <?php
                        if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 4) {
                        ?>
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">supervisor_account</i><label>Bidang :</label><br />
                                <?php
                                $query_struk = mysqli_query($config, "SELECT * FROM tbl_struktural");
                                if (mysqli_num_rows($query_struk) > 0) {
                                    while ($row = mysqli_fetch_array($query_struk)) {
                                        if (in_array($row['nama'], json_decode($dispo))) {
                                ?>
                                            <input id="struk_<?= $row['id_struk'] ?>" type="checkbox" class="validate" name="tujuan[]" value="<?= $row['nama'] ?>" checked>
                                            <label for="struk_<?= $row['id_struk'] ?>"><?= $row['nama'] ?></label>
                                        <?php
                                        } else {
                                        ?>
                                            <input id="struk_<?= $row['id_struk'] ?>" type="checkbox" class="validate" name="tujuan[]" value="<?= $row['nama'] ?>">
                                            <label for="struk_<?= $row['id_struk'] ?>"><?= $row['nama'] ?></label>
                                        <?php
                                        }
                                        ?>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
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