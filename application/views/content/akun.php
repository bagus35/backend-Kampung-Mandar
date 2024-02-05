<div class="wrap-post">
  <div class="list-post">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <div class="col-md-3 mb-25">
                <div class="foto-profil">
                  <div class="isi-foto-profil">
                    <?php
                    $ft = $d->foto_profil;
                    if ( $ft == "" || $ft == NULL ) {
                      $ft = base_url() . 'aset/img/user.png';
                    }
                    ?>
                    <img id="foto-profile" class="img-fluid" src="<?php echo $ft ;?>">
                    <input id="input-file" class="sem" type="file" accept="image/*" name="userfile">
                  </div>
                </div>
                <div class="btn-ganti">
                  <button id="btn-browse" class="btn btn-danger btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </div>
              </div>
              <div class="col-md-9">
                <div class="detail-akun">
                  <h1>Pengaturan Akun</h1>
                  <table class="table">
                    <tbody>
                      <tr id="i-nama" class="info-pengaturan">
                        <td width="80">Nama</td>
                        <td width="1">:</td>
                        <td class="i-nama"><?php echo $d->nama;?></td>
                        <td width="75"><a class="btn-edit-akun" href="javascript:void(0)" onClick="ganti_nama()"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
                      </tr>
                      <tr id="g-nama" class="form-pengaturan">
                        <td colspan="4"><br/>
                          <form class="was-validated" id="form-nama" method="post" action="<?php echo base_url('akun/ganti_nama') ?>">
                            <div class="row">
                              <div class="offset-md-3 col-md-6 offset-md-3">
                                <label for="nama">Nama : </label>
                                <div class="form-group">
                                  <input type="text" value="<?php echo $d->nama?>" class="form-control" name="nama" id="nama" required pattern=".{5,}">
                                  <div class="valid-feedback"><i>*valid</i> </div>
                                  <div class="invalid-feedback"><i>*wajib diisi minimal 5 karakter</i> </div>
                                </div>
                                <br/>
                                <label for="nama">Password : </label>
                                <div class="form-group">
                                  <input type="password" value="" style="-webkit-text-security: square;" class="form-control" name="password_nama" required>
                                </div>
                                <br/>
                                <div class="btn-group d-flex">
                                  <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                                  <button onClick="batalkan_nama()" type="reset" class="btn btn-primary w-100">Batalkan</button>
                                </div>
                                <br/>
                              </div>
                            </div>
                          </form></td>
                      </tr>
                      <tr id="i-email" class="info-pengaturan">
                        <td>Email</td>
                        <td>:</td>
                        <td class="i-email"><?php echo $d->email;?></td>
                        <td width="75"><a class="btn-edit-akun" href="javascript:void(0)" onClick="ganti_email()"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
                      </tr>
                      <tr id="g-email" class="form-pengaturan">
                        <td colspan="4"><br/>
                          <form class="was-validated" id="form-email" method="post" action="<?php echo base_url('akun/ganti_email') ?>">
                            <div class="row">
                              <div class="offset-md-3 col-md-6 offset-md-3">
                                <label for="email">Email : </label>
                                <div class="form-group">
                                  <input type="text" value="<?php echo $d->email?>" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                  <div class="valid-feedback"><i>*valid</i> </div>
                                  <div class="invalid-feedback"><i>*email kosong/format email salah</i> </div>
                                </div>
                                <br/>
                                <label for="nama">Password : </label>
                                <div class="form-group">
                                  <input type="password" value="" style="-webkit-text-security: square;" class="form-control" name="password_email" required>
                                </div>
                                <br/>
                                <div class="btn-group d-flex">
                                  <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                                  <button onClick="batalkan_email()" type="reset" class="btn btn-primary w-100">Batalkan</button>
                                </div>
                                <br/>
                              </div>
                            </div>
                          </form></td>
                      </tr>
                      <tr id="i-username" class="info-pengaturan">
                        <td>Username</td>
                        <td>:</td>
                        <td class="i-username"><?php echo $d->username;?></td>
                        <td width="75"><a class="btn-edit-akun" href="javascript:void(0)" onClick="ganti_username()"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
                      </tr>
                      <tr id="g-username" class="form-pengaturan">
                        <td colspan="4"><br/>
                          <form class="was-validated" id="form-username" method="post" action="<?= base_url('akun/ganti_username') ?>">
                            <div class="row">
                              <div class="offset-md-3 col-md-6 offset-md-3">
                                <label for="username">Username : </label>
                                <div class="form-group">
                                  <input type="text" value="<?php echo $d->username?>" class="form-control" name="username" id="username" pattern=".{5,}" required>
                                  <div class="valid-feedback"><i>*valid</i> </div>
                                  <div class="invalid-feedback"><i>*wajib diisi minimal 5 karakter</i> </div>
                                </div>
                                <br/>
                                <label for="nama">Password : </label>
                                <div class="form-group">
                                  <input type="password" value="" style="-webkit-text-security: square;" class="form-control" name="password_username" required>
                                </div>
                                <br/>
                                <div class="btn-group d-flex">
                                  <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                                  <button onClick="batalkan_username()" type="reset" class="btn btn-primary w-100">Batalkan</button>
                                </div>
                                <br/>
                              </div>
                            </div>
                          </form></td>
                      </tr>
                      <tr id="i-password" class="info-pengaturan">
                        <td>Password</td>
                        <td>:</td>
                        <td>*********</td>
                        <td width="75"><a class="btn-edit-akun" href="javascript:void(0)" onClick="ganti_password()"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
                      </tr>
                      <tr id="g-password" class="form-pengaturan">
                        <td colspan="4"><br/>
                          <form class="was-validated" id="form-password" method="post" action="<?= base_url('akun/ganti_password') ?>">
                            <div class="row">
                              <div class="offset-md-3 col-md-6 offset-md-3">
                                <label for="email">New Password : </label>
                                <div class="form-group">
                                  <input type="password" class="form-control" name="password" id="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                  <div class="valid-feedback"><i>*valid</i> </div>
                                  <div class="invalid-feedback"><i>*wajib menggunakan kombinasi angka dan huruf yang mengandung huruf kapital minimal 8 karakter</i> </div>
                                </div>
                                <br/>
                                <label for="email">Ulangi Password : </label>
                                <div class="form-group">
                                  <input type="password" class="form-control" name="ulangi_password" id="ulangi_password" required>
                                </div>
                                <br/>
                                <label for="nama">Password Lama: </label>
                                <div class="form-group">
                                  <input type="password" value="" style="-webkit-text-security: square;" class="form-control" name="password_lama" required>
                                </div>
                                <br/>
                                <div class="btn-group d-flex">
                                  <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                                  <button onClick="batalkan_password()" type="reset" class="btn btn-primary w-100">Batalkan</button>
                                </div>
                                <br/>
                              </div>
                            </div>
                          </form></td>
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
    </div>
  </div>
  <div id="ganti-foto" class="ganti-foto">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="title-page">
            <h3 class="tile-title"><i class="fa fa-eercast" aria-hidden="true"></i> GANTI FOTO PROFIL</h3>
            <div class="nav-back">
              <div class="btn-group d-flex btn-group-sm"> <a href="javascript:void(0)" onClick="ganti_foto_close()" class="btn btn-danger w-100"><i class="fa fa-window-close" aria-hidden="true"></i> CLOSE</a> </div>
            </div>
          </div>
          <div class="tile-body">
            <div class="row">
              <div class="col-md-12">
                <div id="upload-foto" class="upload-ft">
                  <div class="asem-bos">
                    <button id="btn-upload-foto" class="btn btn-primary">Upload</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('#pengaturan').addClass('active');
	$('#settings').addClass('radius-bawah');
	$('#lg').addClass('radius-atas');
    function ganti_foto_close() {
        $( '.ganti-foto' ).removeClass( "slide" );
        $( '.list-post' ).removeClass( "hide" );
    }
    function ganti_nama() {
        $( '#i-nama' ).hide();
        $( '#g-nama' ).show();
        $( "#password_nama" ).val( '' );
        $( '#nama' ).focus();
    }
    function ganti_email() {
        $( '#i-email' ).hide();
        $( '#g-email' ).show();
        $( "#password_email" ).val( '' );
        $( '#email' ).focus();
    }
    function ganti_username() {
        $( '#i-username' ).hide();
        $( '#g-username' ).show();
        $( "#password_username" ).val( '' );
        $( '#username' ).focus();
    }
    function ganti_password() {
        $( '#i-password' ).hide();
        $( '#g-password' ).show();
        $( '#form-password' )[ 0 ].reset();
        $( '#password' ).focus();
    }
    function batalkan_nama() {
        $( '#i-nama' ).show();
        $( '#g-nama' ).hide();
        $( "#password_nama" ).val( '' );
    }
    function batalkan_email() {
        $( '#i-email' ).show();
        $( '#g-email' ).hide();
        $( "#password_email" ).val( '' );
    }
    function batalkan_username() {
        $( '#i-username' ).show();
        $( '#g-username' ).hide();
        $( "#password_username" ).val( '' );
    }
    function batalkan_password() {
        $( '#i-password' ).show();
        $( '#g-password' ).hide();
        $( '#form-password' )[ 0 ].reset();
    }
    $( function () {
        $( document ).on( 'click', '#btn-browse', function () {
            var file = $( this ).parent().parent().parent().find( '#input-file' );
            file.trigger( 'click' );
        } );
        $( '#btn-reset' ).click( function () {
            $( '#input-file' ).val( "" );
            $( '#img-ganti-foto' ).attr( 'src', '<?php echo $ft ;?>' );
        } );
        $( "#input-file" ).change( function ( e ) {
            var input = this;
            var url = $( this ).val();
            var ext = url.substring( url.lastIndexOf( '.' ) + 1 ).toLowerCase();
            if ( input.files && input.files[ 0 ] && ( ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" ) ) {
                var reader = new FileReader();
                reader.onload = function ( e ) {
                    $( '#img-result' ).attr( 'src', e.target.result );
                    $uploadCrop.croppie( 'bind', {
                        url: e.target.result
                    } ).then( function () {} );
                }
                $( '.list-post' ).addClass( "hide" );
                $( '#ganti-foto' ).addClass( "slide" );
                reader.readAsDataURL( input.files[ 0 ] );
            } else {
                $( '#img-ganti-foto' ).attr( 'src', '<?php echo $ft ;?>' );
            }
        } );
    } );
    $uploadCrop = $( '#upload-foto' ).croppie( {
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        }
    } );
    /* UPLOAD PROFIL*/
    $( '#btn-upload-foto' ).on( 'click', function ( ev ) {
        $( '.loading-1' ).fadeIn( 'fast' );
        $uploadCrop.croppie( 'result', {
            type: 'canvas',
            size: 'viewport'
        } ).then( function ( resp ) {
            $.ajax( {
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener( "progress", function ( evt ) {
                        if ( evt.lengthComputable ) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt( percentComplete * 100 );
                            $( '.progress-bar' ).css( 'width', percentComplete + "%" );
                            $( '.progress-bar' ).html( percentComplete + "%" );
                            $( '#jml_qr' ).text( '[ ' + percentComplete + "% ]" );
                            if ( percentComplete === 100 ) {
                                $( '.progress-bar' ).removeClass( 'bg-info' ).addClass( 'bg-success' );
                            }
                        }
                    } );
                    return xhr;
                },
                url: "<?php echo base_url('akun/upload_foto');?>",
                type: "POST",
                data: {
                    "image": resp
                },
                success: function ( data ) {
                    $( '.loading-1' ).fadeOut( 'fast' );
                    $( '#foto-profile' ).attr( "src", resp );
                    $( '#side-foto' ).attr( "src", resp );
                    ganti_foto_close();
                    Swal.fire( "BERHASIL", "Foto Profil Berhasil diganti", "success" );
                }
            } );
        } );
    } );
    $( function () {
        $( '#form-nama' ).submit( function ( evt ) {
            $( '.loading' ).fadeIn( 'fast' );
            evt.preventDefault();
            evt.stopImmediatePropagation();
            var url = $( this ).attr( 'action' );
            var formData = new FormData( $( this )[ 0 ] );
            $.ajax( {
                url: url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function ( data ) {
                    if ( data.status ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "success" );
                        $( '.i-nama' ).text( $( "#nama" ).val() );
                        $( '#side-nama' ).text( $( "#nama" ).val() );
                        $( '#i-nama' ).show();
                        $( '#g-nama' ).hide();
                        $( "#password_nama" ).val( '' );
                    } else {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "error" );
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    $( '.loading' ).fadeOut( 'fast' );
                    Swal.fire( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
                }
            } );
        } );
    } );
    $( function () {
        $( '#form-email' ).submit( function ( evt ) {
            $( '.loading' ).fadeIn( 'fast' );
            evt.preventDefault();
            evt.stopImmediatePropagation();
            var url = $( this ).attr( 'action' );
            var formData = new FormData( $( this )[ 0 ] );
            $.ajax( {
                url: url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function ( data ) {
                    if ( data.status ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "success" );
                        $( '.i-email' ).text( $( "#email" ).val() );
                        $( '#side-email' ).text( $( "#email" ).val() );
                        $( '#i-email' ).show();
                        $( '#g-email' ).hide();
                        $( "#password_email" ).val( '' );
                    } else {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "error" );
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    $( '.loading' ).fadeOut( 'fast' );
                    Swal.fire( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
                }
            } );
        } );
    } );
    $( function () {
        $( '#form-username' ).submit( function ( evt ) {
            $( '.loading' ).fadeIn( 'fast' );
            evt.preventDefault();
            evt.stopImmediatePropagation();
            var url = $( this ).attr( 'action' );
            var formData = new FormData( $( this )[ 0 ] );
            $.ajax( {
                url: url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function ( data ) {
                    if ( data.status ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "success" );
                        $( '.i-username' ).text( $( "#username" ).val() );
                        $( '#i-username' ).show();
                        $( '#g-username' ).hide();
                        $( "#password_username" ).val( '' );
                    } else {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "error" );
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    $( '.loading' ).fadeOut( 'fast' );
                    Swal.fire( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
                }
            } );
        } );
    } );
    $( function () {
        $( '#form-password' ).submit( function ( evt ) {
            $( '.loading' ).fadeIn( 'fast' );
            evt.preventDefault();
            evt.stopImmediatePropagation();
            var url = $( this ).attr( 'action' );
            var formData = new FormData( $( this )[ 0 ] );
            $.ajax( {
                url: url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function ( data ) {
                    if ( data.status ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "success" );
                        $( '.i-password' ).text( $( "#password" ).val() );
                        $( '#i-password' ).show();
                        $( '#g-password' ).hide();
                        $( '#form-password' )[ 0 ].reset();
                    } else {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( data.judul_pesan, data.pesan, "error" );
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    $( '.loading' ).fadeOut( 'fast' );
                    Swal.fire( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
                }
            } );
        } );
    } );
</script>