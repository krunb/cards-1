<!doctype html>
<html> 
	<head>
		<meta charset="utf-8">  
		<title></title> 
	</head>
	<body style="padding:0; margin:0; font-family: 'arial', sans-serif; background:#435ebe;"> 
		<table style="width: 100%;" dir="rtl">  
			<tr>
				<td>
					<table style="width: 636px; margin: auto; padding: 2rem 1rem; border-spacing: 0;" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="background: #fff; "> 
								<table style="width: 100%; margin: auto; padding: 2rem; ">  
									<tr>
										<td style="padding: 1rem 2rem; text-align: center; ">  
											<img data-src="<?= site_url()?>assets/images/logo/logo.png" src="<?= site_url()?>assets/images/logo/logo.png" alt="Logo">  
										</td> 
									</tr>
									
									<tr>
										<td style="text-align: center;"> 
											<h1 style="color:#435ebe; font-size: 26px; font-weight: 800;  padding: 1rem; line-height: 1.8">كلمة مرور جديد </h1>
										</td> 
									</tr>
									<tr>
										<td style="text-align: center; color:#203444; font-size: 20px; text-align: center; line-height: 1.5"> 
											مرحبا
											<?= $user_name?><br>
											السلام عليكم ورحمة الله وبركاته <br>
											لقد طلبت كلمة مرور جديدة <br>
											وقمنا بإنشاء كلمة مرور جديدة لك <br> <br>
											كلمة المرور الجديدة هي <strong><?= $password?></strong><br> <br>
											نطلب منك تغيير كلمة المرور بعد تسجيل الدخول لاغراض الحماية
										</td> 
									</tr>
								</table>
							</td> 
						</tr> 
						<!-- footer -->
						<tr>
							<td style="padding: 2rem 1rem; background: #FBFBFB; text-align: center;"> 
								<p style="color:#6D6E6D; font-size: 16px; ">
									تواصل معنا عبر البريد الالكتروني التالي 
									<a href="mainto:info@extracard-jo.com" style="color:#435ebe; text-decoration: underline; display: block" dir="ltr">info@extracard-jo.com</a>
								</p> 
								<p style="color:#6D6E6D; font-size: 16px; margin-bottom: 0;">شكراً جزيلاً لك</p> 
								
							</td>
						</tr> 
						<tr>
							<td style=" text-align: center;">  
								<p style="color:#fff; font-size: 16px; direction: ltr;  padding: 1rem 0; ">
									جميع الحقوق محفوظة &copy; <?= date("Y")?>
								</p>
							</td>
						</tr>
					</table>
				</td> 
			</tr> 
		</table> 
	</body>
</html>