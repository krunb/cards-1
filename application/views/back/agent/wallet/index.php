
<div class="container">
    <header>
        <?php $this->load->view("include/navbar-agent");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>المحفظة</h3>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item active">المحفظة</li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<div class="d-flex justify-content-between">
								<h4 class="card-title">المحفظة</h4>
								<a class="btn btn-success" href="<?=site_url()?>agent/charge_wallet"> اضافة رصيد</a>
							</div>
							<div class="row mt-4">
								<div class="col-xl-3 col-lg-4 col-md-6 col-12">
									<label for="" class="mb-2">عرض محفظة الزبون</label>
									<select class="form-control form-control-lg choices customer_wallet" name="customer_id" required>
										<option value="" disabled selected> اختر الزبون</option>
										<?php foreach($customer as $c){?>
										<option value="<?= $c->customer_id?>"> <?= $c->customer_id?> - <?= $c->customer_name?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<div class="table-responsive"> 
									<table class="table table-borderless mb-0" id="customer_wallet">
										<thead>
											<tr>
												<td>الزبون</td>
												<td>تاريخ العملية</td>
												<td>نوع العملية</td>
												<td>الرصيد قبل</td>
												<td>القيمة</td>
												<td>الرصيد بعد</td>
												<td>المرفقات</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach($view as $v){
												if (! file_exists($v->customer_logo)){
													$img = '<div class="avatar avatar-lg  bg-primary me-3">
																<span class="avatar-content"><i class="iconly-boldProfile"></i></span>
															</div>';
												} else {
													$img = '<div class="avatar avatar-lg me-3"><img src="'. site_url().$v->customer_logo .'" alt="" srcset=""></div>';
												}
											?>
											<tr> 
												<td >
													<?= $img.$v->customer_name?>
												</td> 
												<td > <?= $v->customer_wallet_create_at?> </td> 
												<td>
													<?php if($v->customer_wallet_type_id == 1){ 
													?>
														<span class="badge bg-success"> شحن </span>
													<?php } else{ ?>
														<span class="badge bg-danger"> شراء </span>
													<?php }?>
												</td>
												<td > <?= $v->customer_wallet_old_balance?> </td> 
												<td > <?= $v->customer_wallet_new_balance?> </td> 
												<td > <?= $v->customer_wallet_total_balance?> </td>
												<td > <a class="btn btn-primary" href="<?= site_url().$v->bank_receipt?>" target="_blank"> المرفقات</a></td>
											</tr>	
											<?php }?>
										</tbody>
									</table>
									
									<?php if(isset($links)) echo $links?>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div> 
		</div>
	</div>
</div>

<script>
	$('.customer_wallet').change(function(e) {
		e.preventDefault();
		$.ajax({
			type: "post", 
			dataType: "html",
			url: "<?= site_url()?>agent/customer_wallet",
			data: {
				customer_id : $(this).val(),
				"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
			},
			success: function(res){
				$("#customer_wallet tbody").html(res);
			},
			error: function() {
				Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
			}
		});
    });
</script>
