<!doctype html>
<html lang="en">

<!-- Body START -->

<head>
    <title>Aplikasi Manajemen Surat</title>

    <!-- Meta START -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="icon" href="./asset/img/jateng.png" type="image/x-icon">
    <!-- Meta END -->
</head>

<body class="bg">

    <!-- Main START -->
    <main>
        <!-- container START -->
        <div class="container">
            <!-- Row START -->
            <div class="row">
                <!-- Include Header Instansi START -->
                <?php
                include('include/header_instansi.php');
                include "include/config.php"; ?>
                <!-- Include Header Instansi END -->
                <?php

                $query = mysqli_query($config, "SELECT * FROM `tbl_agenda` WHERE CONCAT(tgl_agenda,' ',waktu_agenda) >= NOW()");

                echo '
                    <div class="row agenda">
                        <div class="col s10"></div> 
                    </div>
                    <div id="colres" class="warna cetak">
                        <table class="bordered" id="tbl" width="100%">
                            <thead class="blue lighten-4">
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="10%">Jam</th>
                                    <th width="17%">Dari</th>
                                    <th width="15%">Tempat</th>
                                    <th width="22%">Acara</th>
                                    <th width="18%">Dispo</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>';

                if (mysqli_num_rows($query) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_array($query)) {
                        $y = substr($row['tgl_agenda'], 0, 4);
                        $m = substr($row['tgl_agenda'], 5, 2);
                        $d = substr($row['tgl_agenda'], 8, 2);

                        if ($m == "01") {
                            $nm = "Januari";
                        } elseif ($m == "02") {
                            $nm = "Februari";
                        } elseif ($m == "03") {
                            $nm = "Maret";
                        } elseif ($m == "04") {
                            $nm = "April";
                        } elseif ($m == "05") {
                            $nm = "Mei";
                        } elseif ($m == "06") {
                            $nm = "Juni";
                        } elseif ($m == "07") {
                            $nm = "Juli";
                        } elseif ($m == "08") {
                            $nm = "Agustus";
                        } elseif ($m == "09") {
                            $nm = "September";
                        } elseif ($m == "10") {
                            $nm = "Oktober";
                        } elseif ($m == "11") {
                            $nm = "November";
                        } elseif ($m == "12") {
                            $nm = "Desember";
                        }
                        $disp = json_decode($row['dispo']);
                        echo '
                                        <td>' . $no++ . '</td>
                                        <td>' . $d . " " . $nm . " " . $y . '</td>
                                        <td>' . $row['waktu_agenda'] . '</td>
                                        <td>' . $row['asal'] . '</td>
                                        <td>' . $row['isi'] . '</td>
                                        <td>' . $row['tempat'] . '</td>
                                        <td>' . implode("<br>", $disp) . '</td>';

                        echo '</td>
                                </tr>
                            </tbody>';
                    }
                } else {
                    echo '<tr><td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>';
                }
                echo '
                        </table>
                    </div>';
                ?>
            </div>
    </main>
</body>

</html>
<!-- Meta START -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link rel="icon" href="./asset/img/jateng.png" type="image/x-icon">
<!-- Meta END -->

<!--[if lt IE 9]>
    <script src="./asset/js/html5shiv.min.js"></script>
    <![endif]-->

<!-- Global style START -->
<link type="text/css" rel="stylesheet" href="./asset/css/style.css" media="screen,projection" />
<link type="text/css" rel="stylesheet" href="./asset/css/materialize.min.css" media="screen,projection" />
<link type="text/css" rel="stylesheet" href="./asset/css/jquery-ui.css" media="screen,projection" />
<style type="text/css">
    body {
        background: #fff;
    }

    .bg::before {
        content: '';
        background-image: url('./asset/img/background.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: scroll;
        position: fixed;
        z-index: -1;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: 0.10;
        filter: alpha(opacity=10);
    }

    .title {
        background: #333;
        border-radius: 3px 3px 0 0;
        margin: -20px -20px 25px;
        padding: 20px;
    }

    .logo {
        border-radius: 0%;
        margin: 0 15px 15px 0;
        width: 90px;
        height: 90px;
    }

    .logo1 {
        border-radius: 0%;
        margin: 10px -5px -10px -10px;
        width: 40px;
        height: 40px;
    }

    .logoside {
        border-radius: 50%;
        margin: 0 auto;
        width: 125px;
        height: 125px;
    }

    .ins {
        font-size: 1.8rem;
    }

    .almt {
        font-size: 1.15rem;
    }

    .description {
        font-size: 1.4rem;
    }

    .jarak {
        height: 13.4rem;
    }

    .hidden {
        display: none;
    }

    .add {
        font-size: 1.45rem;
        padding: 0.1rem 0;
    }

    .jarak-card {
        margin-top: 1rem;
    }

    .jarak-filter {
        margin: -12px 0 5px;
    }

    #footer {
        background: #546e7a;
    }

    .warna {
        color: #444;
    }

    .agenda {
        font-size: 1.39rem;
        padding-left: 8px;
    }

    .hid {
        display: none;
    }

    .galeri {
        width: 100%;
        height: 26rem;
    }

    .gbr {
        float: right;
        width: 80%;
        height: auto;
    }

    .file {
        width: 70%;
        height: auto;
    }

    .kata {
        font-size: 1.04rem;
    }

    #alert-message {
        font-size: 0.9rem;
    }

    .notif {
        margin: -1rem 0 !important;
    }

    .green-text,
    .red-text {
        font-weight: normal !important;
    }

    .lampiran {
        color: #444 !important;
        font-weight: normal !important;
    }

    .waves-green {
        margin-bottom: -20px !important;
    }

    div.callout {
        height: auto;
        width: auto;
        float: left;
    }

    div.callout {
        position: relative;
        padding: 13px;
        border-radius: 3px;
        margin: 25px;
        min-height: 46px;
        top: -25px;
    }

    .callout::before {
        content: "";
        width: 0px;
        height: 0px;
        border: 0.8em solid transparent;
        position: absolute;
    }

    .callout.bottom::before {
        left: 25px;
        top: -20px;
        border-bottom: 10px solid #ffcdd2;
    }

    .pace {
        -webkit-pointer-events: none;
        pointer-events: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        -webkit-transform: translate3d(0, -50px, 0);
        -ms-transform: translate3d(0, -50px, 0);
        transform: translate3d(0, -50px, 0);
        -webkit-transition: -webkit-transform .5s ease-out;
        -ms-transition: -webkit-transform .5s ease-out;
        transition: transform .5s ease-out;
    }

    .pace.pace-active {
        -webkit-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
    }

    .pace .pace-progress {
        display: block;
        position: fixed;
        z-index: 2000;
        top: 0;
        right: 100%;
        width: 100%;
        height: 3px;
        background: #2196f3;
        pointer-events: none;
    }

    @media print {

        .side-nav,
        .secondary-nav,
        .jarak-form,
        .center,
        .hide-on-med-and-down,
        .dropdown-content,
        .button-collapse,
        .btn-large,
        .footer-copyright {
            display: none;
        }

        body {
            font-size: 12px;
            color: #212121;
        }

        .hid {
            display: block;
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        .add {
            font-size: 15px !important;
        }

        .agenda {
            font-size: 13px;
            text-align: center;
            color: #212121;
        }

        th,
        td {
            border: 1px solid #444 !important;
        }

        th {
            padding: 5px;
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        td {
            padding: 5px;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 12px;
            color: #212121;
        }

        .container {
            margin-top: -20px !important;
        }
    }

    noscript {
        color: #fff;
    }

    @media only screen and (max-width: 701px) {
        #colres {
            width: 100%;
            overflow-x: scroll !important;
        }

        #tbl {
            width: 600px !important;
        }
    }
</style>
<!-- Global style END -->