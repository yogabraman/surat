<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if(isset($_REQUEST['submit'])){

            //validasi form kosong
            if(
                $_REQUEST['no_agenda'] == "" || 
                $_REQUEST['no_surat'] == "" || 
                $_REQUEST['asal_surat'] == "" || 
                $_REQUEST['isi'] == "" || 
                // $_REQUEST['kode'] == "" || 
                $_REQUEST['tgl_surat'] == ""  || 
                $_REQUEST['keterangan'] == ""){
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
                $status_dispo = $_REQUEST['status_dispo'];
                $tipe_surat = $_REQUEST['tipe_surat'];
                $tgl_agenda = $_REQUEST['tgl_agenda'];
                $waktu_agenda = $_REQUEST['waktu_agenda'];
                $tempat = $_REQUEST['tempat'];
                $id_user = $_SESSION['id_user'];

                //validasi input data
                if(!preg_match("/^[0-9]*$/", $no_agenda)){
                    $_SESSION['eno_agenda'] = 'Form Nomor Agenda harus diisi angka!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if(!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_surat)){
                        $_SESSION['eno_surat'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if(!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $asal_surat)){
                            $_SESSION['easal_surat'] = 'Form Asal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-),kurung() dan garis miring(/)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if(!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi)){
                                $_SESSION['eisi'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                // if(!preg_match("/^[a-zA-Z0-9., ]*$/", $nkode)){
                                //     $_SESSION['ekode'] = 'Form Kode Klasifikasi hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan koma(,)';
                                //     echo '<script language="javascript">window.history.back();</script>';
                                // } else {

                                        if(!preg_match("/^[0-9.-]*$/", $tgl_surat)){
                                            $_SESSION['etgl_surat'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        } else {

                                            if(!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $keterangan)){
                                                $_SESSION['eketerangan'] = 'Form Keterangan hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            } else {

                                                $ekstensi = array('jpg','png','jpeg','doc','docx','pdf');
                                                $file = $_FILES['file']['name'];
                                                $x = explode('.', $file);
                                                $eks = strtolower(end($x));
                                                $ukuran = $_FILES['file']['size'];
                                                $target_dir = "upload/surat_masuk/";

                                            //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                            if($file != ""){

                                                // $rand = rand(1, 10000);
                                                date_default_timezone_set('Asia/Jakarta');
                                                $rand = date("YmdHis");
                                                $nfile = $rand."-".$file;

                                                //validasi file
                                                if(in_array($eks, $ekstensi) == true){
                                                    if($ukuran < 2300000){

                                                        $id_surat = $_REQUEST['id_surat'];
                                                        $query = mysqli_query($config, "SELECT file FROM tbl_surat_masuk WHERE id_surat='$id_surat'");
                                                        list($file) = mysqli_fetch_array($query);

                                                        //jika file tidak kosong akan mengeksekusi script dibawah ini
                                                        if(!empty($file)){
                                                            unlink($target_dir.$file);

                                                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir.$nfile);

                                                            $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_agenda='$no_agenda',no_surat='$no_surat',asal_surat='$asal_surat',isi='$isi',tgl_surat='$tgl_surat',file='$nfile',keterangan='$keterangan',id_user='$id_user' WHERE id_surat='$id_surat'");

                                                            if($query == true){
                                                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                                header("Location: ./admin.php?page=tsm");
                                                                die();
                                                            } else {
                                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                            }
                                                        } else {

                                                            //jika file kosong akan mengeksekusi script dibawah ini
                                                            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir.$nfile);

                                                            //jika surat biasa
                                                            if($tipe_surat==0){
                                                                $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_agenda='$no_agenda',no_surat='$no_surat',asal_surat='$asal_surat',isi='$isi',tgl_surat='$tgl_surat',file='$nfile',keterangan='$keterangan',id_user='$id_user' WHERE id_surat='$id_surat'");

                                                                if($query == true){
                                                                $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                                header("Location: ./admin.php?page=tsm");
                                                                die();
                                                                } else {
                                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                echo '<script language="javascript">window.history.back();</script>';
                                                                }

                                                            }
                                                            else{
                                                                $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_agenda='$no_agenda',no_surat='$no_surat',asal_surat='$asal_surat',isi='$isi',tgl_surat='$tgl_surat',file='$nfile',keterangan='$keterangan',id_user='$id_user' WHERE id_surat='$id_surat'");

                                                                if($query == true){
                                                                    $query_und = mysqli_query($config, "UPDATE tbl_agenda SET asal='$asal_surat',isi='$isi',tgl_agenda='$tgl_agenda',waktu_agenda='$waktu_agenda',tempat='$tempat',id_user='$id_user' WHERE id_surat='$id_surat'");
                                                                    if($query_und==true){
                                                                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                                        header("Location: ./admin.php?page=tsm");
                                                                        die();
                                                                    }else{
                                                                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                        echo '<script language="javascript">window.history.back();</script>';
                                                                    }
                                                                } else {
                                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                                    echo '<script language="javascript">window.history.back();</script>';
                                                                }

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

                                                $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_agenda='$no_agenda',no_surat='$no_surat',asal_surat='$asal_surat',isi='$isi',tgl_surat='$tgl_surat',keterangan='$keterangan',id_user='$id_user' WHERE id_surat='$id_surat'");

                                                if($query == true){
                                                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                    header("Location: ./admin.php?page=tsm");
                                                    die();
                                                } else {
                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                    echo '<script language="javascript">window.history.back();</script>';
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
    } else {

        $id_surat = mysqli_real_escape_string($config, $_REQUEST['id_surat']);
        $query = mysqli_query($config, "SELECT m.id_surat, m.no_agenda, m.no_surat, m.asal_surat, m.isi, m.tgl_surat, m.file, m.keterangan, m.status_dispo, m.tipe_surat, m.id_user FROM tbl_surat_masuk m WHERE id_surat='$id_surat'");
        list($id_surat, $no_agenda, $no_surat, $asal_surat, $isi, $tgl_surat, $file, $keterangan, $status_dispo, $tipe_surat, $id_user) = mysqli_fetch_array($query);

        if($_SESSION['id_user'] != $id_user AND $_SESSION['id_user'] != 1){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=tsm";
                  </script>';
        } else {?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Data Surat Masuk</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <?php
                if(isset($_SESSION['errQ'])){
                    $errQ = $_SESSION['errQ'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    unset($_SESSION['errQ']);
                }
                if(isset($_SESSION['errEmpty'])){
                    $errEmpty = $_SESSION['errEmpty'];
                    echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
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
                <form class="col s12" method="POST" action="?page=tsm&act=edit" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">
                        <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Isi dengan angka">
                            
                            <!-- hidden value -->
                            <input type="hidden" name="id_surat" value="<?php echo $id_surat ;?>">
                            <input type="hidden" name="status_dispo" value="<?php echo $status_dispo ;?>">
                            <input type="hidden" name="tipe_surat" value="<?php echo $tipe_surat ;?>">

                            <i class="material-icons prefix md-prefix">looks_one</i>
                            <input id="no_agenda" type="number" class="validate" value="<?php echo $no_agenda ;?>" name="no_agenda" required>
                                <?php
                                    if(isset($_SESSION['eno_agenda'])){
                                        $eno_agenda = $_SESSION['eno_agenda'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$eno_agenda.'</div>';
                                        unset($_SESSION['eno_agenda']);
                                    }
                                ?>
                            <label for="no_agenda">Nomor Agenda</label>
                        </div>
                        <!-- <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Diambil dari data referensi kode klasifikasi">
                            <i class="material-icons prefix md-prefix">bookmark</i>
                            <select id="kode" class="validate" type="text" name="kode" required>
                            <option value='<?php echo $kode ?>'><?php echo $kode ?>/<?php echo $nama ?></option>
                            <?php
include('include/config.php');
$rs = mysqli_query($config,"SELECT * FROM tbl_klasifikasi");
while($row = mysqli_fetch_array($rs)){
	echo '<option value='.$row['kode'].'>'.$row['kode'].'/'.$row['nama'].'</option>';
	
}
?>
                            </select>
                                <?php
                                    if(isset($_SESSION['ekode'])){
                                        $ekode = $_SESSION['ekode'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$ekode.'</div>';
                                        unset($_SESSION['ekode']);
                                    }
                                ?>
                            <label for="kode">Kode Klasifikasi</label>
                        </div> -->
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">place</i>
                            <input id="asal_surat" type="text" class="validate" name="asal_surat" value="<?php echo $asal_surat ;?>" required>
                                <?php
                                    if(isset($_SESSION['easal_surat'])){
                                        $easal_surat = $_SESSION['easal_surat'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$easal_surat.'</div>';
                                        unset($_SESSION['easal_surat']);
                                    }
                                ?>
                            <label for="asal_surat">Asal Surat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">looks_two</i>
                            <input id="no_surat" type="text" class="validate" name="no_surat" value="<?php echo $no_surat ;?>" required>
                                <?php
                                    if(isset($_SESSION['eno_surat'])){
                                        $eno_surat = $_SESSION['eno_surat'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$eno_surat.'</div>';
                                        unset($_SESSION['eno_surat']);
                                    }
                                ?>
                            <label for="no_surat">Nomor Surat</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" value="<?php echo $tgl_surat ;?>" required>
                                <?php
                                    if(isset($_SESSION['etgl_surat'])){
                                        $etgl_surat = $_SESSION['etgl_surat'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$etgl_surat.'</div>';
                                        unset($_SESSION['etgl_surat']);
                                    }
                                ?>
                            <label for="tgl_surat">Tanggal Surat</label>
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
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">featured_play_list</i>
                            <input id="keterangan" type="text" class="validate" name="keterangan" value="<?php echo $keterangan ;?>" required>
                                <?php
                                    if(isset($_SESSION['eketerangan'])){
                                        $eketerangan = $_SESSION['eketerangan'];
                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$eketerangan.'</div>';
                                        unset($_SESSION['eketerangan']);
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
                                    <input class="file-path validate" type="text" value="<?php echo $file ;?>" placeholder="Upload file/scan gambar surat masuk">
                                        <?php
                                            if(isset($_SESSION['errSize'])){
                                                $errSize = $_SESSION['errSize'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errSize.'</div>';
                                                unset($_SESSION['errSize']);
                                            }
                                            if(isset($_SESSION['errFormat'])){
                                                $errFormat = $_SESSION['errFormat'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$errFormat.'</div>';
                                                unset($_SESSION['errFormat']);
                                            }
                                        ?>
                                    <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                                </div>
                            </div>
                        </div>
                        <?php
                            if($tipe_surat==1){
                                $query_und = mysqli_query($config, "SELECT id_agenda, tgl_agenda, waktu_agenda, tempat, id_user FROM tbl_agenda WHERE id_surat='$id_surat'");
                                list($id_agenda, $tgl_agenda, $waktu_agenda, $tempat, $id_user) = mysqli_fetch_array($query_und);
                                
                                ?>
                                <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_agenda" type="text" name="tgl_agenda" class="datepicker" value="<?php echo $tgl_agenda ;?>" >
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
                        <input id="tempat" type="text" class="validate" name="tempat" value="<?php echo $tempat ;?>">
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
                        <input id="waktu_agenda" type="time" name="waktu_agenda" value="<?php echo $waktu_agenda ;?>"></input>
                        <?php
                        if (isset($_SESSION['waktu_agenda'])) {
                            $waktu_agenda = $_SESSION['waktu_agenda'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $waktu_agenda . '</div>';
                            unset($_SESSION['waktu_agenda']);
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
    }
?>
