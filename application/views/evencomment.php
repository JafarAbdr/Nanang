<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- BEGIN CONTENT-->
			<div>

				<!-- BEGIN PROFILE HEADER -->
				<section class="full-bleed">
					<div class="card card-underlined" style="margin-bottom : 0px; padding-bottom : 0px;">
						<div class="card-head  card-head-sm">
							
							<header>
								
								<img style="margin-right : 10px;" class="img-circle img-responsive pull-left width-1" src="source/assets/img/avatar2.jpg?1404026449" alt="" />
								<?php echo $author;?><br><?php echo $update;?>
							</header>
							<div class="tools">
								<div class="btn-group">
									<a class="btn btn-icon-toggle btn-collapse" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<p><?php echo $deskripsi;?></p>
						</div>
					</div>
				</section>
				<!-- END PROFILE HEADER  -->

				<section class="full-bleed">
					<div class="section-body no-margin">
						<div class="row">
							<div class="col-md-12">
								<h3>Comment on this post</h3>

								<!-- BEGIN ENTER MESSAGE -->
								<form class="form">
									<div class="card no-margin" id="head-post">
										<div class="card-body" id="post-comment" style="background-color : rgb(255,255,255);">
											<div class="form-group floating-label">
												<textarea 
													id="text-comment"
													style="resize : none; max-height : 95px; height : 95px;" 
													onfocus="
														x = document.getElementById('post-comment'); 
														y = document.getElementById('head-post'); 
														width = x.getBoundingClientRect().width; 
														height = y.getBoundingClientRect().height; 
														
														console.log(width);
														x.style.position = 'absolute'; 
														x.style.width = (width-2)+'px'; 
														x.style.marginLeft = '1px';
														x.style.zIndex = 40000;
														x.style.border = '3px';
														x.style.borderColor = 'black';
														y.style.height = height+'px';
													" 
													onblur="
														y = document.getElementById('head-post'); 
														x = document.getElementById('post-comment'); 
														x.style.position = 'static'; 
														x.style.marginLeft = 'auto';
														x.style.width = 'auto';
														x.style.border = '0px';
														
														x.style.borderColor = 'white';
														y.height = 'auto';
													" 
													name="status" id="status" class="form-control autosize" rows="1"></textarea>
												<label for="status">What's on your answer?</label>
											</div>
										</div><!--end .card-body -->
										<div class="card-actionbar">
											<div class="card-actionbar-row">
												<div class="pull-left">
													<a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-camera-alt"></i></a>
													<a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-location-on"></i></a>
													<a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-attach-file"></i></a>
												</div>
												<a id="add-comment-to-this" href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction"><i class="md md-send"></i></a>
											</div><!--end .card-actionbar-row -->
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
								</form>

								<!-- BEGIN ENTER MESSAGE -->

								<!-- BEGIN MESSAGE ACTIVITY -->
								<div class="tab-pane"  style="max-height : 450px; overflow-x : hidden; overflow-y : scroll;">
									<div style="padding : 3px 20px;">
										<ul class="timeline collapse-lg timeline-hairline">
											<?php 
											if($jumlah > 0){
											for($i=1;$i<=$jumlah;$i++){
												$ico = "";
												if($comment[$i]['icon'] == 1){
													$ico = 'md-person-outline';
												}else if($comment[$i]['icon'] == 2){
													$ico = 'md-person';
												}else if($comment[$i]['icon'] == 3){
													$ico = 'md-people';
												}else if($comment[$i]['icon'] == 4){
													$ico = 'md-school';
												}else {
													$ico = 'md-mood';
												}
											?>
											<li>
												<div class="timeline-circ circ-xl style-primary"><i class="md <?php echo $ico;?>"></i></div>
												<div class="timeline-entry">
													<div class="card style-default-light">
														<div class="card-body small-padding">
															<img class="img-circle img-responsive pull-left width-1" src="source/assets/img/avatar2.jpg?1404026449" alt="" />
															<span class="text-medium">Comment by <span class="text-primary"><?php echo $comment[$i]['author'];?></span></span><br/>
															<span class="opacity-50">
																<?php echo $comment[$i]['update'];?>
															</span>
														</div>
														<div class="card-body" style="padding : 3px 24px;">
															<?php echo $comment[$i]['deskripsi'];?>
														</div>
													</div>
												</div><!--end .timeline-entry -->
											</li>
											<?php }
											}else{
											?>
											<li class="timeline-inverted">
												<div class="timeline-circ circ-xl style-primary"><i class="md md-dnd-on"></i></div>
												<div class="timeline-entry">
													<div class="card style-default-light">
														<div class="card-body small-padding">
															<span class="text-medium">No comment from any body</span><br/>
															<span class="opacity-50">
																until now.
															</span>
														</div>
													</div>
												</div><!--end .timeline-entry -->
											</li>
											<?php 
											}
											?>
										</ul>
									</div>
								</div><!--end #activity -->
							</div><!--end .col -->
							<!-- END MESSAGE ACTIVITY -->
						</div><!--end .row -->
					</div><!--end .section-body -->
				</section>
			</div><!--end #content-->