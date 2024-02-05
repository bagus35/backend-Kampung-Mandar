<?php

$hak = $this->session->userdata('hak');
$id_kelompok = $this->session->userdata('id_kelompok');
?>
<div id="inputan"class="row sembunyi">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-user-secret" aria-hidden="true"></i> ADD ACCOUNT</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-danger btn-sm" id="btn-close"><i class="fa fa-times" aria-hidden="true"></i> CLOSE</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <form method="post" class="was-validated" id="form-add" action="<?php echo base_url();?>user_management/save">
          <input type="hidden" class="form-control" id="no_telp_lama" name="no_telp_lama">
          <input type="hidden" class="form-control" id="username_lama" name="username_lama">
          <div class="x-kotak-input">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Nama :</label>
                  <input type="text" class="form-control" id="nama" name="nama" autofocus required>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*wajib diisi</i> </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Username :</label>
                  <input type="text" class="form-control" id="username" name="username" pattern=".{5,}" required>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*wajib diisi minimal 5 karakter</i> </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Password :</label>
                  <input type="text" class="form-control" id="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*wajib menggunakan kombinasi angka dan huruf yang mengandung huruf kapital minimal 8 karakter</i> </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Email :</label>
                  <input type="email" class="form-control" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*email kosong/format email salah</i> </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">No HP : <i>[didepan tanpa 0 (ex : 81336123456)]</i></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend"> <span class="input-group-text">+62</span> </div>
                    <input type="tel" class="form-control angka-int" name="no_hp" id="no_hp" type="tel" maxlength="11" minlength="10" required>
                    <div class="valid-feedback"><i>*valid</i> </div>
                    <div class="invalid-feedback"><i>*no hp kosong/format hp salah</i> </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Hak Akses :</label>
                  <select class="form-control" name="hak_akses" id="hak_akses" required>
                   
					  <?php if($hak < 3){ ?>
					   <option></option>
                    <option value="1">Super User</option>
                    <option value="2">Admin</option>
                    <option value="3">Ketua Kelompok</option>
					  	  <?php }?>
                    <option value="4">Nelayan</option>
				
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*wajib diisi</i> </div>
                </div>
              </div>
				  <?php if($hak < 3){ ?>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Nama Kelompok :</label>
                  <select class="form-control boot-select" name="id_kelompok" id="id_kelompok" disabled>
                    <option></option>
                    <?php

                    foreach ( $kelompok as $k ) {
                      echo '<option value="' . encrypt_url( $k->id_kelompok ) . '">' . $k->nama_kelompok . '</option>';
                    }

                    ?>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*wajib diisi</i> </div>
                </div>
              </div>
				<?php }?>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Nama Nelayan :</label>
                  <select class="form-control boot-select" name="id_nelayan" id="id_nelayan">
                    <option></option>
                  </select>
                  <div class="valid-feedback"><i>*valid</i> </div>
                  <div class="invalid-feedback"><i>*wajib diisi</i> </div>
                </div>
              </div>
              <div class="col-md-4 btn-kebawah">
                <div class="btn-group d-flex">
                  <button id="btn-save" type="submit" class="btn btn-primary w-100"><i class="fa fa-floppy-o"></i> Save</button>
                  <button type="reset" onClick="reset_form()" class="btn btn-danger w-100"><i class="fa fa-retweet"></i> Reset</button>
                </div>
              </div>
            </div>
            <br>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="isi-datane" class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="title-page">
        <h3 class="tile-title"><i class="fa fa-user-secret" aria-hidden="true"></i> ACCOUNT LIST</h3>
        <div class="nav-back">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-primary btn-sm" id="btn-add"><i class="fa fa-plus-square" aria-hidden="true"></i> ADD ACCOUNT</button>
          </div>
        </div>
      </div>
      <div class="tile-body">
        <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Actions</th>
              <th>No</th>
              <th>Nama</th>
              <th>No HP.</th>
              <th>Email</th>
              <th>Username</th>
              <th>Password</th>
              <th>Hak Akses</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $( '#user' ).addClass( 'active' );
	$('#bbm').addClass('radius-bawah');
	$('#settings').addClass('radius-atas');
    var table = $( '#table' ).DataTable( {
        "oLanguage": {
            "sSearch": "Cari User: ",
            "sSearchPlaceholder": ""
        },
        "processing": true,
        responsive: true,
        "serverSide": true,
        'paging': true,
        'lengthChange': true,
        'ordering': false,
        'info': false,
        'autoWidth': false,
        "aLengthMenu": [
            [ 25, 50, 100, -1 ],
            [ 25, 50, 100, "Semua" ]
        ],
        "ajax": {
            "url": "<?php echo site_url('user_management/ajax_list')?>",
            "type": "POST"
        },
        "columnDefs": [ {
            className: "text-center",
            "targets": [ 0 ],
            width: '80'
        }, {
            className: "text-center",
            "targets": [ 1 ]
        }, ]
    } );
    function reload_table() {
        table.ajax.reload( null, false ); //reload datatable ajax
    }
    function reset_form() {
        $( '#form-add' )[ 0 ].reset();
        $( '#btn-save' ).html('<i class="fa fa-floppy-o"></i> Save');
        $( '#form-add' ).attr( 'action', '<?php echo base_url();?>user_management/save' );
        $( '#password' ).get( 0 ).setAttribute( 'type', 'text' );
        $( '#username' ).get( 0 ).setAttribute( 'type', 'text' );
        $( "#username" ).prop( 'required', true );
        $( "#password" ).prop( 'required', true );
        $( "#username" ).prop( 'disabled', false );
        $( "#password" ).prop( 'disabled', false );
        $( "#id_kelompok" ).prop( 'disabled', true );
        $( "#id_nelayan" ).prop( 'disabled', true );
		$('#id_kelompok').val("").trigger('change');
		$('#id_nelayan').val("").trigger('change');
        $( '#nama' ).focus();
    }
	$('#btn-add').click(function(){
		$('#inputan').removeClass('sembunyi');
		$('#isi-datane').addClass('sembunyi');
		reset_form();
		$( '#nama' ).focus();
	});
	$('#btn-close').click(function(){
		$('#inputan').addClass('sembunyi');
		$('#isi-datane').removeClass('sembunyi');
	});
    $( '#username' ).blur( function ( event ) {
        var u = $( '#username' ).val();
        var ul = $( '#username_lama' ).val();
        if ( u.length > 4 && u != ul ) {
            $( '.loading' ).fadeIn( 'fast' );
            $.ajax( {
                url: "<?php echo site_url('user_management/cek_username')?>",
                type: "POST",
                data: {
                    username: u
                },
                dataType: "JSON",
                success: function ( data ) {
                    $( '.loading' ).fadeOut( 'fast' );
                    if ( !data.status ) {
                        Swal.fire( {
                            title: "Username Telah digunakan",
                            text: "Mohon gunakan username yang lain",
                            type: "error",
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok',
                            cancelButtonText: "No",
                        } ).then( ( result ) => {
                            if ( result.value ) {
                                $( "#username" ).val( "" );
                                window.setTimeout( function () {
                                    $( '#username' ).focus();
                                }, 500 );
                            }
                        } );
                    } else {
                        $( '#password' ).focus();
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    $( '.loading' ).fadeOut( 'fast' );
                    swal( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
                    hasil = false;
                }
            } );
        }
    } );
    function edit_data( id ) {
        $( '.loading' ).fadeIn( 'fast' );
        $( '#form-add' )[ 0 ].reset();
        $( '#form-add' ).attr( 'action', "<?php echo base_url('user_management/update?q=');?>" + id );
        $.ajax( {
            url: "<?php echo site_url('user_management/edit')?>",
            type: "POST",
            data: {
                q: id
            },
            dataType: "JSON",
            success: function ( data ) {
                $( '.loading' ).fadeOut( 'fast' );
				var hak = data.hak_akses ;
                $( '#password' ).get( 0 ).setAttribute( 'type', 'password' );
                $( '#username' ).get( 0 ).setAttribute( 'type', 'password' );
                $( "#username" ).prop( 'required', false );
                $( "#password" ).prop( 'required', false );
                $( "#username" ).prop( 'disabled', true );
                $( "#password" ).prop( 'disabled', true );
                $( '#nama' ).val( data.nama );
                $( '#username' ).val( data.username );
                $( '#username_lama' ).val( data.username );
                $( '#email' ).val( data.email );
                $( '#password' ).val( data.password );
                $( '#email' ).val( data.email );
                $( '#no_hp' ).val( data.no_hp );
                $( '#hak_akses' ).val( data.hak_akses );
				
				if(hak < 3 ){
			$('#id_kelompok').attr('disabled','disabled');
			$('#id_nelayan').attr('disabled','disabled');
			$('#id_nelayan').prop('required',false);
			$('#id_kelompok').prop('required',false);
				$('#id_kelompok').val("").trigger('change');
			$('#id_nelayan').val("").trigger('change');
		}else if(hak == 3){
			$('#id_kelompok').removeAttr('disabled');
			$('#id_kelompok').prop('required',true);
			$('#id_nelayan').attr('disabled','disabled');
			$('#id_nelayan').val("").trigger('change');
			$('#id_nelayan').prop('required',false);
			$('#id_kelompok').val(data.id_kelompok).trigger('change');
		
		}else{
			$('#id_kelompok').removeAttr('disabled');
			$('#id_nelayan').removeAttr('disabled');
			$('#id_nelayan').prop('required',true);
			$('#id_kelompok').prop('required',true);
			$('#id_kelompok').val(data.id_kelompok).trigger('change');
			$('#id_nelayan').val(data.id_nelayan).trigger('change');
		
		}
				
                $( '#btn-save' ).html('<i class="fa fa-floppy-o"></i> Update');
				$('#inputan').removeClass('sembunyi');
				$('#isi-datane').addClass('sembunyi');
                $( '#nama' ).focus();
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                $( '.loading' ).fadeOut( 'fast' );
                swal( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
            }
        } );
    }
	
	$('#hak_akses').change(function(){
		var hak = $(this).val();
		if(hak < 3 ){
			$('#id_kelompok').attr('disabled','disabled');
			$('#id_nelayan').attr('disabled','disabled');
			$('#id_nelayan').prop('required',false);
			$('#id_kelompok').prop('required',false);
				$('#id_kelompok').val("").trigger('change');
			$('#id_nelayan').val("").trigger('change');
		}else if(hak == 3){
			$('#id_kelompok').removeAttr('disabled');
			$('#id_kelompok').prop('required',true);
			$('#id_nelayan').attr('disabled','disabled');
			$('#id_nelayan').val("").trigger('change');
			$('#id_nelayan').prop('required',false);
			
		
		}else{
			$('#id_kelompok').removeAttr('disabled');
			$('#id_nelayan').removeAttr('disabled');
			$('#id_nelayan').prop('required',true);
			$('#id_kelompok').prop('required',true);
		
		}
	});
	
	
	$(document).ready(function(){
		var hak ="<?php echo $hak?>";
		var id = "<?php echo $id_kelompok?>";
		if(hak > 2){
			     $.ajax( {
            url: "<?php echo site_url('user_management/get_nelayan')?>",
            type: "POST",
            data: {
                q: id
            },
            dataType: "JSON",
            success: function ( data ) {
                $( '.loading' ).fadeOut( 'fast' );
				var select = $('#id_nelayan');
				select.empty();
	
				select.append('<option value=""></option>' ); 
        		$.each(data.isi, function(i,item) {
            		select.append( '<option value = \"'+ item.id_nelayan+ '\"> '+ item.nama_nelayan+ '</option>' ); 
        		});
				
				$('#id_nelayan').removeAttr('disabled');
				$('#id_nelayan').prop('required',true);
			
                $( '#id_nelayan' ).focus();
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                $( '.loading' ).fadeOut( 'fast' );
                swal( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
            }
        } );
		}
	});
	
	
	$('#id_kelompok').change(function(){
 		var id = $(this).val();
		var hak = $('#hak_akses').val();
		if(id!= null && hak >3){
			 $( '.loading' ).fadeIn( 'fast' );
        $.ajax( {
            url: "<?php echo site_url('user_management/get_nelayan')?>",
            type: "POST",
            data: {
                q: id
            },
            dataType: "JSON",
            success: function ( data ) {
                $( '.loading' ).fadeOut( 'fast' );
				var select = $('#id_nelayan');
				select.empty();
	
				select.append('<option value=""></option>' ); 
        		$.each(data.isi, function(i,item) {
            		select.append( '<option value = \"'+ item.id_nelayan+ '\"> '+ item.nama_nelayan+ '</option>' ); 
					
					
        		});
				
				$('#id_nelayan').removeAttr('disabled');
				$('#id_nelayan').prop('required',true);
			
                $( '#id_nelayan' ).focus();
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                $( '.loading' ).fadeOut( 'fast' );
                swal( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
            }
        } );
		}
	});
	
    function delete_data( x ) {
        Swal.fire( {
            title: "HAPUS AKUN!",
            text: "Anda yakin akan menghapus akun ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Hapus!',
            cancelButtonText: "No, Batalkan!",
        } ).then( ( result ) => {
            if ( result.value ) {
                $( '.loading' ).fadeIn( 'fast' );
                $.ajax( {
                    url: "<?php echo site_url('user_management/delete')?>",
                    type: "POST",
                    data: {
                        q: x
                    },
                    dataType: "JSON",
                    success: function ( data ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        if ( data.status ) {
                            Swal.fire( 'Berhasil...!', 'Data berhasil dihapus!', 'success' );
                            reload_table();
                        } else {
                            Swal.fire( 'Upss...!!', 'Data gagal dihapus!', 'error' );
                        }
                    },
                    error: function ( jqXHR, textStatus, errorThrown ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( "Upss...!", "Terjadi kesalahan jaringan pesan error : !" + errorThrown, "error" );
                    }
                } );
            }
        } );
    }
    $( function () {
        $( '#form-add' ).submit( function ( evt ) {
            $( '.loading' ).fadeIn( 'fast' );
            evt.preventDefault();
            evt.stopImmediatePropagation();
            var url = $( this ).attr( 'action' );
            var formData = new FormData( $( this )[ 0 ] );
            $.ajax( {
                url: url,
                type: "POST",
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false,
                success: function ( data ) {
                    if ( data.status ) //if success close modal and reload ajax table
                    {
                        $( '.loading' ).fadeOut( 'fast' );
                        reload_page_upload();
                    } else {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( "Upss... !", data.pesan, "error" );
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    $( '.loading' ).fadeOut( 'fast' );
                    Swal.fire( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
                }
            } );
        } );
    } );
    function reload_page_upload() {
        Swal.fire( {
            title: "BERHASIL",
            text: "Akun berhasi ditambahkan",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: "No, Batalkan!",
        } ).then( ( result ) => {
            if ( result.value ) {
                reload_table();
                reset_form();
                $( '#nama' ).focus();
            }
        } );
    }
    
    $('#no_hp').keyup(function(){
        var d = $(this).val();
        if(d.length == "1"){
            if(d == "0"){
               $(this).val(""); 
            }
        }
    });
</script>