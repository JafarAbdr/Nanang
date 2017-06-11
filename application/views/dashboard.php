<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $dataLayout['title'];?> - Dashboard</title>

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
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/libs/morris/morris.core.css?1420463396" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/libs/toastr/toastr.css?1425466569" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/libs/select2/select2.css?1424887856" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/libs/typeahead/typeahead.css?1424887863" />
		<link type="text/css" rel="stylesheet" href="<?php echo $baseUrl;?>/source/assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1423393666" />
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo $baseUrl;?>/source/assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="<?php echo $baseUrl;?>/source/assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed ">

		<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
					<ul class="header-nav header-nav-options">
						<li class="header-nav-brand" >
							<div class="brand-holder">
								<a href="<?php echo $baseUrl;?>/source/html/dashboards/dashboard.html">
									<span class="text-lg text-bold text-primary"><?php echo $dataLayout['head'];?></span>
								</a>
							</div>
						</li>
						<li>
							<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
								<i class="fa fa-bars"></i>
							</a>
						</li>
					</ul>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="headerbar-right">
					<ul class="header-nav header-nav-options">
						<!-- Search form 
						<li>
							<form class="navbar-search" role="search">
								<div class="form-group">
									<input type="text" class="form-control" name="headerSearch" placeholder="Enter your keyword">
								</div>
								<button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
							</form>
						</li>-->
					</ul><!--end .header-nav-options -->
					<ul class="header-nav header-nav-profile">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
								<img src="<?php echo $baseUrl;?>/source/assets/img/avatar1.jpg?1403934956" alt="" />
								<span class="profile-info">
									<span id="namaOnTitle"><?php echo $dataContent->getNama();?></span>
									<small><?php echo $dataLayout['title'];?></small>
								</span>
							</a>
							<ul class="dropdown-menu animation-dock">
								<li class="dropdown-header">Config</li>
								<li><a id="myProfile">Info data diri</a></li>
								<li class="divider"></li>
								<li><a data-toggle="modal" data-target="#logOutModal" style="cursor : pointer;" id="tryLogOut"><i class="fa fa-fw fa-power-off text-danger"></i> Logout</a></li>
							</ul><!--end .dropdown-menu -->
						</li><!--end .dropdown -->
					</ul><!--end .header-nav-profile -->
					<!--end .header-nav-toggle -->
					<ul class="header-nav header-nav-toggle">
						<li>
							<a class="btn btn-icon-toggle btn-default" href="#offcanvas-search" data-toggle="offcanvas" data-backdrop="false">
								<i class="fa fa-ellipsis-v"></i>
							</a>
						</li>
					</ul>
				</div><!--end #header-navbar-collapse -->
			</div>
		</header>
		<!-- END HEADER-->

		<!-- BEGIN BASE-->
		<div id="base">

			<!-- BEGIN OFFCANVAS LEFT -->
			<div class="offcanvas">
			</div><!--end .offcanvas-->
			<!-- END OFFCANVAS LEFT -->

			<!-- BEGIN CONTENT-->
			<div id="content">
				<section id="other-layout" style="display : none;">
					
				</section>
				<section id="dashboard-layout">
					
					<div class="section-header">
						<ol class="breadcrumb">
							<li class="active">All Planning</li>
						</ol>
					</div>
					<div class="section-body">
						<div class="card">
							<div class="card-head style-primary">
								<div class="tools pull-left" id="add-search-world">
									
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="panel-group" id="accordion1">
											<div class="card panel">
												<div id="all-plan-world" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-1">
													<header>All Plan</header>
													<div class="tools">
														<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
													</div>
												</div>
												<div id="accordion1-1" class="collapse">
													<div class="card-body" id="all-plan-world-body">
													
													</div>
												</div>
											</div>
											<div class="card panel">
												<div id="list-of-plan-world" style="cursor : pointer;" class="card-head" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-2">
													<header>List of Plan</header>
													<div class="tools">
														<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
													</div>
												</div>
												<div id="accordion1-2" class="collapse">
													<div class="card-body"  id="list-of-plan-world-body" ><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
														<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
													</div>
												</div>
											</div>
											<div class="card panel">
												<div id="doing-of-plan-world" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-3">
													<header>Doing of Plan </header>
													<div class="tools">
														<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
													</div>
												</div>
												<div id="accordion1-3" class="collapse">
													<div class="card-body" id="doing-of-plan-world-body" ><p>Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Dicant vituperata consequuntur.</p>
													</div>
												</div>
											</div>
											<div class="card panel">
												<div id="delay-of-plan-world" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-4">
													<header>Delay of Plan</header>
													<div class="tools">
														<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
													</div>
												</div>
												<div id="accordion1-4" class="collapse">
													<div class="card-body" id="delay-of-plan-world-body" ><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
														<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
													</div>
												</div>
											</div>
											<div class="card panel">
												<div id="dissmis-of-plan-world" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-5">
													<header>Dissmis of Plan</header>
													<div class="tools">
														<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
													</div>
												</div>
												<div id="accordion1-5" class="collapse">
													<div class="card-body" id="dissmis-of-plan-world-body" ><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
														<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
													</div>
												</div>
											</div>
											<div class="card panel">
												<div id="finish-of-plan-world" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-6">
													<header>Finish of Plan</header>
													<div class="tools">
														<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
													</div>
												</div>
												<div id="accordion1-6" class="collapse">
													<div class="card-body"  id="finish-of-plan-world-body"><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
														<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
					
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->

			<!-- BEGIN MENUBAR-->
			<div id="menubar" class="menubar-inverse ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="<?php echo $baseUrl;?>/source/html/dashboards/dashboard.html">
							<span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">

					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls">

						<!-- BEGIN DASHBOARD -->
						<li>
							<a style="cursor : pointer;" id="dashboard" class="active">
								<div class="gui-icon"><i class="md md-home"></i></div>
								<span class="title">Dashboard</span>
							</a>
						</li><!--end /menu-li -->
						<!-- END DASHBOARD -->
						<?php if($levelCode != 4) {?>
						<!-- BEGIN EMAIL -->
						<li class="gui-folder">
							<a>
								<div class="gui-icon"><i class="md md-people-outline "></i></div>
								<span class="title">Anggota</span>
							</a>
							<!--start submenu -->
							<ul>
								<li><a style="cursor : pointer;" id="akun"><span class="title">Akun</span></a></li>
								<li><a style="cursor : pointer;" id="even"><span class="title">Even</span></a></li>
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
						<?php }else{?>
						<li>
							<a id="akun"  style="cursor : pointer;" >
								<div class="gui-icon"><i class="md md-people-outline "></i></div>
								<span class="title">Akun</span>
							</a>
							<!--start submenu -->
						</li><!--end /menu-li -->
						<?php }?>
						<!-- END EMAIL -->
					</ul><!--end .main-menu -->
					<!-- END MAIN MENU -->

					<div class="menubar-foot-panel">
						<small class="no-linebreak hidden-folded">
							<span class="opacity-75">Copyright &copy; <?php echo date('Y');?></span> <strong> JaservTech</strong>
						</small>
					</div>
				</div><!--end .menubar-scroll-panel-->
			</div><!--end #menubar-->
			<!-- END MENUBAR -->

			<!-- BEGIN OFFCANVAS RIGHT -->
			<div class="offcanvas">

				<!-- BEGIN OFFCANVAS SEARCH -->
				<div id="offcanvas-search" class="offcanvas-pane width-8">
					<div class="offcanvas-head">
						<header class="text-primary">Search</header>
						<div class="offcanvas-tools">
							<a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
								<i class="md md-close"></i>
							</a>
						</div>
					</div>
					<div class="offcanvas-body no-padding">
						<ul class="list ">
							<li class="tile divider-full-bleed">
								<div class="tile-content">
									<div class="tile-text"><strong>A</strong></div>
								</div>
							</li>
							<li class="tile">
								<a class="tile-content ink-reaction" href="#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
									<div class="tile-icon">
										<img src="<?php echo $baseUrl;?>/source/assets/img/avatar4.jpg?1404026791" alt="" />
									</div>
									<div class="tile-text">
										Alex Nelson
										<small>123-123-3210</small>
									</div>
								</a>
							</li>
							<li class="tile">
								<a class="tile-content ink-reaction" href="#offcanvas-chat" data-toggle="offcanvas" data-backdrop="false">
									<div class="tile-icon">
										<img src="<?php echo $baseUrl;?>/source/assets/img/avatar9.jpg?1404026744" alt="" />
									</div>
									<div class="tile-text">
										Ann Laurens
										<small>123-123-3210</small>
									</div>
								</a>
							</li>
						</ul>
					</div><!--end .offcanvas-body -->
				</div><!--end .offcanvas-pane -->
				<!-- END OFFCANVAS SEARCH -->

				<!-- BEGIN OFFCANVAS CHAT -->
				<div id="offcanvas-chat" class="offcanvas-pane style-default-light width-12">
					<div class="offcanvas-head style-default-bright">
						<header class="text-primary">Chat with Ann Laurens</header>
						<div class="offcanvas-tools">
							<a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
								<i class="md md-close"></i>
							</a>
							<a class="btn btn-icon-toggle btn-default-light pull-right" href="#offcanvas-search" data-toggle="offcanvas" data-backdrop="false">
								<i class="md md-arrow-back"></i>
							</a>
						</div>
						<form class="form">
							<div class="form-group floating-label">
								<textarea name="sidebarChatMessage" id="sidebarChatMessage" class="form-control autosize" rows="1"></textarea>
								<label for="sidebarChatMessage">Leave a message</label>
							</div>
						</form>
					</div>
					<div class="offcanvas-body">
						<ul class="list-chats">
							<li>
								<div class="chat">
									<div class="chat-avatar"><img class="img-circle" src="<?php echo $baseUrl;?>/source/assets/img/avatar1.jpg?1403934956" alt="" /></div>
									<div class="chat-body">
										Yes, it is indeed very beautiful.
										<small>10:03 pm</small>
									</div>
								</div><!--end .chat -->
							</li>
							<li class="chat-left">
								<div class="chat">
									<div class="chat-avatar"><img class="img-circle" src="<?php echo $baseUrl;?>/source/assets/img/avatar9.jpg?1404026744" alt="" /></div>
									<div class="chat-body">
										Did you see the changes?
										<small>10:02 pm</small>
									</div>
								</div><!--end .chat -->
							</li>
							<li>
								<div class="chat">
									<div class="chat-avatar"><img class="img-circle" src="<?php echo $baseUrl;?>/source/assets/img/avatar1.jpg?1403934956" alt="" /></div>
									<div class="chat-body">
										Are the colors of the logo already adapted?
										<small>Last week</small>
									</div>
								</div><!--end .chat -->
							</li>
						</ul>
					</div><!--end .offcanvas-body -->
				</div><!--end .offcanvas-pane -->
				<!-- END OFFCANVAS CHAT -->

			</div><!--end .offcanvas-->
			<!-- END OFFCANVAS RIGHT -->

		</div><!--end #base-->
		<!-- END BASE -->
		<!--BEGIN MESSAGE SUPPORT-->
		<!-- BEGIN SIMPLE MODAL MARKUP -->
<div class="modal fade" id="listModal" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="listModalLabel">Menambahkan</h4>
			</div>
			<div class="card">
				<div class="card-body no-padding">
					<ul class="list divider-full-bleed" id="listModalCard">
						<li class="tile"  style="cursor:pointer" >
							<a class="tile-content ink-reaction">
								<div style="padding-top : 0px;"  class="tile-icon">
									<i class="md md-school"></i>
								</div>
								<div class="tile-text">
									Sekolah
								</div>
							</a>
						</li>
						<li class="tile"  style="cursor:pointer" >
							<a class="tile-content ink-reaction">
								<div style="padding-top : 0px;"  class="tile-icon">
									<i class="md md-people"></i>
								</div>
								<div class="tile-text">
									Guru
								</div>
							</a>
						</li>
						<li class="tile"  style="cursor:pointer" >
							<a class="tile-content ink-reaction">
								<div  style="padding-top : 0px;" class="tile-icon">
									<i class="md md-person"></i>
								</div>
								<div class="tile-text">
									Wali
								</div>
							</a>
						</li>
						<li class="tile"  style="cursor:pointer"  data-dismiss="modal" aria-hidden="true">
							<a class="tile-content ink-reaction">
								<div style="padding-top : 0px;"  class="tile-icon">
									<i class="md md-cancel"></i>
								</div>
								<div class="tile-text">
									Batalkan
								</div>
							</a>
						</li>
					</ul>
				</div><!--end .card-body -->
			</div><!--end .card -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END SIMPLE MODAL MARKUP -->
		<!-- BEGIN SIMPLE MODAL MARKUP -->
<div class="modal fade" id="logOutModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Save changes</h4>
			</div>
			<div class="modal-body">
				<p>Anda yakin ingin keluar ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
				<button type="button" class="btn btn-primary" onclick="window.location = 'logout'">Ya, tentu</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END SIMPLE MODAL MARKUP -->
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="formModal" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
				<h4 class="modal-title" id="formModalLabel">Info data diri</h4>
			</div>
			<form class="form-horizontal" role="form" id="formModalAction" enctype="multipart/form-data" >
				<div class="modal-body"  id="formModalBody">
					<div class="form-group">
						<div class="col-sm-3">
							<label for="email1" class="control-label">Email</label>
						</div>
						<div class="col-sm-9">
							<input type="email" name="email1" id="email1" class="form-control" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="password1" class="control-label">Password</label>
						</div>
						<div class="col-sm-9">
							<input type="password" name="password1" id="password1" class="form-control" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
						</div>
						<div class="col-sm-9">
							<div class="checkbox">
								<label>
									<input type="checkbox" id="cb1"> Remember me
								</label>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="formModalButtonNo" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary" id="formModalButtonYes">Perbaharui</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="formFlush" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-body"  id="formFlushBody">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->
		<!--END MESSAGE SUPPORT-->
		<!-- BEGIN JAVASCRIPT -->
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/spin.js/spin.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/moment/moment.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/flot/jquery.flot.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/flot/jquery.flot.time.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/flot/jquery.flot.resize.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/flot/jquery.flot.orderBars.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/flot/jquery.flot.pie.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/flot/curvedLines.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/jquery-knob/jquery.knob.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/sparkline/jquery.sparkline.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/d3/d3.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/d3/d3.v3.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/rickshaw/rickshaw.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/toastr/toastr.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/libs/select2/select2.min.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/App.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppNavigation.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppOffcanvas.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppCard.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppForm.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppNavSearch.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/source/AppVendor.js"></script>
		<script src="<?php echo $baseUrl;?>/source/assets/js/core/demo/Demo.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/jaservajax.powerfull.dev.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/global_modal.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/global_form.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/global_message.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/global_card.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/global_nav_search.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/next_pre_control.js"></script>
		<script src="<?php echo $baseUrl;?>/source/myStyle/library/js/MainLayout.js"></script>
		
		<?php 
		
		switch($levelCode){
			case 1 :
				echo '	<script src="'.$baseUrl.'/source/myStyle/js/Home.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/Akun.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/AkunAdd.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/Dashboard.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/Even.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/EvenAdd.js"></script>
						<script>
							var kodeJREWOKJSKSJAKSJKJSKAJSSAJK = 1;
						</script>
						';
			break;
			case 2 :
				echo '	<script src="'.$baseUrl.'/source/myStyle/js/HomeS.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/AkunS.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/EvenS.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/AkunAddS.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/EvenAddS.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/DashboardS.js"></script>
						<script>
							var kodeJREWOKJSKSJAKSJKJSKAJSSAJK = 2;
						</script>';
			break;
			case 3 :
				echo '	<script src="'.$baseUrl.'/source/myStyle/js/HomeG.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/AkunG.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/EvenG.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/DashboardG.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/AkunAddG.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/EvenAddG.js"></script>
						<script>
							var kodeJREWOKJSKSJAKSJKJSKAJSSAJK = 3;
						</script>';
			break;
			case 4 :
				echo '	<script src="'.$baseUrl.'/source/myStyle/js/HomeW.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/AkunW.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/AkunAddW.js"></script>
						<script src="'.$baseUrl.'/source/myStyle/js/DashboardW.js"></script>
						<script>
							var kodeJREWOKJSKSJAKSJKJSKAJSSAJK = 4;
						</script>';
			break;
		}
		?>
		<!-- END JAVASCRIPT -->

	</body>
</html>
