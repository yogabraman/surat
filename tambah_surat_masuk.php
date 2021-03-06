<?php
include 'vendor/autoload.php';
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['no_agenda'] == "" ||
            $_REQUEST['no_surat'] == "" ||
            $_REQUEST['asal_surat'] == "" ||
            $_REQUEST['isi'] == "" ||
            // $_REQUEST['kode'] == "" || 
            $_REQUEST['tgl_surat'] == "" ||
            $_REQUEST['keterangan'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_agenda = $_REQUEST['no_agenda'];
            $no_surat = $_REQUEST['no_surat'];
            $asal_surat = $_REQUEST['asal_surat'];
            $isi = $_REQUEST['isi'];
            // $kode = substr($_REQUEST['kode'],0,30);
            // $nkode = trim($kode);
            $tgl_surat = $_REQUEST['tgl_surat'];
            $keterangan = $_REQUEST['keterangan'];
            $tipe_surat = $_REQUEST['tipe_surat'];
            $tgl_agenda = $_REQUEST['tgl_agenda'];
            $waktu_agenda = $_REQUEST['waktu_agenda'];
            $tempat = $_REQUEST['tempat'];
            $id_user = $_SESSION['id_user'];

            //validasi input data
            if (!preg_match("/^[0-9]*$/", $no_agenda)) {
                $_SESSION['no_agenda'] = 'Form Nomor Agenda harus diisi angka!';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_surat)) {
                    $_SESSION['no_surat'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $asal_surat)) {
                        $_SESSION['asal_surat'] = 'Form Asal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-),kurung() dan garis miring(/)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi)) {
                            $_SESSION['isi'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            // if(!preg_match("/^[a-zA-Z0-9., ]*$/", $nkode)){
                            //     $_SESSION['kode'] = 'Form Kode Klasifikasi hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan koma(,)';
                            //     echo '<script language="javascript">window.history.back();</script>';
                            // } else {

                            if (!preg_match("/^[0-9.-]*$/", $tgl_surat)) {
                                $_SESSION['tgl_surat'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $keterangan)) {
                                    $_SESSION['keterangan'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {
                                    //cek no surat agar tidak duplikat
                                    $cek = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE no_surat='$no_surat'");
                                    $result = mysqli_num_rows($cek);

                                    if ($result > 0) {
                                        $_SESSION['errDup'] = 'Nomor Surat sudah terpakai, gunakan yang lain!';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
                                        $file = $_FILES['file']['name'];
                                        $x = explode('.', $file);
                                        $eks = strtolower(end($x));
                                        $ukuran = $_FILES['file']['size'];
                                        $target_dir = "upload/surat_masuk/";
                                        $target_path = "sijanda/assets/suratmasuk/";

                                        //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                        if ($file != "") {

                                            // $rand = rand(1, 10000);
                                            date_default_timezone_set('Asia/Jakarta');
                                            $rand = date("YmdHis");
                                            $nfile = $rand . "-" . $file;

                                            //validasi file
                                            if (in_array($eks, $ekstensi) == true) {
                                                if ($ukuran < 2500000) {

                                                    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);
                                                    //moved to destination, now copy
                                                    copy($target_dir.$nfile, $target_path.$nfile);

                                                    //jika surat biasa
                                                    $tipe_surat = $_POST['tipe_surat'];
                                                    if ($tipe_surat == 0) {
                                                        $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_agenda,no_surat,asal_surat,isi,tgl_surat, tgl_diterima,file,keterangan,status_dispo,tipe_surat,id_user)
                                                        VALUES('$no_agenda','$no_surat','$asal_surat','$isi','$tgl_surat',NOW(),'$nfile','$keterangan',0,$tipe_surat,'$id_user')");

                                                        if ($query == true) {
                                                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                            header("Location: ./admin.php?page=tsm");
                                                            die();
                                                        } else {
                                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        }
                                                    } else {
                                                        //jika surat undangan
                                                        $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_agenda,no_surat,asal_surat,isi,tgl_surat, tgl_diterima,file,keterangan,status_dispo,tipe_surat,id_user)
                                                        VALUES('$no_agenda','$no_surat','$asal_surat','$isi','$tgl_surat',NOW(),'$nfile','$keterangan',0,$tipe_surat,'$id_user')");

                                                        if ($query == true) {
                                                            $last_id = mysqli_insert_id($config);
                                                            $query_und = mysqli_query($config, "INSERT INTO tbl_agenda(asal,isi,tgl_agenda,waktu_agenda,tempat, id_surat, id_user)
                                                        VALUES('$asal_surat','$isi','$tgl_agenda','$waktu_agenda','$tempat','$last_id','$id_user')");
                                                            if ($query_und == true) {
                                                                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                                header("Location: ./admin.php?page=tsm");
                                                                die();
                                                            } else {
                                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            }
                                                        } else {
                                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                            echo '<script language="javascript">window.history.back();</script>';
                                                        }
                                                    }

                                                    // setting config untuk layanan akses ke google drive
                                                    // $client = new Google_Client();
                                                    // $client->setAuthConfig("oauth-credentials.json");
                                                    // $client->addScope("https://www.googleapis.com/auth/drive");
                                                    // $service = new Google_Service_Drive($client);
                                                    // // session_start(); //starts a session
                                                    // // session_unset(); //flushes out all the contents previously set

                                                    // // proses membaca token pasca login
                                                    // if (isset($_GET['code'])) {
                                                    //     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                                                    //     // simpan token ke session
                                                    //     $_SESSION['upload_token'] = $token;
                                                    // }

                                                    // if (empty($_SESSION['upload_token'])) {
                                                    //     // jika token belum ada, maka lakukan login via oauth
                                                    //     $authUrl = $client->createAuthUrl();
                                                    //     header("Location:" . $authUrl);
                                                    // } else {

                                                    //     // menggunakan token untuk mengakses google drive  
                                                    //     $client->setAccessToken($_SESSION['upload_token']);
                                                    //     // membaca token respon dari google drive
                                                    //     $client->getAccessToken();

                                                    //     // instansiasi obyek file yg akan diupload ke Google Drive
                                                    //     $filee = new Google_Service_Drive_DriveFile();
                                                    //     // set nama file di Google Drive disesuaikan dg nama file aslinya
                                                    //     date_default_timezone_set('Asia/Jakarta');
                                                    //     $rand = date("YmdHis");
                                                    //     $filename = $rand . "-" . $_FILES['file']['name'];

                                                    //     $filee->setName($filename);
                                                    //     // set folder file di Google Drive
                                                    //     $folder = "1COI-Gea0FSpfjJeE441Lnt9oMnJ9qpmi";
                                                    //     $filee->setParents([$folder]);
                                                    //     // proses upload file ke Google Drive dg multipart
                                                    //     $result = $service->files->create($filee, array(
                                                    //         'data' => file_get_contents($_FILES['file']['tmp_name']),
                                                    //         'mimeType' => 'application/octet-stream',
                                                    //         'uploadType' => 'multipart'
                                                    //     ));

                                                    //     // menampilkan nama file yang sudah diupload ke google drive
                                                    //     $nfile = $filename . "-" . $result->id;

                                                    // }
                                                } else {
                                                    $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                }
                                            } else {
                                                $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            }
                                        } else {
                                            //jika form file gambar kosong akan mengeksekusi script dibawah ini

                                            //jika surat biasa
                                            $tipe_surat = $_POST['tipe_surat'];
                                            if ($tipe_surat == 0) {
                                                $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_agenda,no_surat,asal_surat,isi,tgl_surat, tgl_diterima,file,keterangan,status_dispo,tipe_surat,id_user)
                                                            VALUES('$no_agenda','$no_surat','$asal_surat','$isi','$tgl_surat',NOW(),'','$keterangan',0,$tipe_surat,'$id_user')");

                                                if ($query == true) {
                                                    $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                    header("Location: ./admin.php?page=tsm");
                                                    die();
                                                } else {
                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                }
                                            } else {
                                                //jika surat undangan
                                                $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_agenda,no_surat,asal_surat,isi,tgl_surat, tgl_diterima,file,keterangan,status_dispo,tipe_surat,id_user)
                                                            VALUES('$no_agenda','$no_surat','$asal_surat','$isi','$tgl_surat',NOW(),'','$keterangan',0,$tipe_surat,'$id_user')");

                                                if ($query == true) {
                                                    $last_id = mysqli_insert_id($config);
                                                    $query_und = mysqli_query($config, "INSERT INTO tbl_agenda(asal,isi,tgl_agenda,waktu_agenda,tempat, id_surat, id_user)
                                                            VALUES('$asal_surat','$isi','$tgl_agenda','$waktu_agenda','$tempat','$last_id','$id_user')");
                                                    if ($query_und == true) {
                                                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                        header("Location: ./admin.php?page=tsm");
                                                        die();
                                                    } else {
                                                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                        echo '<script language="javascript">window.history.back();</script>';
                                                    }
                                                } else {
                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            // }
                        }
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
                            <li class="waves-effect waves-light"><a href="?page=tsm&act=add" class="judul"><i class="material-icons">mail</i> Tambah Data Surat Masuk</a></li>
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
            <form class="col s12" method="POST" action="?page=tsm&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">mail</i><label>Pilih Tipe Surat</label><br />
                        <div class="input-field col s11 right">
                            <select class="browser-default tipe_surat" name="tipe_surat" id="tipe_surat" required>
                                <option value="0">Surat Biasa</option>
                                <option value="1">Undangan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="no_agenda" type="number" class="validate" name="no_agenda" required>
                        <?php
                        if (isset($_SESSION['no_agenda'])) {
                            $no_agenda = $_SESSION['no_agenda'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_agenda . '</div>';
                            unset($_SESSION['no_agenda']);
                        }
                        ?>
                        <label for="no_agenda">Nomor Agenda</label>
                    </div>
                    <!-- <div class="input-field col s6" data-position="top">
                            <i class="material-icons prefix md-prefix">bookmark</i>
							<select id="kode" class="validate" type="text" name="kode" required>
                            <option></option>
                            <?php
                            include('include/config.php');
                            $rs = mysqli_query($config, "SELECT * FROM tbl_klasifikasi");
                            while ($row = mysqli_fetch_array($rs)) {
                                echo '<option value=' . $row['kode'] . '>' . $row['kode'] . '/' . $row['nama'] . '</option>';
                            }
                            ?>
                            </select>
                            <?php
                            if (isset($_SESSION['kode'])) {
                                $kode = $_SESSION['kode'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kode . '</div>';
                                unset($_SESSION['kode']);
                            }
                            ?>
                            <label for="kode">Kode Klasifikasi</label>
                        </div> -->
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">place</i>
                        <input id="asal_surat" type="text" class="validate" name="asal_surat" required>
                        <?php
                        if (isset($_SESSION['asal_surat'])) {
                            $asal_surat = $_SESSION['asal_surat'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $asal_surat . '</div>';
                            unset($_SESSION['asal_surat']);
                        }
                        ?>
                        <label for="asal_surat">Asal Surat</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_surat" type="text" class="validate" name="no_surat" required>
                        <?php
                        if (isset($_SESSION['no_surat'])) {
                            $no_surat = $_SESSION['no_surat'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_surat . '</div>';
                            unset($_SESSION['no_surat']);
                        }
                        if (isset($_SESSION['errDup'])) {
                            $errDup = $_SESSION['errDup'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                            unset($_SESSION['errDup']);
                        }
                        ?>
                        <label for="no_surat">Nomor Surat</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" required>
                        <?php
                        if (isset($_SESSION['tgl_surat'])) {
                            $tgl_surat = $_SESSION['tgl_surat'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_surat . '</div>';
                            unset($_SESSION['tgl_surat']);
                        }
                        ?>
                        <label for="tgl_surat">Tanggal Surat</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">description</i>
                        <textarea id="isi" class="materialize-textarea validate" name="isi" required></textarea>
                        <?php
                        if (isset($_SESSION['isi'])) {
                            $isi = $_SESSION['isi'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $isi . '</div>';
                            unset($_SESSION['isi']);
                        }
                        ?>
                        <label for="isi">Isi Ringkas</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">featured_play_list</i>
                        <input id="keterangan" type="text" class="validate" name="keterangan" required>
                        <?php
                        if (isset($_SESSION['keterangan'])) {
                            $keterangan = $_SESSION['keterangan'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $keterangan . '</div>';
                            unset($_SESSION['keterangan']);
                        }
                        ?>
                        <label for="keterangan">Keterangan</label>
                    </div>
                    <div class="input-field col s6">
                        <div class="file-field input-field tooltipped" data-position="top" data-tooltip="Jika tidak ada file/scan gambar surat, biarkan kosong">
                            <div class="btn light-green darken-1">
                                <span>File</span>
                                <input type="file" id="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload file/scan gambar surat masuk">
                                <?php
                                if (isset($_SESSION['errSize'])) {
                                    $errSize = $_SESSION['errSize'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errSize . '</div>';
                                    unset($_SESSION['errSize']);
                                }
                                if (isset($_SESSION['errFormat'])) {
                                    $errFormat = $_SESSION['errFormat'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errFormat . '</div>';
                                    unset($_SESSION['errFormat']);
                                }
                                ?>
                                <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                            </div>
                        </div>
                    </div>

                    <div id="undangan">

                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_agenda" type="text" name="tgl_agenda" class="datepicker">
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
                            <input id="tempat" type="text" class="validate" name="tempat">
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
                            <i class="material-icons prefix md-prefix">alarm</i>
                            <input id="waktu_agenda" type="time" name="waktu_agenda" class=""></input>
                            <?php
                            if (isset($_SESSION['waktu_agenda'])) {
                                $waktu_agenda = $_SESSION['waktu_agenda'];
                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $waktu_agenda . '</div>';
                                unset($_SESSION['waktu_agenda']);
                            }
                            ?>
                        </div>

                    </div>

                </div>
                <!-- Row in form END -->

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=tsm" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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