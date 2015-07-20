<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KU - Sharing Forum</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ URL::to('bootstrap/css/bootstrap.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ URL::to('bootstrap/css/agency.css') }}">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand page-scroll"n>Students Forum</span>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ URL::to('/') }}">Home</a></li>
                    <li><a href="{{ URL::to('all-problems') }}">View Problems</a></li>
                    <li><a href="{{ URL::to('problem/new') }}">Post Problems</a></li>
                    <li><a href="{{ URL::to('about') }}">About</a></li>
                    <li><a data-toggle="modal" data-target="#contact-us" href="">Contact Us</a></li>
                    @if(Auth::guest())
                        <a class="btn btn-primary" style="margin-top: 8px;" href="{{ URL::to('login') }}"> Log in</a>
                    @else
                        <a class="btn btn-primary" style="margin-top: 8px;" href="{{ URL::to('logout') }}"> Log out</a>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome To KU Students Sharing Forum!</div>
                <div style="font-size: 52px;" class="intro-heading">Share your past experience with your colleagues</div>
            </div>
        </div>
    </header>

    

    <!--footer start-->
     <footer class="footer" >
         <div class="container">
             <div class="row">
                 <div class="col-lg-3 col-sm-3">
                     <h3>contact info</h3>
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
     </footer>
     <!--footer end-->

    <!--Begin: Contact Us Modal-->
    <div class="modal fade" id="contact-us">
     <form name="sentMessage" id="contactForm" novalidate action="{{ URL::to('send-email') }}" method="POST">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Contact Us</h4>
          </div>
          <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your Name *" id="name" name="name" required data-validation-required-message="Please enter your name.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Your Email *" id="email" name="email" required data-validation-required-message="Please enter your email address.">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea rows="10" class="form-control" placeholder="Your Message *" id="message" name="message" required data-validation-required-message="Please enter a message."></textarea>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Send Email">
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </form>
    </div><!-- /.modal -->
    <!--End: Contact Us Modal-->

    <script src="{{ URL::to('js/jquery.js') }}"></script>
    <script src="{{ URL::to('bootstrap/js/bootstrap.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>

</html>
