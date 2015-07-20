<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="{{ URL::to('bootstrap/css/bootstrap.css') }}">
  
  <style>
    #register-form
    {
      border: 1px solid #ebf7f7;
      border-radius: 5px;
      box-shadow:  0pt 0px 5px rgba(105, 108, 109, 0.7),
             0px 0px 8px 5px rgba(208, 223, 226, 0.4) 
             inset;
      margin-top: 50px;
      padding: 60px 20px;
      background-color: #e0faf9;
    }

    label.error
    {
      color: red;
    }
  </style>
 
</head>
<body>
  <div class="container">
      <div class="row">
        <div class="col-lg-offset-2 col-lg-7" id="register-form">
          <h4>Register</h4>
          @if($errors->has())
          <p>The following errors have occured: </p>

          <ul>
            {{ $errors->first('name', '<li>:message</li>') }}
            {{ $errors->first('username', '<li>:message</li>') }}
            {{ $errors->first('email', '<li>:message</li>') }}
            {{ $errors->first('password', '<li>:message</li>') }}
            {{ $errors->first('password_confirm', '<li>:message</li>') }}
          </ul>
          @endif

          {{ Form::open(array('url' => 'signup', 'id'=>'signup-form')) }}
              <div class="row">
                {{ Form::text('name', '', array('class'=>'form-control', 'placeholder'=>'Enter your full name here')) }}
              </div>
              <div class="row">
                {{ Form::text('username', '', array('class'=>'form-control', 'placeholder'=>'Enter your full username here')) }}
              </div>
              <div class="row">
                {{ Form::email('email', '', array('class'=>'form-control', 'placeholder'=>'Enter your full email here')) }}
              </div>
              <div class="row">
                {{ Form::password('password',array('class' => 'form-control' ,'placeholder' => 'Password', 'id'=>'password')) }}
              </div>
              <div class="row">
                {{ Form::password('password_confirm',array('class' => 'form-control' ,'placeholder' => 'Confirm Password')) }}
              </div>
              
             {{ Form::submit('Create Account', array('class'=>'btn btn-info')) }}
          {{ Form::close() }}
        </div>
      </div>
  </div>

  <script src="{{ URL::to('js/jquery.js') }}"></script>
  <script src="{{ URL::to('js/jquery.validate.min.js') }}"></script>
  <script src="{{ URL::to('js/additional-methods.min.js') }}"></script>
  <script>
      $(document).ready(function()
      {
          $('#signup-form').validate({
              rules: {
                  name: {
                    required: true,
                    minlength: 6,
                    maxlength: 16,
                    pattern: /^[A-Za-z.' ]+$/
                  },

                  username: {
                    required: true,
                    minlength: 6,
                    maxlength: 16,
                    pattern: /^[A-Za-z0-9.\-]+$/
                  },

                  email: {
                    required: true,
                    email: true
                  },

                  password: {
                    required: true,
                    minlength: 6,
                    maxlength: 25,
                    pattern: /^[A-Za-z0-9@.]+$/
                  },

                  password_confirm: {
                    required: true,
                    minlength: 6,
                    maxlength: 25,
                    equalTo: '#password'
                  }
              },

              messages: {
                name: {
                    required: "A full name is required.",
                    minlength: "The name is too short, a minimum of 6 letters is required",
                    maxlength: "The name is too long, a maximum of 25 letters is required",
                    pattern: "Invalid name. Use Letters, apostrophe(') or space."
                  },

                  username: {
                    required: "A username is required.",
                    minlength: "The username is too short, a minimum of 6 letters is required",
                    maxlength: "The username is too long, a maximum of 16 letters is required",
                    pattern: "Invalid username. Use Letters,numbers, hyphen(-) or dot(.)"
                  },

                  email: {
                    required: "Email address is required",
                    email: "Email provided is invalid."
                  },

                  password: {
                    required: "A password is required.",
                    minlength: "Too short password",
                    maxlength: "Too long password",
                    pattern: "Invalid password provided. Use letters, numbers, @ or dot(.)"
                  },

                  password_confirm: {
                    required: "A password confirmation is required.",
                    minlength: "Too short password",
                    maxlength: "Too long password",
                    equalTo: "Please enter the same password as above."
                  }
              }
          });
      });
  </script>
</body>
</html>
