<!doctype html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Login Page</title>

 <!-- Bootstrap core CSS -->
    <link href="{{ URL::to('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('bootstrap/css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <!-- Custom styles for this template -->
    <link href="{{ URL::to('bootstrap/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::to('bootstrap/css/style-responsive.css') }}" rel="stylesheet" />

  <style>
 #login-form
 {
 padding: 3%;
 width: 35%;
 margin-top: 20%;
 margin-right: auto;
 margin-left: auto;
 border: 1px solid rgba(105, 108, 109, 0.7);
 border-radius: 5px;
 box-shadow: 0pt 0px 5px rgba(105, 108, 109, 0.7),
 0px 0px 8px 5px rgba(208, 223, 226, 0.4) 
 inset;
 background-color: #e0faf9;
 }
 </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
 <div class="container">
   <p style="background-color:red;">
     @if(Session::has('message'))
       {{ Session::get('message') }}
     @endif
   </p>
   <div id="login-register">
     <div id="login-form">
       @if($errors->has())
         <p>The following errors have occured: </p>
         <ul>
            {{ $errors->first('email', '<li>:message</li>') }}
            {{ $errors->first('password', '<li>:message</li>') }}
         </ul>
       @endif
       {{ Form::open(array('url'=>'login', 'method'=>'post')) }}
         {{ Form::email('email','', array('class' => 'form-control' ,'placeholder' => 'Enter e-mail address')) }}<br>
         {{ Form::hidden('url', $url) }}<br>
         {{ Form::password('password',array('class' => 'form-control' ,'placeholder' => 'Password')) }}<br>
         {{ Form::checkbox('remember', '1', array('id'=>'remember')) }}
         {{ Form::label('remember', 'Remember Me') }} <br><br>
         {{ Form::submit('Login', array('class'=>'btn btn-success')) }} <br>
         <div class="registration">
              Don't have an account yet?
              <a class="" href="{{ URL::to('signup') }}">
                  Create an account
              </a>
          </div>
       {{ Form::close() }}
     </div>
   </div>
 </div>
</body>
</html>