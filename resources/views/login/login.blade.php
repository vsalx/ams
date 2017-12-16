<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="Dental Appointment Management System">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>
    <div class="login-box">
      <form>
        <p><span class="glyphicon glyphicon-log-in"></span> Login</p>
            <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="email" type="text" class="form-control" name="email" placeholder="Email">
          </div> <br>
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
          </div> <br>
        <button type="button" class="btn">Login</button>
        <button type="button" class="btn pull-right">Sign up</button>
      </form>
    </div>
</body>
</html>