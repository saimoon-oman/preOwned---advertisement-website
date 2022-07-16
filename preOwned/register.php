<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/login.css" />
  <title>Register</title>
</head>

<body>
  <div class="container">
    <h3>Register</h3>
    <form action="check.php" method="POST">
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" class="btn" name="register">Register</button>
    </form>
    <p><small>Have an account? <a href="login.php">LogIn here</a>.</small></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>