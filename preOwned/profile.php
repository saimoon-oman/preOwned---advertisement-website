<?php
session_start();
?>
<?php
include 'dbconnect.php';
$qq = "Select * from ads";
$resqq = mysqli_query($con, $qq);
$resqqcheck = mysqli_num_rows($resqq);
if ($resqqcheck > 0) {
  while ($rowqq = mysqli_fetch_assoc($resqq)) {
    if (isset($_POST[($rowqq['ad_id']) . "d"])) {
      $squeryfromregister = "delete from ads where ad_id=" . $rowqq['ad_id'];
      $resregis = mysqli_query($con, $squeryfromregister);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Ads</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/profile.css" />
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    #eemail:hover, .llink:hover {
      text-decoration: underline;
      transition: 0.3s ease;
      color: royalblue;
    }
  </style>
</head>

<body>
<div class="navigation">
    <nav class="navbar navbar-expand-sm navbar-light" style="padding-top: 0px; padding-bottom: 0px;">
      <div class="container-fluid">
        <form action="indeximg.php" method="POST">
          <button type="submit" class="navbar-brand" style="border: none;" name="home"><img src="images/logo2.png" alt="logo" width="150" /></button>
        </form>
        <a class="nav-link nav-font navbar-nav" href="<?php
                                                      if (isset($_SESSION["userid"])) echo "allads.php";
                                                      else echo "login.php";
                                                      ?>">All adds</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav nav-font">
            <li class="nav-item">
              <a class="nav-link" href="<?php
                                        if (isset($_SESSION["username"])) echo "profile.php";
                                        else echo "login.php";
                                        ?>"><img src="images/login.png" alt="Login image" width="30" /><?php
                                                                                if (isset($_SESSION["username"])) {
                                                                                  echo $_SESSION["username"];
                                                                                } else {
                                                                                  echo "Login";
                                                                                } ?></a>
            </li>
            <!-- 
              <li class="nav-item">
                <a class="nav-link" href="register.php"
                  ><img
                    src="images/register.png"
                    alt="Register image"
                    width="25"
                  />Register</a
                >
              </li> -->

            <form action="check.php" method="POST">
              <li class="nav-item">
                <span class="nav-link"><button type="submit" name="postbutton" class="btn button1">
                    POST YOUR AD
                  </button></span>
              </li>
            </form>
          </ul>
        </div>
      </div>
    </nav>
  </div>


  <div class="container" id="container_id">
    <div class="row">
      <div class="col-3" id="column1">
        <p style="font-size: 1.5rem;">Account</p>
        <hr>
        <a href="profile.php" style="font-weight: bold;">My Account</a>
        <hr>
        <a href="receipt.php">My Receipts</a>
        <hr>
        <a href="settings.php">Settings</a>
        <hr>
        <br>
        <br>
        <br>
        <br>
        <form action="lg.php" method="POST">
          <button type="submit" name="logout" class="btn button1" style="display:block; width: auto; margin: auto;">Log Out</button>
        </form>
      </div>

      <div class="col" id="column2">
        <p style="font-size: 1.2rem; padding-left: 15px;"><?php echo $_SESSION['username']; ?></p>
        <hr>
        <h2 class="font-weight-bold" style="padding-left: 23px">My Ads</h2>
        <hr style="
            background-color: #ff5f00;
            width: 100px;
            height: 5px;
            border-radius: 5px;
            border: none;
            margin-left: 23px;
          " />
        <div class="row mx-auto container-fluid">
          <?php
          include 'dbconnect.php';

          $squery = "Select * from ads where user_id=" . $_SESSION['userid'] . " order by postDate desc";

          $res = mysqli_query($con, $squery);
          $rescheck = mysqli_num_rows($res);
          if ($rescheck > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
              $squeryfromregister = "Select * from registration where userid=" . $row['user_id'];
              $resregis = mysqli_query($con, $squeryfromregister);
              $resregischeck = mysqli_num_rows($resregis);
              if ($resregischeck > 0) {
                $rowregi = mysqli_fetch_assoc($resregis);
                $pby = $rowregi['username'];
              }
              echo "
              <div class='product text-center col-lg-3 col-md-4 col-12'>
              <form action='tmp.php' method='POST'>  
              <img
                  class='img-fluid mb3'
                  src='" . $row['img1'] . "'
                  alt=''
                />
                <h6 class='p-name'>" . $row['title'] . "</h6>
                <h5 class='p-price'>" . $row['price'] . "</h5>
                <h6 class='p-category'>" . $row['cat'] . "</h6>
                <h6 class='p-location'>" . $row['loc'] . "</h6>
                <h6 class='p-date'>Posted on: " . $row['postDate'] . "</h6>
                <h6 class='p-date'>Posted till: " . $row['endDate'] . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                <form action='profile.php' method='POST'>
                <button name='" . $row['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button> 
                </form>
                </div>
              ";
            }
          }
          ?>
        </div>

      </div>
    </div>
  </div>

  
  <footer class="footer-distributed" style="background: #b1c1d5; border-radius: 10px; ">

<div class="row">
  <div class="footer-left col" style="padding-top: 40px;">

    <img src="images/logo2.png" alt="" width=150 height=100 style="border-radius: 50%;">

    <p class="footer-links">
      <a href="#" style="color: white; font-size: 20px;" class=".llink">Home</a> ·
      <a href="#" style="color: white; font-size: 20px;" class=".llink">About</a> ·
      <a href="#" style="color: white; font-size: 20px;" class=".llink">Pricing</a> ·
      <a href="#" style="color: white; font-size: 20px;" class=".llink">About</a> ·
      <a href="#" style="color: white; font-size: 20px;" class=".llink">Faq</a> ·
      <a href="#" style="color: white; font-size: 20px;" class=".llink">Contact</a>
    </p>

    <p class="footer-company-name">preOwned &copy; 2018</p>
  </div>

  <div class="footer-center col" style="padding-top: 10px;">

    <div>
      <img src="images/locc.png" alt="" style="width: 40px; height: 40px; border-radius: 50%;">
      <p style="font-size: 20px;"><span>67/9 Kamal Road</span>Uttara, Dhaka</p>
    </div>

    <div>
      <img src="images/call.png" alt="" style="width: 40px; height: 40px; border-radius: 50%">
      <p style="font-size: 20px;">+8801713487924</p>
    </div>

    <div>
      <img src="images/msg.png" alt="" style="width: 40px; height: 40px; border-radius: 50%">
      <p style="font-size: 20px;"><a id="eemail" href="mailto:preownedshop123@gmail.com">preownedshop123@gmail.com</a></p>
    </div>

  </div>

  <div class="footer-right col" style="padding: 10px 10px 0 0;">

    <p class="footer-company-about">
      <span style="font-size: 30px;">About this company</span><br><br><span style="text-align: justify; text-justify: inter-word;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur, dolorem possimus ea ab corporis id placeat cumque nemo molestiae facere temporibus ex qui? Architecto, aliquam quidem! Quod necessitatibus distinctio voluptate? Facilis laborum commodi nulla quas dignissimos quidem optio ex nam officia inventore error ea labore iure voluptates officiis, ipsam similique.</span>
    </p>

    <div class="footer-icons" style="width: 60%; margin: 10px auto;">

      <a href="#"><img src="images/fb1.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block;"></i></a>
      <a href="#"><img src="images/twitter.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block;"></i></a>

    </div>

  </div>
</div>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>