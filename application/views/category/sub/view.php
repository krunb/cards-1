<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content">
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3><?= json_decode($view->category_name)->ar?></h3>
					<p class="text-subtitle text-muted">تعديل بيانات التصنيف الفرعي</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>category">التصنيفات الرئيسية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>category/view_sub_category/<?= $view->category_root?>">التصنيفات الفرعية</a></li> 
							<li class="breadcrumb-item active"><?= json_decode($view->category_name)->ar?></li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>category/update_category" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="category_id" value="<?= $view->category_id?>"> 
				
				<div class="row"> 
					<div class="col-xl-6"> 
						<div class="card">
							<div class="card-header">
								<h4 class="card-title"><?= json_decode($view->category_name)->ar?></h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row ">
											<div class="col-md-3">
												<label>صورة تعبيرية</label>
											</div>
											<div class="col-md-3 order-md-3">
												<div class="upload-pic-box">
													<label for="profile_pic" class="view-pic">
														<img src="<?= site_url().$view->category_pic;?>" class="img-fluid rounded preview-pic" width="150">
													</label>
													<input type="file" class="form-control d-none upload-pic" id="profile_pic" name="category_pic" id="formFile" required>
													<div class="invalid-feedback">مطلوب</div>
													<input type="hidden" class="form-control" name="last_category_pic" value="<?= $view->category_pic;?>">
												</div>
											</div>
										</div> 
										<div class="row mt-4">
											<div class="col-md-3">
												<label> التصنيف الرئيسي</label>
											</div>
											<div class="col-md-9 order-md-3">
												<div class="form-group">
													<select name="category_root" class="form-control" required>
														<?php foreach($category as $c){?>
														<option value="<?= $c->category_id?>" <?php ($view->category_root == $c->category_id) ? "selected" : ""?>><?= json_decode($c->category_name)->ar?></option>
														<?php }?>
													</select>
												</div>
											</div>
										</div>
										<hr>
										<?php foreach($language as $l){ 
											$short = $l->lang_short;
										?>
										<div class="<?php if($l->lang_active == 0) echo "d-none";?>">
											<h5 class="pb-3"><?= $l->lang_name?></h5>
											<div class="row"> 
												<div class="col-md-3">
													<label>اسم التصنيف الفرعي</label>
												</div>
												<div class="col-md-9 form-group">
													<input type="text" class="form-control form-control-lg" name="category_name[<?= $short?>]" value="<?= json_decode($view->category_name)->$short?>" > 
												</div>
												 
												<div class="col-md-3">
													<label>تفاصيل التصنيف الفرعي</label>
												</div>
												<div class="col-md-9 form-group">
													<textarea rows="5" type="text" class="form-control form-control-lg " name="category_details[<?= $short?>]"> <?= json_decode($view->category_details)->$short?> </textarea>
												</div>
												<hr class="my-3">
											</div>
											<?php }?>
										</div> 
										
										<div class="row">
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>category/view_sub_category/<?= $view->category_root?>" class="btn btn-light-secondary mb-1"> الغاء</a>
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> 
					
				</div>  
			</form> 
		</div>
	</div>
</div>

<script>
	$('#form').submit(function(e) {  
		var form = $(this);
		e.preventDefault(); 
		$(".btn-submit .spinner-border").toggleClass("d-none");
		form.addClass("disabled");
		
		$.ajax({
			type: "post", 
			dataType: "html",
			url: form.attr("action"),
			//data: form.serialize(), 
			data:new FormData(this),
			processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(res){
				var res = JSON.parse(res);
				setTimeout( function(){
					runToastify(res.res);
					$(".btn-submit .spinner-border").toggleClass("d-none");
					form.removeClass("disabled");
				}, 3000);
			},
			error: function() {  
				Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
			}
		});
    });
</script>