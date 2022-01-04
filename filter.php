<?php
require('include/config.php');
session_start();
		$id = $_POST['id'];

		$filter = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE status_dispo = '$id' ORDER by id_surat DESC ");
		while ($row = mysqli_fetch_array($filter)) {

			if (!empty($row['file'])) {
				$file = '<strong><a href="?page=gsm&act=fsm&id_surat='.$row['id_surat'].'">'.$row['file'].'</a></strong>';
			} else {
				$file = '<em>Tidak ada file yang di upload</em>';
			}

			$y = substr($row['tgl_surat'],0,4);
            $m = substr($row['tgl_surat'],5,2);
            $d = substr($row['tgl_surat'],8,2);

                                    if($m == "01"){
                                        $nm = "Januari";
                                    } elseif($m == "02"){
                                        $nm = "Februari";
                                    } elseif($m == "03"){
                                        $nm = "Maret";
                                    } elseif($m == "04"){
                                        $nm = "April";
                                    } elseif($m == "05"){
                                        $nm = "Mei";
                                    } elseif($m == "06"){
                                        $nm = "Juni";
                                    } elseif($m == "07"){
                                        $nm = "Juli";
                                    } elseif($m == "08"){
                                        $nm = "Agustus";
                                    } elseif($m == "09"){
                                        $nm = "September";
                                    } elseif($m == "10"){
                                        $nm = "Oktober";
                                    } elseif($m == "11"){
                                        $nm = "November";
                                    } elseif($m == "12"){
                                        $nm = "Desember";
                                    }
                                    if ($row['status_dispo'] == 1) {
                                        $dispo = '<i class="material-icons">check_circle</i>';
                                    } else {
                                        $dispo =  '<i class="material-icons">remove_circle_outline</i>';
                                    }

if($_SESSION['admin'] != $row['id_user'] AND $_SESSION['admin'] != 1 AND $_SESSION['admin'] != 4){
    $action = '<a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih Disp untuk Melihat Disposisi Surat" href="?page=tsm&act=disp&id_surat='.$row['id_surat'].'"><i class="material-icons">description</i> DISP</a>';
} else {
    $action = '<a class="btn small blue waves-effect waves-light" href="?page=tsm&act=edit&id_surat='.$row['id_surat'].'"><i class="material-icons">edit</i> EDIT</a>
    <a class="btn small light-green waves-effect waves-light tooltipped" data-position="left" data-tooltip="Pilih Disp untuk Melihat Disposisi Surat" href="?page=tsm&act=disp&id_surat='.$row['id_surat'].'"><i class="material-icons">description</i> DISP</a>
    <a class="btn small deep-orange waves-effect waves-light" href="?page=tsm&act=del&id_surat='.$row['id_surat'].'"><i class="material-icons">delete</i> DEL</a>';
}

		$data[] = array(
				'no_agenda' => $row['no_agenda'],
				'isi' => $row['isi'],
				'file' => $file,
				'asal_surat' => $row['asal_surat'],
				'no_surat' => $row['no_surat'],
				'd' => $d,
				'm' => $nm,
				'y' => $y,
                'dispo' => $dispo,
				'action' => $action
				
		);
	}
		$output = array(
			"data" => $data,
		);

		

		echo json_encode($data);
