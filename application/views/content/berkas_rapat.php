<?php
$id = encrypt_url($isi->id_rapat);
$foto_rapat = $isi->foto_rapat ?: 'aset/img/belum_diupload.jpg';
$foto_absensi = $isi->foto_absensi ?: 'aset/img/no_berkas.jpg';
$dokumentasi1 = $isi->dokumentasi1 ?: 'aset/img/no_berkas.jpg';
$dokumentasi2 = $isi->dokumentasi2 ?: 'aset/img/no_berkas.jpg';

?>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="title-page">
                <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DOKUMENTASI RAPAT BULANAN</h3>
                <div class="nav-back">
                    <div class="btn-group" role="group" aria-label="Basic example"> 
                        <a class="btn btn-sm btn-danger btn-rounded" href="<?php echo base_url(); ?>rapat_bulanan"><i class="fa fa-close" aria-hidden="true"></i> Close</a> <a href="<?php base_url(); ?>rapat_bulanan/cetak_pdf?q=<?php echo $id; ?>" class="btn btn-sm btn-warning" id="btn-close"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Cetak</a>
                        <!-- <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" onClick="goBack()"><i class="fa fa-close" aria-hidden="true"></i> Close</a>  -->
                     </div>
                </div>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="150">Tanggal </td>
                                    <td width="40">:</td>
                                    <td><?php echo $isi->tanggal; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Kelompok</td>
                                    <td>:</td>
                                    <td><?php echo $isi->nama_kelompok; ?></td>
                                </tr>
                                <tr>
                                    <td>Notulensi</td>
                                    <td>:</td>
                                    <td><?php echo $isi->notulen; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="title-page">
                <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DOKUMENTASI RAPAT</h3>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="berkas-rapat">
                            <h5>FOTO ABSENSI</h5>
                            <form method="post" role="form" class="was-validated" 
                            action="<?php echo base_url(); ?>rapat_bulanan/upload_absensi" 
                            enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label">Upload Absensi <i>( jpg|jpeg|png )</i></label>
                                    <input id="input-absensi" class="sem" type="file" 
                                    accept="image/*" name="foto_absensi">
                                    <input type="hidden" name="id_rapat" 
                                    value="<?php echo $id; ?>" class="form-control" required>
                        
                                    <div class="input-group mb-3">
                                        <input id="foto-absensi" type="text" 
                                        class="form-control" required>
                                        <div class="input-group-append">
                                            <button id="btn-clear-absensi" type="button" class="btn btn-warning sem">
                                                <i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
                                            <button id="btn-browse-absensi" type="button" class="btn btn-danger">
                                                <i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
                                            <button id="btn-absensi" type="submit" 
                                            class="btn btn-primary sem"><i class="fa fa-floppy-o " 
                                            aria-hidden="true"></i>Upload</button>
                                        </div>
                                        <div class="valid-feedback"><i>*valid</i> </div>
                                        <div class="invalid-feedback"><i>*required</i> </div>
                                    </div>
                                </div>
                            </form>
                            <a href="javascript:void(0)" 
                            onclick="lihat_foto('<?php echo base_url() . $foto_absensi; ?> ')">
                                <div class="berkas"> 
                                    <img id="foto-absensi" src="<?php echo base_url() . $foto_absensi; ?>" class="img-fluid"> </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="berkas-rapat">
                            <h5>DOKUMENTASI 1</h5>
                            <form method="post" role="form" 
                            class="was-validated" 
                            action="<?php echo base_url(); ?>rapat_bulanan/upload_dokumentasi1"
                            enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="control-label">Upload Dokumentasi 1 <i>( jpg|jpeg|png )</i></label>
                                    <input id="input-dokumentasi1" class="sem" 
                                    type="file" accept="image/*" name="dokumentasi1">
                                    <input type="hidden" name="id_rapat" value="<?php echo $id; ?>" class="form-control" required>
                                    <div class="input-group mb-3">
                                        <input id="foto-dokumentasi1" type="text" class="form-control" required>
                                        <div class="input-group-append">
                                            <button id="btn-clear-dokumentasi1" 
                                            type="button" class="btn btn-warning sem">
                                            <i class="fa fa-refresh " aria-hidden="true">
                                            </i>Clear
                                        </button>
                                            <button id="btn-browse-dokumentasi1" 
                                            type="button" class="btn btn-danger">
                                            <i class="fa fa-folder-open-o" aria-hidden="true">
                                            </i>Browse
                                        </button>
                                            <button id="btn-dokumentasi1" 
                                            type="submit" class="btn btn-primary sem">
                                            <i class="fa fa-floppy-o " aria-hidden="true">
                                            </i>Upload
                                        </button>
                                        </div>
                                        <div class="valid-feedback"><i>*valid</i> </div>
                                        <div class="invalid-feedback"><i>*required</i> </div>
                                    </div>
                                </div>
                            </form>
                            <a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $dokumentasi1; ?> ')">
                                <div id="foto_absensi" class="berkas"> 
                                    <img src="<?php echo base_url() . $dokumentasi1; ?>" 
                                    class="img-fluid"> </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="berkas-rapat">
                            <h5>DOKUMENTASI 2</h5>
                            <form method="post" role="form" class="was-validated" 
                            action="<?php echo base_url(); ?>rapat_bulanan/upload_dokumentasi2" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label">Upload Dokumentasi 2 <i>( jpg|jpeg|png )</i></label>
                                    <input id="input-dokumentasi2" class="sem" 
                                    type="file" accept="image/*" name="dokumentasi2">
                                    <input type="hidden" name="id_rapat" 
                                    value="<?php echo $id; ?>" class="form-control" required>
                                    
                                    <div class="input-group mb-3">
                                        <input id="foto-dokumentasi2" 
                                        type="text" class="form-control" required>
                                        <div class="input-group-append">
                                            <button id="btn-clear-dokumentasi2" 
                                            type="button" class="btn btn-warning sem">
                                            <i class="fa fa-refresh " aria-hidden="true">
                                            </i>Clear</button>
                                            <button id="btn-browse-dokumentasi2" 
                                            type="button" class="btn btn-danger">
                                            <i class="fa fa-folder-open-o" aria-hidden="true">
                                            </i>Browse</button>
                                            <button id="btn-dokumentasi2" 
                                            type="submit" class="btn btn-primary sem">
                                            <i class="fa fa-floppy-o " aria-hidden="true">
                                            </i>Upload</button>
                                        </div>
                                        <div class="valid-feedback"><i>*valid</i> </div>
                                        <div class="invalid-feedback"><i>*required</i> </div>
                                    </div>
                                </div>
                            </form>
                            <a href="javascript:void(0)" onclick="lihat_foto('
                            <?php echo base_url() . $dokumentasi2; ?> ')">
                                <div id="absensi" class="berkas"> 
                                    <img src="<?php echo base_url() . $dokumentasi2; ?>" 
                                    class="img-fluid"> </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="berkas-rapat">
                                <h5>FOTO RAPAT</h5>
                                <a href="javascript:void(0)" onclick="lihat_foto('<?php echo base_url() . $foto_rapat; ?> ')">
                                    <div class="berkas">
                                        <img id="foto-absensi" src="<?php echo base_url() . $foto_rapat; ?>" class="img-fluid">
                                    </div>
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="fotone" class="show-fotone sembunyi"> <a href="#" id="img-fotone"> <img id="isi-fotone" class="img-fluid"> </a> </div>
<script type="text/javascript">
    $('#rapat_bulanan').addClass('active');
    $('#perahu').addClass('radius-bawah');
    $('#produksi').addClass('radius-atas');

    function goBack() {
        window.history.back();
    }
    
    function show_data() {
        $.ajax({
            url: "<?php echo site_url('rapat_bulanan/get_berkas') ?>",
            type: "POST",
            data: {
                q: "<?php echo $id; ?>"
            },
            dataType: "JSON",
            success: function(data) {
                $('.loading').fadeOut('fast');

                $('#foto_absensi').attr('src', data.absensi);
                $('#dokumentasi1').attr('src', data.dokumentasi1);
                $('#dokumentasi2').attr('src', data.dokumentasi2);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('.loading').fadeOut('fast');
                Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
            }
        });
    }

    function lihat_foto(b) {
        $('#isi-fotone').attr('src', b);
        $('#img-fotone').attr('href', b);
        lightGallery(document.getElementById('fotone'), {
            thumbnail: true,
            animateThumb: false,
            showThumbByDefault: false
        });
        $('#img-fotone')[0].click();
    };

    $(document).on('click', '#btn-browse-absensi', function() {
        var file = $(this).parent().parent().parent().find('#input-absensi');
        file.trigger('click');
    });
    $(function() {
        $('#btn-clear-absensi').click(function() {
            $('#foto-absensi').val("");
            $('#input-absensi').val("");
            $("#btn-browse-absensi").show();
            $("#btn-absensi").hide();
            $(this).hide();
        });
        $("#input-absensi").change(function(e) {
            var fileName = e.target.files[0].name;
            $('#foto-absensi').val(fileName);
            $('#btn-clear-absensi').show();
            $("#btn-browse-absensi").hide();
            $("#btn-absensi").show();
        });
    });


    $(document).on('click', '#btn-browse-dokumentasi1', function() {
        var file = $(this).parent().parent().parent().find('#input-dokumentasi1');
        file.trigger('click');
    });
    $(function() {
        $('#btn-clear-dokumentasi1').click(function() {
            $('#foto-dokumentasi1').val("");
            $('#input-dokumentasi1').val("");
            $("#btn-browse-dokumentasi1").show();
            $("#btn-dokumentasi1").hide();
            $(this).hide();
        });
        $("#input-dokumentasi1").change(function(e) {
            var fileName = e.target.files[0].name;
            $('#foto-dokumentasi1').val(fileName);
            $('#btn-clear-dokumentasi1').show();
            $("#btn-browse-dokumentasi1").hide();
            $("#btn-dokumentasi1").show();
        });
    });

    $(document).on('click', '#btn-browse-dokumentasi2', function() {
        var file = $(this).parent().parent().parent().find('#input-dokumentasi2');
        file.trigger('click');
    });
    $(function() {
        show_data();
        $('#btn-clear-dokumentasi2').click(function() {
            $('#foto-dokumentasi2').val("");
            $('#input-dokumentasi2').val("");
            $("#btn-browse-dokumentasi2").show();
            $("#btn-dokumentasi2").hide();
            $(this).hide();
        });
        $("#input-dokumentasi2").change(function(e) {
            var fileName = e.target.files[0].name;
            $('#foto-dokumentasi2').val(fileName);
            $('#btn-clear-dokumentasi2').show();
            $("#btn-browse-dokumentasi2").hide();
            $("#btn-dokumentasi2").show();
        });
    });

    $(function() {
        $('.was-validated').submit(function(evt) {
            evt.preventDefault();
            evt.stopImmediatePropagation();
            $('.loading').fadeOut('fast');
            $('.loading-1').fadeIn('fast');
            $('.progress-bar').css('width', "0%");
            $('.progress-bar').html("0%");
            $('.progress-bar').removeClass('bg-success').addClass('bg-info');
            $('#jml_qr').text('[ 0% ]');
            var url = $(this).attr('action');
            var formData = new FormData($(this)[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.progress-bar').css('width', percentComplete + "%");
                            $('.progress-bar').html(percentComplete + "%");
                            $('#jml_qr').text('[ ' + percentComplete + "% ]");
                            if (percentComplete === 100) {
                                $('.progress-bar').removeClass('bg-info').addClass('bg-success');
                            }
                        }
                    });
                    return xhr;
                },
                url: url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.loading-1').fadeOut('fast');
                    if (data.status) {
                        $('.loading').fadeOut('fast');
                        $('#btn-clear-absensi').trigger('click');
                        $('#btn-clear-dokumentasi1').trigger('click');
                        $('#btn-clear-dokumentasi2').trigger('click');
                        location.reload();
                    } else {
                        Swal.fire("Upss... !", data.pesan, "error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('.loading-1').fadeOut('fast');
                    Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error');
                }
            });

        });
    });
</script>