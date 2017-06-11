<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Creative Scheduler - Masuk</title>
		
		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->
		<script>
			prefixUrl = "<?php echo str_ireplace("http://localhost/","",$baseUrl);?>";
			//prefixUrl = "<?php echo str_ireplace("https://linktotalk.000webhostapp.com/","",$baseUrl);?>";
		</script>
		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/libs/toastr/toastr.css?1425466569" />
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed ">

		<!-- BEGIN LOGIN SECTION -->
		<section class="section-account">
			<div class="img-backdrop" style="background-image: url('<?php echo $baseUrl;?>/source/assets/img/img17.jpg')"></div>
			<div class="spacer"></div>
			<div class="card contain-sm style-transparent">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6" style="margin-left : auto; margin-right : auto; float : none;">
							<br/>
							<span class="text-lg text-bold text-primary">MASUK</span>
							<br/><br/>
							<form class="form floating-label" action="" accept-charset="utf-8" method="post">
								<div class="form-group">
									<input type="text" class="form-control" id="username" name="username">
									<label for="username">Kode pengguna</label>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" name="password">
									<label for="password">Kata kunci</label>
									<!--<p class="help-block"><a href="#">Forgotten?</a></p>-->
								</div>
								<br/>
								<div class="row">
									<div class="col-xs-6 text-left">
										<div class="checkbox checkbox-inline checkbox-styled">
											<label>
												<input id="stayIn" type="checkbox"> <span>tetap masuk</span>
											</label>
										</div>
									</div><!--end .col -->
									<div class="col-xs-6 text-right">
										<input id="tryLogin" type="button" class="btn btn-primary btn-raised" value="Masuk">
										<!--<button class="btn btn-primary btn-raised" type="submit">Login</button>-->
									</div><!--end .col -->
								</div><!--end .row -->
							</form>
						</div><!--end .col -->
					</div><!--end .card -->
				</section>
				<!-- END LOGIN SECTION -->

				<!-- BEGIN JAVASCRIPT -->
				<script src="<?php echo $baseUrl;?>/source/assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/libs/bootstrap/bootstrap.min.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/libs/spin.js/spin.min.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/libs/autosize/jquery.autosize.min.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/libs/toastr/toastr.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/App.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppNavigation.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppOffcanvas.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppCard.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppForm.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppNavSearch.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppVendor.js"></script>
				<script src="<?php echo $baseUrl;?>/source/assets/js/core/demo/Demo.js"></script>
				<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/global_message.js"></script>
				<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/jaservajax.powerfull.dev.js"></script>
				<script src="<?php echo $baseUrl;?>/source/myStyle/js/Login.js"></script>
				<!-- END JAVASCRIPT -->

			</body>
		</html>
