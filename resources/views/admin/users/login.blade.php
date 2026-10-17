<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Clean Login Form Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />

<!-- css files -->
<link href="/admin_css/login_css/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
<link href="/admin_css/login_css/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- /css files -->

<!-- online fonts -->
<link href="//fonts.googleapis.com/css?family=Sirin+Stencil" rel="stylesheet">
<!-- online fonts -->

<body>
<div class="container demo-1">
	<div class="content">
        <div id="large-header" class="large-header">
			<h1>Admin Đăng Nhập</h1>
				<div class="main-agileits">
				<!--form-stars-here-->
						<div class="form-w3-agile">
                            @include('admin.alert')
							<h2>Đăng Nhập</h2>
							<form action="/admin/users/login/store" method="post">
								<div class="form-sub-w3">
                                    {{-- email --}}
                                    <input type="text" name="email" placeholder="Username " required="" />
                                    <div class="icon-w3">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
								</div>
								<div class="form-sub-w3">
                                    <input type="password" name="password" placeholder="Password" required="" />
								<div class="icon-w3">
									<i class="fa fa-unlock-alt" aria-hidden="true"></i>
								</div>
								</div>
								{{-- <p class="p-bottom-w3ls">Forgot Password?<a class href="#">  Click here</a></p> --}}
								{{-- <p class="p-bottom-w3ls1">New User?<a class href="#">  Register here</a></p> --}}
								<div class="clear"></div>
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember" style="color: white">
                                    Nhớ Mật Khẩu
                                </label>
								<div class="submit-w3l">
									<input type="submit" value="Xác Nhận"/>
								</div>
                                @csrf
							</form>
							{{-- <div class="social w3layouts">
								<div class="heading">
									<h5>Or Login with</h5>
									<div class="clear"></div>
								</div>
								<div class="icons">
									<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
									<a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
							</div> --}}
						</div>
				<!--//form-ends-here-->
				</div>
					<div class="copyright w3-agile">
						<p> ADMIN SHOP ARB <a href="" target="_blank"></a></p>
					</div>
        </div>
	</div>
</div>	
</body>
</html>
