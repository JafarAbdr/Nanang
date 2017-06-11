<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="section-header">
	<ol class="breadcrumb">
		<li class="active">Perencanaan Kontrols</li>
	</ol>
</div>
<div class="section-body">
	<div class="card">

		<!-- BEGIN SEARCH HEADER -->
		<div class="card-head style-primary">
			<div class="tools pull-left">
				<form class="navbar-search" role="search">
					<div class="form-group">
						<input id="search-even" type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword">
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
						<select style="width : 150px;" onchange="
						if(this.value == 'OTH'){
							$('#sub-event-s').removeAttr('disabled');
							$('#teach-id-list-member').removeAttr('disabled');
							$('#teach-id-list-member').trigger('change');
							EvenVariabelGlobal['idSekolah'] = $('#sub-event-s').val(); 
						}else{
							$('#sub-event-s').attr('disabled','true');
							$('#teach-id-list-member').attr('disabled','true');
							EvenVariabelGlobal['idActive'] = this.value; 
							EvenControl.refreshContent();
						}
						" class="form-control select2-list" id="main-event" data-placeholder="">
							<option value="OWN<?php echo substr($identified,10,10)."".substr($identified,0,10)."".substr($identified,20,6);?>">Anda</option>
							<option value="OTH">other</option>
						</select>
					</div>
				</form>
			</div>
			<div class="tools pull-left">
				<form class="form" style="margin : 0;">
					<div style="margin : 8.75px;">
						<select style="" disabled onchange="EvenVariabelGlobal['idSekolah'] = this.value; EvenControl.refreshSubEvent();" class="form-control select2-list" id="sub-event-s" data-placeholder="">
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
			?>
			<?php
			if($kode == 2 || $kode == 1){
			?>
			<div class="tools pull-left">
				<form class="form" style="margin : 0;">
					<div style="margin : 8.75px;">
						<select style="width : 200px;" disabled onchange="EvenVariabelGlobal['idActive'] = this.value; EvenControl.refreshContent();" class="form-control select2-list" id="teach-id-list-member" data-placeholder="">
						<?php
							if($kode == 1){
								echo '<option value> Pilih Guru </option>';
							}
							if($data){
								while($data->getNextCursor()){
									$guruId = $data->getIdentified();
									echo '<option value="TEACH'.substr($guruId,10,10)."".substr($guruId,0,10)."".substr($guruId,20,6).'">'.$data->getNama().'</option>';
								}
							}
						?>
					</select>
					</div>
				</form>
			</div>
			<?php
			}
			?>
			<div class="tools">
				<a class="btn btn-floating-action btn-default-light" id="add_even" style="cursor : pointer"><i class="fa fa-plus"></i></a>
			</div>
		</div><!--end .card-head -->
		<!-- END SEARCH HEADER -->

		<!-- BEGIN SEARCH RESULTS -->
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion1">
						<div class="card panel">
							<div id="all-plan" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-1">
								<header>All Plan</header>
								<div class="tools">
									<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
							<div id="accordion1-1" class="collapse">
								<div class="card-body" id="all-plan-body">
								
								</div>
							</div>
						</div><!--end .panel -->
						<div class="card panel">
							<div id="list-of-plan" style="cursor : pointer;" class="card-head" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-2">
								<header>List of Plan</header>
								<div class="tools">
									<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
							<div id="accordion1-2" class="collapse">
								<div class="card-body"  id="list-of-plan-body" ><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
									<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
								</div>
							</div>
						</div><!--end .panel -->
						<div class="card panel">
							<div id="doing-of-plan" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-3">
								<header>Doing of Plan </header>
								<div class="tools">
									<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
							<div id="accordion1-3" class="collapse">
								<div class="card-body" id="doing-of-plan-body" ><p>Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Dicant vituperata consequuntur.</p>
								</div>
							</div>
						</div><!--end .panel -->
						<div class="card panel">
							<div id="delay-of-plan" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-4">
								<header>Delay of Plan</header>
								<div class="tools">
									<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
							<div id="accordion1-4" class="collapse">
								<div class="card-body" id="delay-of-plan-body" ><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
									<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
								</div>
							</div>
						</div><!--end .panel -->
						<div class="card panel">
							<div id="dissmis-of-plan" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-5">
								<header>Dissmis of Plan</header>
								<div class="tools">
									<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
							<div id="accordion1-5" class="collapse">
								<div class="card-body" id="dissmis-of-plan-body" ><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
									<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
								</div>
							</div>
						</div><!--end .panel -->
						<div class="card panel">
							<div id="finish-of-plan" style="cursor : pointer;" class="card-head collapsed" data-toggle="collapse" data-parent="#accordion1" data-target="#accordion1-6">
								<header>Finish of Plan</header>
								<div class="tools">
									<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
							<div id="accordion1-6" class="collapse">
								<div class="card-body"  id="finish-of-plan-body"><p>Duo semper accumsan ea, quidam convenire cum cu, oportere maiestatis incorrupte est eu. Soluta audiam timeam ius te, idque gubergren forensibus ad mel, persius urbanitas usu id. Civibus nostrum fabellas mea te, ne pri lucilius iudicabit. Ut cibo semper vituperatoribus vix, cum in error elitr. Vix molestiae intellegat omittantur an, nam cu modo ullum scriptorem.</p>
									<p>Quod option numquam vel in, et fuisset delicatissimi duo, qui ut animal noluisse erroribus. Ea eum veniam audire. Per at postea mediocritatem, vim numquam aliquid eu, in nam sale gubergren. Dicant vituperata consequuntur at sea, mazim commodo</p>
								</div>
							</div>
						</div><!--end .panel -->
					</div><!--end .panel-group -->
				</div><!--end .panel-group -->
			</div><!--end .row -->
		</div><!--end .card-body -->
		<!-- END SEARCH RESULTS -->

	</div><!--end .card -->
</div><!--end .section-body -->
