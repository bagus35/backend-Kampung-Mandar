<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> <?php echo $title;?> </title>
<link rel="icon" href="<?php echo base_url();?>aset/img/ic_logo.png">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/swal_2/dist/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/boot_select2/dist/css/select2.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/boot_select2/dist/select2-bootstrap4.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/main.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/background.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/background.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/loading.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/login.css">
<!-- Font-icon css-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/font/font-awesome/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@200;300;400;500;600;700&family=Barlow+Condensed:ital,wght@0,100;0,200;0,500;1,100;1,200;1,300;1,500&family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">
<!-- Essential javascripts for application to work--> 
<script src="<?php echo base_url();?>aset/js/jquery.js"></script> 
<script src="<?php echo base_url();?>aset/js/popper.min.js"></script> 
<script src="<?php echo base_url();?>aset/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/boot_select2/dist/js/select2.full.js"></script> 
<script src="<?php echo base_url();?>aset/js/plugins/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url();?>aset/js/plugins/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>aset/js/jquery.mask.min.js"></script> 
<script src="<?php echo base_url();?>aset/js/numeric.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/swal_2/dist/sweetalert2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>aset/js/plugins/moment.min.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/tinymce/tinymce.min.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/tinymce/jquery.tinymce.min.js"></script> 
<script type="text/javascript">
		$( function () {
			$( '.boot-select' ).select2( {
				theme: "bootstrap4",
			} );
			$( '.boot-select' ).val( '' ).trigger( 'change' );
			$( '.boot-select-multi' ).select2( {
				theme: 'bootstrap4',
				multiple: true,
			} );
			$( '.boot-select-se' ).select2( {
				theme: "bootstrap4",
				minimumResultsForSearch: -1
			} );
			$( '.boot-select-2' ).select2( {
				theme: "bootstrap4",
				minimumResultsForSearch: -1
			} );
			$( '.boot-select-2' ).val( '' ).trigger( 'change' );
			$( '.boot-select-multi' ).val( '' ).trigger( 'change' );
			$( '.boot-select-multi' ).on( 'select2:opening select2:closing', function ( event ) {
				var $searchfield = $( this ).parent().find( '.select2-search__field' );
				$searchfield.prop( 'disabled', false );
			} );
		} );
		const Toast = Swal.mixin( {
			toast: true,
			position: 'center',
			showConfirmButton: false,
			timer: 500
		} );
		function tglfromsql( tgl ) {
			var t = tgl.split( '-' );
			var d = t[ 2 ];
			var m = t[ 1 ];
			var y = t[ 0 ];
			var tanggal = d + '/' + m + '/' + y;
			return tanggal;
		}
	</script>
</head>
<body class="app sidebar-mini" >
<div class="loading">
  <div class="cssload-container">
    <div class="cssload-zenith"></div>
  </div>
</div>
<div class="loading-1">
  <div class="cssload-container">
    <div class="cssload-zenith"></div>
  </div>
  <p class="saving text-merah">Sedang mengirim email. Silahkan tunggu! <span>.</span><span>.</span><span>.</span> </p>
</div>
<section class="login-content">
  <div class="login-box">
    <div class="logo-login"> <img src="<?= base_url()?>aset/img/ic_splash.png"> </div>
    <div class="isi-login-box">
      <form class="login-form" method="post" id="form-login" action="<?php echo base_url();?>login/validasi" class="was-validated">
      <h3 class="login-head">Please Login</h3>
      <div class="form-group">
        <label class="control-label">Username</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" id="username" required autofocus>
          <div class="valid-feedback"><i>*valid</i> </div>
          <div class="invalid-feedback"><i>*required</i> </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label">Password</label>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" required>
          <div class="valid-feedback"><i>*valid</i> </div>
          <div class="invalid-feedback"><i>*required</i> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-check">
            <label class="form-check-label">
              <input id="show-password" type="checkbox" class="form-check-input" value="">
              <i>Show Password</i> </label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Lupa Password ?</a> </p>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group btn-container">
        <button class="btn btn-danger btn-block">Sign In</button>
      </div>
      </form>
      <form id="form-email" method="post" class="forget-form was-validated" action="<?php echo base_url('login/send_email');?>">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Lupa Password ?</h3>
        <div class="form-group">
          <label class="control-label">EMAIL</label>
          <input class="form-control form-control" type="text" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
          <div class="valid-feedback"><i>*valid</i> </div>
          <div class="invalid-feedback"><i>*email kosong/format email salah</i> </div>
        </div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-info btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>KIRIM EMAIL</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a> </p>
        </div>
      </form>
    </div>
  </div>
</section>
<script src="<?php echo base_url();?>aset/js/main.js"></script> 
<script src="<?php echo base_url();?>aset/js/plugins/pace.min.js"></script> 
<script type="text/javascript">
		$( '.login-content [data-toggle="flip"]' ).click( function () {
			$( '.login-box' ).toggleClass( 'flipped' );
			return false;
		} );
		$( function () {
			$( '#form-login' ).submit( function ( evt ) {
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
						$( '.loading' ).fadeOut( 'fast' );
						if ( data.status ) {
							window.location.href = "<?php echo base_url();?>home";
						} else {
							Swal.fire( "LOGIN GAGAL !", "Username atau password yang anda masukkan salah. Mohon isi password/username dengan benar!", "error" );
							$( '#username' ).focus();
						}
					},
					error: function ( jqXHR, textStatus, errorThrown ) {
                        $( '.loading' ).fadeOut( 'fast' );
                        Swal.fire( "Upss...!", "Terjadi kesalahan jaringan pesan error : !" + errorThrown, "error" );
                    }
				} );
			} );
		} );
		$( function () {
			$( '#form-email' ).submit( function ( evt ) {
				$( '.loading-1' ).fadeIn( 'fast' );
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
						if ( data.status ) {
							$( '.loading-1' ).fadeOut( 'fast' );
							Swal.fire( "KIRIM EMAIL SUKSES!", "Kami telah mengirim verifikasi login melalui email anda. Mohon untuk tidak menujukkan verifikasi tersebut kepada pihak manapun!", "success" );
							$( '#form-email' )[ 0 ].reset();
							$( '#email' ).focus();
						} else {
							$( '.loading-1' ).fadeOut( 'fast' );
							Swal.fire( "PENGIRIMAN EMAIL GAGAL !", "Email yang anda masukkan tidak terdaftar di sistem kami. Mohon masukkan email yang terdaftar di sistem kami!", "error" );
							$( '#email' ).focus();
						}
					},
					error: function ( jqXHR, textStatus, errorThrown ) {
						$( '.loading' ).fadeOut( 'fast' );
						Swal.fire( 'Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown, 'error' );
					}
				} );
			} );
		} );
	
	
	$(document).ready(function() {
    $("#show-password").on('click', function() {
		if ($(this).is(":checked")){
		$('#password').attr('type', 'text');
		}else{
			$('#password').attr('type', 'password');
		}
		
		
//        event.preventDefault();
//        if($('#password').attr("type") == "text"){
//            $('#show_hide_password input').attr('type', 'password');
//            $('#show_hide_password i').addClass( "fa-eye-slash" );
//            $('#show_hide_password i').removeClass( "fa-eye" );
//        }else if($('#show_hide_password input').attr("type") == "password"){
//            $('#show_hide_password input').attr('type', 'text');
//            $('#show_hide_password i').removeClass( "fa-eye-slash" );
//            $('#show_hide_password i').addClass( "fa-eye" );
//        }
  });
});
	</script>
</body>
</html>