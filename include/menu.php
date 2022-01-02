<?php
//cek session
if (!empty($_SESSION['admin'])) {
?>

    <nav class="blue-grey darken-1">
        <div class="nav-wrapper">

            <!-- Menu on medium and small screen END -->

            <!-- Menu on large screen START -->
            <ul class="center hide-on-med-and-down" id="nv">
                <li><a href="./" class="ams hide-on-med-and-down"><img class="logo1" src="./asset/img/jateng.png" /> Dispermadesdukcapil</a></li>
                <li>
                    <div class="grs">
                        </>
                </li>
                <li><a href="./"><i class="material-icons"></i>&nbsp; Beranda</a></li>

                <li><a class="dropdown-button" href="#!" data-activates="transaksi">Transaksi Surat <i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='transaksi' class='dropdown-content'>
                    <li><a href="?page=tsm">Surat Masuk</a></li>
                    <li><a href="?page=tsk">Surat Keluar</a></li>
                </ul>

                <?php
                if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2 || $_SESSION['admin'] == 4 || $_SESSION['admin'] == 3) { ?>
                    <li><a class="dropdown-button" href="#!" data-activates="agenda">Buku Agenda <i class="material-icons md-18">arrow_drop_down</i></a></li>
                    <ul id='agenda' class='dropdown-content'>
                        <li><a href="?page=txa">Tambah Agenda</a></li>
                        <li><a href="?page=lsa">List Agenda</a></li>
                        <li><a href="?page=asm">Surat Masuk</a></li>
                        <li><a href="?page=ask">Surat Keluar</a></li>
                    </ul>
                <?php
                }
                ?>

                <!-- <?php
                if ($_SESSION['admin'] == 1 || $_SESSION['admin'] == 4) { ?>
                    <li><a href="?page=ref">Klasifikasi</a></li>
                <?php
                }
                ?> -->
                
                <li><a href="?page=spt">SPT</a></li>

                <?php
                if ($_SESSION['admin'] == 1) { ?>
                    <li><a href="?page=sett&sub=usr">User</a></li>

                <?php
                }
                ?>
                <li class="right" style="margin-right: 10px;"><a class="dropdown-button" href="#!" data-activates="logout"><i class="material-icons">account_circle</i> <?php echo $_SESSION['nama']; ?><i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='logout' class='dropdown-content'>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="material-icons">settings_power</i> Logout</a></li>
                </ul>
            </ul>
            <!-- Menu on large screen END -->
            <a href="#" data-activates="slide-out" class="button-collapse" id="menu"><i class="material-icons">menu</i></a>
        </div>
    </nav>

<?php
} else {
    header("Location: ../");
    die();
}
?>