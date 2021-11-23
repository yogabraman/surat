<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_SESSION['errQ'])) {
        $errQ = $_SESSION['errQ'];
        echo '<div id="alert-message" class="row jarak-card">
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

    $id_agenda = mysqli_real_escape_string($config, $_REQUEST['id_agenda']);
    $query = mysqli_query($config, "SELECT * FROM tbl_agenda WHERE id_agenda='$id_agenda'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

            if ($_SESSION['id_user'] != $row['id_user'] and $_SESSION['id_user'] != 1) {
                echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak memiliki hak akses untuk menghapus data ini");
                        window.location.href="./admin.php?page=txa";
                      </script>';
            } else {

                echo '
                <!-- Row form Start -->
				<div class="row jarak-card">
				    <div class="col m12">
                    <div class="card">
                        <div class="card-content">
				        <table>
				            <thead class="red lighten-5 red-text">
				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
				                Apakah Anda yakin akan menghapus data ini?</div>
				            </thead>

				            <tbody>
                                <tr>
                                    <td width="13%">Dari</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $row['asal'] . '</td>
                                </tr>
                                <tr>
                                    <td width="13%">Tanggal Agenda</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $tgl = date('d M Y ', strtotime($row['tgl_agenda'])) . '</td>
                                </tr>
                                <tr>
                                    <td width="13%">Waktu Agenda</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . substr($row['waktu_agenda'], 0, 5) . '</td>
                                </tr>
				                <tr>
				                    <td width="13%">Tempat</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['tempat'] . '</td>
				                </tr>
				                <tr>
				                    <td width="13%">Acara</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['isi'] . '</td>
				                </tr>
    			                <tr>
    		                        <td width="13%">Dispo</td>
    		                        <td width="1%">:</td>
    		                        <td width="86%">' . $row['dispo'] . '</td>
    			                </tr>
    			            </tbody>
    			   		</table>
                        </div>
                        <div class="card-action">
        	                <a href="?page=txa&act=del&submit=yes&id_agenda=' . $row['id_agenda'] . '" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        	                <a href="?page=txa" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
    	                </div>
    	            </div>
                </div>
            </div>
            <!-- Row form END -->';

                if (isset($_REQUEST['submit'])) {
                    $id_agenda = $_REQUEST['id_agenda'];

                    //jika tidak ada file akan mengekseskusi script dibawah ini
                    $query = mysqli_query($config, "DELETE FROM tbl_agenda WHERE id_agenda='$id_agenda'");

                    if ($query == true) {
                        $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                        header("Location: ./admin.php?page=txa");
                        die();
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">
                                 window.location.href="./admin.php?page=txa&act=del&id_agenda=' . $id_agenda . '";
                               </script>';
                    }
                }
            }
        }
    }
}
