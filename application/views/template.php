<!DOCTYPE html>
<html lang="en">
<head>
<title> <?php echo strtoupper($title);?> </title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" href="<?php echo base_url();?>aset/img/ic_launcher.png">
<!-- Main CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/swal_2/dist/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/boot_select2/dist/css/select2.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/boot_select2/dist/select2-bootstrap4.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/main.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/image_cropper/dist/rcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/croppie/croppie.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/lightgallery/css/lightgallery.css">
<link rel="stylesheet" href="<?php echo base_url();?>aset/css/bootstrap-switch.css">
<link rel="stylesheet" href="<?php echo base_url();?>aset/plugins/spectrum-2.0.0/dist/spectrum.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/background.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/plugins/smooth-scrollbar-develop/smooth-scrollbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/loading.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/switch.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/css/icono.min.css">
<!-- Font-icon css-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/font/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>aset/font/fontawesome_free_6.2.0-web/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@200;300;400;500;600;700&family=Barlow+Condensed:ital,wght@0,100;0,200;0,500;1,100;1,200;1,300;1,500&family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">
<script src="<?php echo base_url();?>aset/js/jquery.js"></script> 
<script src="<?php echo base_url();?>aset/js/popper.min.js"></script> 
<script src="<?php echo base_url();?>aset/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/boot_select2/dist/js/select2.full.js"></script> 
<script src="<?php echo base_url();?>aset/js/bootstrap_switch.js"></script> 
<script src="<?php echo base_url();?>aset/js/plugins/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url();?>aset/js/plugins/dataTables.bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/boot_select2/dist/js/select2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>aset/js/jquery.mask.min.js"></script> 
<script src="<?php echo base_url();?>aset/js/numeric.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/swal_2/dist/sweetalert2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>aset/js/plugins/moment.min.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/spectrum-2.0.0/dist/spectrum.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/croppie/croppie.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/lightgallery/js/lightgallery.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/lightgallery/js/zoom.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/smooth-scrollbar-develop/smooth-scrollbar.js"></script> 
<script src="<?php echo base_url();?>aset/js/libku.js"></script> 
<script>
	$(document).ready(function() {
		$('.boot-select').select2({
			theme: "bootstrap4",
		});
		$('.boot-select').val('').trigger('change');
		$('.boot-select-no').select2({
			theme: "bootstrap4",
			minimumResultsForSearch: -1,
		
		});
		
		$(".boot-select-no").select2("val", "");
	});
</script>
</head>
<body class="app sidebar-mini rtl" >

<!-- Navbar-->
<header class="app-header"> <?php echo $header;?> </header>
<!-- Sidebar menu-->

<aside data-scrollbar class="app-sidebar"> <?php echo $sidebar;?> </aside>
<main  class="app-content"> <?php echo $content;?> </main>
<script src="<?php echo base_url();?>aset/js/main.js"></script> 
<script src="<?php echo base_url();?>aset/js/libku.js"></script> 
<script src="<?php echo base_url();?>aset/plugins/boot_select2/dist/js/select2.full.min.js"></script> 
<script type="text/javascript">
Scrollbar.initAll(); 
	function geser() {
		if($('.uji').length){
			$('.uji').wrap('<label class="switch"></label>');
			$('<span class="slider round"></span><span class="absolute-no"></span>').insertAfter(".uji");
			var off = $('.uji').data('off');
			var on = $('.uji').data('on');	
			$('.absolute-no').text(off);
				var wd;
			var pon = on.length;
			var poff = off.length;
			if(pon > poff){
				wd = pon;
			}else{
				wd = poff;
			}
			wd = (wd * 8) + 45;
			$('.switch').css('width', +wd + 'px');
			var mn = wd - 30;
			var st = '<style type="text/css">';
			st += ' .slider:after {position: absolute;left: 0;z-index: 1;';
			st += 'content:" ' + on + '";';
			st += 'font-family: "Oswald", sans-serif;font-weight: 400;letter-spacing: 2px;font-size: 14px;text-transform: uppercase;text-align: left !important;line-height: 28px;padding-left: 10px;width: 100%;color: #fff;height: 30px;border-radius: 100px;background: rgb(57, 161, 2);background: linear-gradient(43deg, rgba(57, 161, 2, 1) 0%, rgba(68, 184, 7, 1) 35%, rgba(120, 180, 28, 1) 61%, rgba(146, 240, 4, 1) 100%);';
			st += '-webkit-transform: translateX(-' + mn + 'px);-ms-transform: translateX(-' + mn + 'px);transform: translateX(-' + mn + 'px);transition: all 0.4s ease-in-out;}';
			st += 'input:checked + .slider:before {-webkit-transform: translateX(' + mn + 'px);-ms-transform: translateX(' + mn + 'px);transform: translateX(' + mn + 'px);}';
			st += '</style>';
			$('head').append(st);
		}
};
</script> 
</script> 
<?php echo $loading;?>
</body>
</html>