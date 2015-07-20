<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ URL::to('bootstrap/css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ URL::to('redactor/redactor.css') }}">
    <!--external css-->
  
      <!-- Custom styles for this template -->
    <link href="{{ URL::to('bootstrap/css/style.css') }}" rel="stylesheet">
	
	<style>
		@media (min-width: 768px) {
		  .container {
		    width: 550px;
		  }
		}
		@media (min-width: 992px) {
		  .container {
		    width: 800px;
		  }
		}
		@media (min-width: 1200px) {
		  .container {
		    width: 960px;
		  }
		}


.header-frontend .nav li a:hover, 
.header-frontend .nav li a:focus, 
.header-frontend .nav li.active a, 
.header-frontend .nav li.active a:hover, 
.header-frontend .nav li a.dropdown-toggle:hover, 
.header-frontend .nav li a.dropdown-toggle:focus, 
.header-frontend .nav li.active ul.dropdown-menu li a:hover, 
.header-frontend .nav li.active ul.dropdown-menu li.active a {
    color: #FFF;
    background-color: #A4ABCC;
    transition: all 0.3s ease 0s;
}

.problem .row
{
  margin-bottom: 15px;
}
	</style>

	@yield('problem-style')
	@yield('new-problem-style')
	@yield('all-problem-style')
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltips and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="background-color:#F1F2F7">
     <!--header start-->
    <header class="header-frontend">
        <div class="navbar navbar-default navbar-static-top" style="background-color:#474408">
            <div class="container">
                <div class="row">
	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                        <span class="icon-bar"></span>
	                        <span class="icon-bar"></span>
	                        <span class="icon-bar"></span>
	                    </button>
	                    <a class="navbar-brand" href=""><h2>KU STUDENTS SHARING FORUM</h2></a>
	                </div>
                    @if(Auth::check())
                        <a class="pull-right btn btn-primary" style="margin-top: 38px;" href="{{ URL::to('logout') }}"> Log Out</a>
                    @else
                        <a class="pull-right btn btn-primary" style="margin-top: 38px;" href="{{ URL::to('login') }}"> Log in</a>
                    @endif
	                 
                </div>
                <div class="row">
		            <div class="navbar-collapse collapse ">
		                <ul class="nav navbar-nav pull-left">
		                    <li><a href="{{ URL::to('/') }}">Home</a></li>
		                    <li><a href="{{ URL::to('all-problems') }}">View Problems</a></li>
                            <li><a href="{{ URL::to('problem/new') }}">Post Problems</a></li>
		                    <li><a href="{{ URL::to('about') }}">About</a></li>
		                    <li><a data-toggle="modal" data-target="#contact-us" href="">Contact Us</a></li>
		                </ul>
		            </div>
                </div>

            </div>
        </div>
    </header>
    <!--header end-->

    <!--container start-->
    <div class="container" style="width:1030px; min-height:400px">
		@yield('contents')
    </div>
    <!--container end-->
    
    @yield('edit-solution-modal')
    
     <!--footer start-->
     <footer class="footer">
         <div class="container">
             <div class="row">
                 <div class="col-lg-3 col-sm-3">
                     <h1>contact info</h1>
                     <address>
                         <p>Address: No.28-63877 street</p>
                         <p>Nairobi city, Country</p>

                         <p>Phone : (123) 456-7890</p>
                         <p>Fax : (123) 456-7890</p>
                         <p>Email : <a href="javascript:;">support@Kusharingforum.com</a></p>
                     </address>
                 </div>
                 </div>
             </div>
         </div>
     </footer>
     <!--footer end-->

        <!--Begin: Contact Us Modal-->
    <div class="modal fade" id="contact-us">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Contact Us</h4>
          </div>
          <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form name="sentMessage" id="contactForm" novalidate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea rows="10" class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Send Email</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--End: Contact Us Modal-->
    
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ URL::to('js/jquery.js') }}"></script>
	<script src="{{ URL::to('bootstrap/js/bootstrap.js') }}"></script>
	<script src="{{ URL::to('redactor/redactor.js') }}"></script>

	@yield('view-problem-script')
	@yield('new-problem-script')
  </body>
</html>
