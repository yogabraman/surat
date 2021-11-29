<?php
    include "phpqrcode/qrlib.php";
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
        header("Location: ./");
        die();
    } else {

        echo '
        <style type="text/css">
            table {
                background: #fff;
                padding: 5px;
            }
            tr, td {
                border: table-cell;
                border: 1px  solid #444;
            }
            tr,td {
                vertical-align: top!important;
            }
            #right {
                border-right: none !important;
            }
            #left {
                border-left: none !important;
            }
            .isi {
                height: 250px!important;
            }
            .disp {
                text-align: center;
            }
            .logodisp {
                float: left;
                position: relative;
                width: 100px;
                height: 100px;
                margin: 0 0 0 1rem;
            }
            .qrcode {
                float: left;
                position: relative;
                margin: 0 0 0 1rem;
            }
            #lead {
                width: auto;
                position: relative;
                margin: 25px 0 0 0;
            }
            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }
            .tgh {
                text-align: center;
            }
            #nama {
                font-size: 2.1rem;
                margin-bottom: -1rem;
            }
            #alamat {
                font-size: 16px;
            }
            .up {
                text-transform: uppercase;
                margin: 0;
                font-size: 8px;
            }
            .status {
                margin: 0;
                font-size: 1.3rem;
                margin-bottom: .5rem;
            }
            #lbr {
                font-size: 20px;
                font-weight: bold;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: -1.3rem 0 1.5rem;
            }
            .footer{
                width: 100%;
                height: 50px;
                padding-left: 10px;
                line-height: 30px;
                margin: 1.3rem 0 1.5rem;
            }
            @media print{
                body {
                    font-size: 12px;
                    color: #212121;
                }
                table {
                    width: 100%;
                    font-size: 12px;
                    color: #212121;
                }
                tr, td {
                    border: table-cell;
                    border: 1px  solid #444;
                    padding: 8px!important;

                }
                tr,td {
                    vertical-align: top!important;
                }
                #lbr {
                    font-size: 20px;
                }
                .isi {
                    height: 150px!important;
                }
                .tgh {
                    text-align: center;
                }
                .disp {
                    text-align: center;
                    line-height: 90%;
                }
                .logodisp {
                    float: left;
                    position: relative;
                    width: 75px;
                    height: 75px;
                }
                .qrcode {
                    float: left;
                    position: relative;
                    margin: 0 5px 0 0;
                }
                #lead {
                    width: auto;
                    position: relative;
                    margin: 15px 0 0 0;
                }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-bottom: -10px;
                }
                #nama {
                    font-size: 20px!important;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin: -10px 0 -20px 0;
                }
                .up {
                    font-size: 8px!important;
                    font-weight: normal;
                }
                .status {
                    font-size: 17px!important;
                    font-weight: normal;
                    margin-bottom: -.1rem;
                }
                #alamat {
                    margin-top: 20px;
                    font-size: 11px;
                }
                #lbr {
                    font-size: 17px;
                    font-weight: bold;
                }
                .separator {
                    border-bottom: 2px solid #616161;
                    margin: -1rem 0 1rem;
                }
                .lbr-dispo {
                    font-weight: bold;
                    margin: 0 10px 5px 0;
                }
                .footer{
                    width: 100%;
                    height: 50px;
                    padding-left: 10px;
                    line-height: 30px;
                    margin: 1.3rem 0 1.5rem;
                }

            }
        </style>

        <body onload="window.print()">

        <!-- Container START -->
        <div class="container">
            <div id="colres">
                <div class="lbr-dispo" style="text-align:right"><br><td>Lembar Disposisi</td></div>';

                $id_surat = mysqli_real_escape_string($config, $_REQUEST['id_surat']);
                $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");

                //qrcode
                $tempdir = "temp/"; //Nama folder tempat menyimpan file qrcode
                if (!file_exists($tempdir)) //Buat folder bername temp
                mkdir($tempdir);
                //isi qrcode jika di scan
                $codeContents = "http://192.200.200.35/surat/scanqr.php";
                QRcode::png($codeContents, $tempdir.'007_2.png', QR_ECLEVEL_L, 1);

                if(mysqli_num_rows($query) > 0){
                $no = 0;
                while($row = mysqli_fetch_array($query)){

                echo '
                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                                <td class="tgh" id="lbr" colspan="5">
                                    <div class="disp">
                                        <img class="logodisp" src="./asset/img/jateng.png"/>
                                        <span id="nama"><small>
                                        PEMERINTAH PROVINSI JAWA TENGAH<br>
                                        DINAS PEMBERDAYAAN MASYARAKAT, DESA,<br>
                                        KEPENDUDUKAN DAN PENCATATAN SIPIL
                                        </small>
                                        </span>
                                        <br>                                        
                                        <span id="alamat">
                                        Jl. Menteri Supeno No.17 TELP. (024) 88311621 FAX.8318492 SEMARANG 50243<br>
                                        Email : dispermadesdukcapil@jatengprov.go.id</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td id="right" width="18%"><strong>Nomor Surat Masuk</strong></td>
                                <td id="left" colspan="2" style="border-right: none;" width="57%">: '.$row['no_surat'].'</td>
                            </tr>
                            <tr>';

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
                                echo '

                                <td id="right"><strong>Tanggal Surat</strong></td>
                                <td id="left" colspan="2">: '.$d." ".$nm." ".$y.'</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Dari</strong></td>
                                <td id="left" colspan="2">: '.$row['asal_surat'].'</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Perihal</strong></td>
                                <td id="left" colspan="2">: '.$row['isi'].'</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Nomor Pencatat Kendali</strong></td>
                                <td id="left" colspan="2">: '.$row['no_agenda'].'</td>
                            </tr>';
                            $query3 = mysqli_query($config, "SELECT * FROM tbl_disposisi JOIN tbl_surat_masuk ON tbl_disposisi.id_surat = tbl_surat_masuk.id_surat WHERE tbl_disposisi.id_surat='$id_surat'");

                            if(mysqli_num_rows($query3) > 0){
                                $no = 0;
                                $row = mysqli_fetch_array($query3);{
                                    
                                $y1 = substr($row['tgl_dispo'],0,4);
                                $m1 = substr($row['tgl_dispo'],5,2);
                                $d1 = substr($row['tgl_dispo'],8,2);

                                if($m1 == "01"){
                                    $nm1 = "Januari";
                                } elseif($m1 == "02"){
                                    $nm1 = "Februari";
                                } elseif($m1 == "03"){
                                    $nm1 = "Maret";
                                } elseif($m1 == "04"){
                                    $nm1 = "April";
                                } elseif($m1 == "05"){
                                    $nm1 = "Mei";
                                } elseif($m1 == "06"){
                                    $nm1 = "Juni";
                                } elseif($m1 == "07"){
                                    $nm1 = "Juli";
                                } elseif($m1 == "08"){
                                    $nm1 = "Agustus";
                                } elseif($m1 == "09"){
                                    $nm1 = "September";
                                } elseif($m1 == "10"){
                                    $nm1 = "Oktober";
                                } elseif($m1 == "11"){
                                    $nm1 = "November";
                                } elseif($m1 == "12"){
                                    $nm1 = "Desember";
                                }
                                echo '
                            <tr>
                                <td id="right"><strong>Disediakan kepada Yth</strong></td>
                                <td id="left">'.$row['tujuan'].'</td>
                                <td rowspan="4"><strong>Tanggal : '.$d1." ".$nm1." ".$y1.'</strong>
                                    <div id="lead">
                                        <p><center>Sekretaris Dinas</center></p>
                                        <div style="height: 50px;"><center>TTD.</center></div>
                                        <p><center class="lead">Nur Kholis, SE, M.Si</center></p>
				                        <p><center>NIP. 197601211996031005</center></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Untuk</strong></td>
                                <td id="left">'.$row['perintah'].'</td>
                            </tr>
                            <tr>
                            <tr class="isi">
                                <td colspan="2">
                                    <strong>Isi Disposisi :</strong><br/>'.$row['isi_disposisi'].'
                                    <div style="height: 50px;"></div>
                                    <strong>Catatan</strong> :<br/> '.$row['catatan'].'
                                    <div style="height: 25px;"></div>
                                </td>
                            </tr>';
                                }
                            } else {
                                echo '
                                <tr class="isi">
                                    <td colspan="2"><strong>Isi Disposisi :</strong>
                                    </td>
                                </tr>';
                            }
                        } echo '
                </tbody>
            </table>
            <div class="footer">
            <img class="qrcode" src="'.$tempdir.'007_2.png" />
            <h3>Dokumen ini telah didisposisi oleh Pak Sekretaris secara digital</h3>
            </div>
        </div>
        <div class="jarak2"></div>
    </div>
    <!-- Container END -->

    </body>';
    }
}
?>
