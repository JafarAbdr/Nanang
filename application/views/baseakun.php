<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="section-header">
	<ol class="breadcrumb">
		<li class="active">Member Kontrols</li>
	</ol>
</div>
<div class="section-body">
	<div class="card">

		<!-- BEGIN SEARCH HEADER -->
		<div class="card-head style-primary">
			<div class="tools pull-left">
				<form class="navbar-search" role="search">
					<div class="form-group">
						<input id="search-member" type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword">
					</div>
					<button id="search-member-button" type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
				</form>
			</div>
			<?php
			if($kode == 1){
			?>
			<div class="tools pull-left">
				<form class="form" style="margin : 0;">
					<div style="margin : 8.75px;">
						<select style=""  class="form-control select2-list" id="sch-id-list-member" data-placeholder="">
						<option value="ALL">All - Semua Sekolah</option>
						<?php
							if($school){
								while($school->getNextCursor()){
									$schId = $school->getIdentified();
									echo '<option value="SCH'.substr($schId,10,10)."".substr($schId,0,10)."".substr($schId,20,6).'">'.$school->getNama().'</option>';
								}
							}
						?>
					</select>
					</div>
				</form>
			</div>
			<?php
			}
			
			
			if($kode != 4){
			?>
			
			<div class="tools">
				<a class="btn btn-floating-action btn-default-light" id="add_member" style="cursor : pointer"><i class="fa fa-plus"></i></a>
				<!--<a class="btn btn-flat hidden-xs" id="back_to_the_list"><span class="glyphicon glyphicon-arrow-left"></span> &nbsp;Back to search results&nbsp;</a>-->
			</div>
			<?php } ?>
		</div><!--end .card-head -->
		<!-- END SEARCH HEADER -->

		<!-- BEGIN SEARCH RESULTS -->
		<div class="card-body">
			<div class="row">

				<!-- BEGIN SEARCH NAV -->
				<div class="col-sm-4 col-md-3 col-lg-2">
					<ul class="nav nav-pills nav-stacked">
						<li><small>Kategori</small></li>
						<?php
						if($kode == 1 || $kode == 2){
							echo '<li kode="1" class="tag-action active"><a style="cursor : pointer;" id="exe-mem-all">Semua member <small id="inf-num-all" class="pull-right text-bold opacity-75">load ...</small></a></li>';
						} 
						if($kode == 1){
							echo '<li kode="2" class="tag-action"><a style="cursor : pointer;" id="exe-mem-hea">Kepala sekolah <small id="inf-num-hea" class="pull-right text-bold opacity-75">load ...</small></a></li>';
						}
						if($kode == 1 || $kode == 2){
							echo '<li kode="3" class="tag-action"><a style="cursor : pointer;" id="exe-mem-tea">Guru <small id="inf-num-tea" class="pull-right text-bold opacity-75">load ...</small></a></li>';
						}
						?>
						<li class="tag-action <?php if($kode == 3  || $kode == 4) echo "active"?>" kode="4"><a style="cursor : pointer;" id="exe-mem-par"><?php if($kode == 3 || $kode == 1 || $kode == 2) echo 'Wali'; if($kode==4) echo "Ruang"?> <small id="inf-num-par" class="pull-right text-bold opacity-75">load ...</small></a></li>
						<li class="hidden-xs"><small>LAST VIEWED</small></li>
						<!--<li class="hidden-xs">
							<a href="../../../html/pages/contacts/details.html">
								<img class="img-circle img-responsive pull-left width-1" src="../../../assets/img/avatar7.jpg?1404026721" alt="" />
								<span class="text-medium" >Philip Ericsson</span><br/>
								<span class="opacity-50">
									<span class="glyphicon glyphicon-phone text-sm"></span> &nbsp;123-123-3210
								</span>
							</a>
						</li>-->
					</ul>
				</div><!--end .col -->
				<!-- END SEARCH NAV -->

				<div class="col-sm-8 col-md-9 col-lg-10">

					<!-- BEGIN SEARCH RESULTS LIST
					<div class="margin-bottom-xxl">
						<span class="text-light text-lg">Filtered results <strong id="total-member-result">34</strong></span>
						<div class="btn-group btn-group-sm pull-right">
							<button type="button" class="btn btn-default-light dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-arrow-down"></span> Sort
							</button>
							<ul class="dropdown-menu dropdown-menu-right animation-dock" role="menu">
								<li><a href="#">First name</a></li>
								<li><a href="#">Last name</a></li>
								<li><a href="#">Email address</a></li>
							</ul>
						</div>
					</div><--end .margin-bottom-xxl -->
					<div class="list-results" id="list-of-view-member">
						<!--<div class="col-xs-12 col-lg-6 hbox-xs">
							<div class="hbox-column width-2">
								<img class="img-circle img-responsive pull-left" src="../../../assets/img/avatar9.jpg?1404026744" alt="" />
							</div><!--end .hbox-column 
							<div class="hbox-column v-top">
								<div class="clearfix">
									<div class="col-lg-12 margin-bottom-lg">
										<a class="text-lg text-medium" href="../../../html/pages/contacts/details.html">Ann Laurens</a>
									</div>
								</div>
								<div class="clearfix opacity-75">
									<div class="col-md-5">
										<span class="glyphicon glyphicon-phone text-sm"></span> &nbsp;567-890-1234
									</div>
									<div class="col-md-7">
										<span class="glyphicon glyphicon-envelope text-sm"></span> &nbsp;ann@laurens.com
									</div>
								</div>
								<div class="clearfix">
									<div class="col-lg-12">
										<span class="opacity-75"><span class="glyphicon glyphicon-map-marker text-sm"></span> &nbsp;795 Folsom Ave, San Francisco, CA 94107</span>
									</div>
								</div>
								<div class="stick-top-right small-padding">
									<i class="fa fa-dot-circle-o fa-fw text-success" data-toggle="tooltip" data-placement="left" data-original-title="User online"></i>
								</div>
							</div><!--end .hbox-column 
						</div>end .hbox-xs -->
					</div><!--end .list-results -->

					<!-- BEGIN SEARCH RESULTS LIST -->

					<!-- BEGIN SEARCH RESULTS PAGING -->
					<div class="text-center">
						<ul class="pagination" id="next-pre-member-content">
							<li style="display:none;" id="top-list-member" class="disabled"><a style="cursor : pointer;">«</a></li>
							<li id="previous-list-member" class='disabled'><a style="cursor : pointer;">««</a></li>
							<li id="next-list-member"><a style="cursor : pointer;">»»</a></li>
							<li style="display:none;" id="bottom-list-member"><a style="cursor : pointer;">»</a></li>
						</ul>
					</div><!--end .text-center -->

					<!-- BEGIN SEARCH RESULTS PAGING -->
				</div><!--end .col -->
			</div><!--end .row -->
		</div><!--end .card-body -->
		<!-- END SEARCH RESULTS -->

	</div><!--end .card -->
</div><!--end .section-body -->
