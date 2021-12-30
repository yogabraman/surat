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
                        <div class="card green lighten-5">
                            <div class="card-content notif">
                                <span class="card-title green-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
        unset($_SESSION['errQ']);
    }

    $id_spt = mysqli_real_escape_string($config, $_REQUEST['id_spt']);
    $query = mysqli_query($config, "SELECT * FROM tbl_spt WHERE id_spt='$id_spt'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

            // if ($_SESSION['id_user'] != $row['id_user'] and $_SESSION['id_user'] != 1 and $_SESSION['admin'] != 4) 
            if ($_SESSION['admin'] != 1 and $_SESSION['admin'] != 4) {
                echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak memiliki hak akses untuk menghapus data ini");
                        window.location.href="./admin.php?page=spt";
                      </script>';
            } else {

                echo '
                <!-- Row form Start -->
				<div class="row jarak-card">
				    <div class="col m12">
                    <div class="card">
                        <div class="card-content">
				        <table>
				            <thead class="green lighten-5 green-text">
				                <div class="appr green-text"><i class="material-icons md-36">check_circle</i>
				                Approve SPT ini?</div>
				            </thead>
                            <br>

				            <tbody>
                                <tr>
                                    <td width="13%">Tanggal Berangkat</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $tgl_brgkt = date('d M Y ', strtotime($row['tgl_berangkat'])) . '</td>
                                </tr>
                                <tr>
                                    <td width="13%">Tanggal Pulang</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $tgl_plg = date('d M Y ', strtotime($row['tgl_pulang'])) . '</td>
                                </tr>
				                <tr>
				                    <td width="13%">Pegawai</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['pegawai'] . '</td>
				                </tr>
				                <tr>
				                    <td width="13%">Tujuan</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['tujuan'] . '</td>
				                </tr>
    			            </tbody>
    			   		</table>
                        </div>
                        <div class="card-action">
        	                <a href="?page=spt&act=app&submit=yes&id_spt=' . $row['id_spt'] . '" class="btn-large green waves-effect waves-light white-text">APPROVE <i class="material-icons">done</i></a>
        	                <a href="?page=spt" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
    	                </div>
    	            </div>
                </div>
            </div>
            <!-- Row form END -->';

                if (isset($_REQUEST['submit'])) {
                    $id_agenda = $_REQUEST['id_spt'];

                    //jika tidak ada file akan mengekseskusi script dibawah ini
                    $query = mysqli_query($config, "UPDATE tbl_spt SET status=1 WHERE id_spt='$id_spt'");

                    if ($query == true) {
                        $_SESSION['succDel'] = 'SPT telah disetujui<br/>';
                        header("Location: ./admin.php?page=spt");
                        die();
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">
                                 window.location.href="./admin.php?page=spt&act=del&id_spt=' . $id_spt . '";
                               </script>';
                    }
                }
            }
        }
    }
}
