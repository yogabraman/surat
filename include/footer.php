<?php
//cek session
if (!empty($_SESSION['admin'])) {
?>

    <noscript>
        <meta http-equiv="refresh" content="0;URL='./enable-javascript.html'" />
    </noscript>

    <!-- Footer START -->
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <br />
            </div>
        </div>
        <div class="footer-copyright blue-grey darken-1 white-text">
            <div class="container" id="footer">

                <span class="white-text">&copy; <?php echo date("Y"); ?>
                    DISPERMADESDUKCAPIL &nbsp;|&nbsp; 
                </span>
                <div class="right hide-on-small-only">
                    <!-- <i class="material-icons md-12">public</i> www.disdik.semarangkota.go.id &nbsp;&nbsp;
                    <i class="material-icons">mail_outline</i> info@disdik.semarangkota.go.id -->
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer END -->

    <!-- Javascript START -->
    <script type="text/javascript" src="asset/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="asset/js/materialize.min.js"></script>
    <script type="text/javascript" src="asset/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
    <script data-pace-options='{ "ajax": false }' src='asset/js/pace.min.js'></script>

    <script type="text/javascript">
        $(document).ready(function() {

            var undangan = document.getElementById("undangan");

            undangan.style.display = "none";

            $('.tipe_surat').on('change', function(e) {
                var id = $(this).val();


                if (id == '0') {
                    undangan.style.display = "none";

                }
                if (id == '1') {
                    undangan.style.display = "block";

                }

            });

        });
    </script>

<script type="text/javascript">
    $(document).ready(function() {
      $('.fill').hide();
      $('#filter').on('change',function(e){
          var id = $(this).val();
          if (id == "semua") {
            $('#test-filter').show();
            $('.fill').hide();
          } else {
            $('#test-filter').hide();
            $('.fill').show();
          }
          $('#test').empty();
          //$('#price').append('<input class="form-control" type="text" name="price" value=' + 0 + '>');
          $.ajax({
            type : "POST",
            url  : "filter.php",
            dataType : "JSON",
            data : {id:id},
            success: function(data){
                $.each(data,function(key, value){
                    $('#test').append('<tr><td>'+value.no_agenda+'<br/><hr/>'+value.kode+'</td><td>'+value.isi+'<br/><br/><strong>File : '+value.file+'</strong></td><td>'+value.asal_surat+'</td><td>'+value.no_surat+'<br/><hr/>'+value.d+''+value.m+''+value.y+'</td><td>'+value.action+'</td></tr>');
                    
                });
            }
        });
          return false;
      });

    });
</script>

    <script type="text/javascript">
        //jquery dropdown
        $(".dropdown-button").dropdown({
            hover: false
        });

        //jquery sidenav on mobile
        $('.button-collapse').sideNav({
            menuWidth: 240,
            edge: 'left',
            closeOnClick: true
        });

        //jquery radio button
        // $("#tipe_surat").prop("checked", true);

        //jquery datepicker
        $('#tgl_surat,#tgl_agenda,#tgl_acara,#batas_waktu,#dari_tanggal,#sampai_tanggal').pickadate({
            selectMonths: true,
            selectYears: 10,
            format: "yyyy-mm-dd"
        });

        //jquery teaxtarea
        // $('#isi_ringkas').val('');
        // $('#isi_ringkas').trigger('autoresize');

        //jquery dropdown select dan tooltip
        $(document).ready(function() {
            $('select').material_select();
            $('.tooltipped').tooltip({
                delay: 10
            });
        });


        //jquery autocomplete
        $(function() {
            $("#asal_surat").autocomplete({
                source: 'auto.php'
            });
        })

        //jquery autocomplete
        $(function() {
            $("#kode").autocomplete({
                source: 'kode.php'
            });
        });

        //jquery untuk menampilkan pemberitahuan
        $("#alert-message").alert().delay(5000).fadeOut('slow');

        //jquery modal
        $(document).ready(function() {
            $('.modal-trigger').leanModal();
        });

        //JSON data Klasifikasi
        $(document).ready(function() {
            $.getJSON('klasifikasi.php', function(json) {
                $('#kode').html('');
                $.each(json, function(tambah_surat_masuk, row) {
                    $('#kode').append('<option value=' + row.kode + '>' + row.kode + '/' + row.nama + '</option>');
                });
            });
        });
        //JSON data Klasifikasi
        $(document).ready(function() {
            $.getJSON('', function(e) {
                $('#bidang').html('');
                $.each(e, function(tambah_user, row) {
                    $('#bidang').append('<option value=' + row.nama + '>' + row.nama + '</option>');
                });
            });
        });
    </script>
    <!-- Javascript END -->

<?php
} else {
    header("Location: ../");
    die();
}
?>