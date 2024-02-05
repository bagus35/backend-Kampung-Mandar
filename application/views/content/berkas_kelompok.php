<?php
$id = encrypt_url($isi->id_kelompok);

$foto_sk = $isi->foto_sk ?: 'aset/img/no_berkas.jpg';
$foto_ad_art = $isi->foto_ad_art ?: 'aset/img/no_berkas.jpg';
$foto_sekertariat = $isi->foto_sekertariat ?: 'aset/img/no_berkas.jpg';

?>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="title-page">
                <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> BERKAS KELOMPOK</h3>
                <div class="nav-back">
                    <div class="btn-group" role="group" aria-label="Basic example"> 
                        <a class="btn btn-sm btn-danger btn-rounded" href="<?php echo base_url(); ?>kelompok_nelayan"><i class="fa fa-close" aria-hidden="true"></i> Close</a> <a href="<?php base_url(); ?>kelompok_nelayan/cetak_pdf?q=<?php echo $id; ?>" class="btn btn-sm btn-warning" id="btn-close"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Cetak</a>
                        <!-- <a href="javascript:;" class="btn btn-sm btn-danger btn-rounded" onClick="delete_data('<?php echo $id; ?>')"><i class="fa fa-close" aria-hidden="true"></i>Delete</a>  -->
                     </div>
                </div>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="150">Nama Kelompok </td>
                                    <td width="40">:</td>
                                    <td><?php echo $isi->nama_kelompok; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Ketua</td>
                                    <td>:</td>
                                    <td><?php echo $isi->nama_ketua; ?></td>
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
                <h3 class="tile-title"><i class="fa fa-list" aria-hidden="true"></i> DOKUMENTASI kelompok</h3>
            </div>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="berkas-kelompok">
                            <h5>FOTO SK</h5>
                            <form method="post" role="form" class="was-validated" 
                            action="<?php echo base_url(); ?>kelompok_nelayan/upload_sk" 
                            enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label">Upload SK <i>( jpg|jpeg|png )</i></label>
                                    <input id="input-foto_sk" class="sem" type="file" 
                                    accept="image/*" name="foto_sk">
                                    <input type="hidden" name="id_kelompok" 
                                    value="<?php echo $id; ?>" class="form-control" required>
                        
                                    <div class="input-group mb-3">
                                        <input id="foto-foto_sk" type="text" 
                                        class="form-control" required>
                                        <div class="input-group-append">
                                            <button id="btn-clear-foto_sk" type="button" class="btn btn-warning sem">
                                                <i class="fa fa-refresh " aria-hidden="true"></i>Clear</button>
                                            <button id="btn-browse-foto_sk" type="button" class="btn btn-danger">
                                                <i class="fa fa-folder-open-o" aria-hidden="true"></i>Browse</button>
                                            <button id="btn-foto_sk" type="submit" 
                                            class="btn btn-primary sem"><i class="fa fa-floppy-o " 
                                            aria-hidden="true"></i>Upload</button>
                                        </div>
                                        <div class="valid-feedback"><i>*valid</i> </div>
                                        <div class="invalid-feedback"><i>*required</i> </div>
                                    </div>
                                </div>
                            </form>
                            <a href="javascript:void(0)" 
                            onclick="lihat_foto('<?php echo base_url() . $foto_sk; ?> ')">
                                <div class="berkas"> 
                                    <img id="foto_sk" src="<?php echo base_url() . $foto_sk; ?>" class="img-fluid"> </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="berkas-kelompok">
                            <h5>FOTO AD ART</h5>
                            <form method="post" role="form" 
                            class="was-validated" 
                            action="<?php echo base_url(); ?>kelompok_nelayan/upload_ad_art"
                            enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="control-label">Upload Foto AD ART <i>( jpg|jpeg|png )</i></label>
                                    <input id="input-foto_ad_art" class="sem" 
                                    type="file" accept="image/*" name="foto_ad_art">
                                    <input type="hidden" name="id_kelompok" value="<?php echo $id; ?>" class="form-control" required>
                                    <div class="input-group mb-3">
                                        <input id="foto-foto_ad_art" type="text" class="form-control" required>
                                        <div class="input-group-append">
                                            <button id="btn-clear-foto_ad_art" 
                                            type="button" class="btn btn-warning sem">
                                            <i class="fa fa-refresh " aria-hidden="true">
                                            </i>Clear
                                        </button>
                                            <button id="btn-browse-foto_ad_art" 
                                            type="button" class="btn btn-danger">
                                            <i class="fa fa-folder-open-o" aria-hidden="true">
                                            </i>Browse
                                        </button>
                                            <button id="btn-foto_ad_art" 
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
                            <a href="javascript:void(0)" 
                            onclick="lihat_foto('<?php echo base_url() . 
                            $foto_ad_art; ?> ')">
                                <div id="foto_ad_art" class="berkas"> 
                                    <img src="<?php echo base_url() . $foto_ad_art; ?>" 
                                    class="img-fluid"> </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="berkas-kelompok">
                            <h5>Foto Sekertariat</h5>
                            <form method="post" role="form" class="was-validated" 
                            action="<?php echo base_url(); ?>kelompok_nelayan/upload_sekertariat" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label">Upload Foto Sekertariat<i>( jpg|jpeg|png )</i></label>
                                    <input id="input-foto_sekertariat" class="sem" 
                                    type="file" accept="image/*" name="foto_sekertariat">
                                    <input type="hidden" name="id_kelompok" 
                                    value="<?php echo $id; ?>" class="form-control" required>
                                    
                                    <div class="input-group mb-3">
                                        <input id="foto-foto_sekertariat" 
                                        type="text" class="form-control" required>
                                        <div class="input-group-append">
                                            <button id="btn-clear-foto_sekertariat" 
                                            type="button" class="btn btn-warning sem">
                                            <i class="fa fa-refresh " aria-hidden="true">
                                            </i>Clear</button>
                                            <button id="btn-browse-foto_sekertariat" 
                                            type="button" class="btn btn-danger">
                                            <i class="fa fa-folder-open-o" aria-hidden="true">
                                            </i>Browse</button>
                                            <button id="btn-foto_sekertariat" 
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
                            <?php echo base_url() . $foto_sekertariat; ?> ')">
                                <div id="foto_sekertariat" class="berkas"> 
                                    <img src="<?php echo base_url() . $foto_sekertariat; ?>" 
                                    class="img-fluid"> </div>
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
    $('#kelompok_nelayan').addClass('active');
    $('#perahu').addClass('radius-bawah');
    $('#produksi').addClass('radius-atas');

    function show_data() {
        $.ajax({
            url: "<?php echo site_url('kelompok_nelayan/get_berkas') ?>",
            type: "POST",
            data: {
                q: "<?php echo $id; ?>"
            },
            dataType: "JSON",
            success: function(data) {
                $('.loading').fadeOut('fast');

                $('#foto_sk').attr('src', data.foto_sk);
                $('#foto_ad_art').attr('src', data.foto_ad_art);
                $('#foto_sekertariat').attr('src', data.foto_sekertariat);
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

    $(document).on('click', '#btn-browse-foto_sk', function() {
        var file = $(this).parent().parent().parent().find('#input-foto_sk');
        file.trigger('click');
    });
    $(function() {
        $('#btn-clear-foto_sk').click(function() {
            $('#foto-foto_sk').val("");
            $('#input-foto_sk').val("");
            $("#btn-browse-foto_sk").show();
            $("#btn-foto_sk").hide();
            $(this).hide();
        });
        $("#input-foto_sk").change(function(e) {
            var fileName = e.target.files[0].name;
            $('#foto-foto_sk').val(fileName);
            $('#btn-clear-foto_sk').show();
            $("#btn-browse-foto_sk").hide();
            $("#btn-foto_sk").show();
        });
    });


    $(document).on('click', '#btn-browse-foto_ad_art', function() {
        var file = $(this).parent().parent().parent().find('#input-foto_ad_art');
        file.trigger('click');
    });
    $(function() {
        $('#btn-clear-foto_ad_art').click(function() {
            $('#foto-foto_ad_art').val("");
            $('#input-foto_ad_art').val("");
            $("#btn-browse-foto_ad_art").show();
            $("#btn-foto_ad_art").hide();
            $(this).hide();
        });
        $("#input-foto_ad_art").change(function(e) {
            var fileName = e.target.files[0].name;
            $('#foto-foto_ad_art').val(fileName);
            $('#btn-clear-foto_ad_art').show();
            $("#btn-browse-foto_ad_art").hide();
            $("#btn-foto_ad_art").show();
        });
    });

    $(document).on('click', '#btn-browse-foto_sekertariat', function() {
        var file = $(this).parent().parent().parent().find('#input-foto_sekertariat');
        file.trigger('click');
    });
    $(function() {
        show_data();
        $('#btn-clear-foto_sekertariat').click(function() {
            $('#foto-foto_sekertariat').val("");
            $('#input-foto_sekertariat').val("");
            $("#btn-browse-foto_sekertariat").show();
            $("#btn-foto_sekertariat").hide();
            $(this).hide();
        });
        $("#input-foto_sekertariat").change(function(e) {
            var fileName = e.target.files[0].name;
            $('#foto-foto_sekertariat').val(fileName);
            $('#btn-clear-foto_sekertariat').show();
            $("#btn-browse-foto_sekertariat").hide();
            $("#btn-foto_sekertariat").show();
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
                        $('#btn-clear-foto_sk').trigger('click');
                        $('#btn-clear-foto_ad_art').trigger('click');
                        $('#btn-clear-foto_sekertariat').trigger('click');
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