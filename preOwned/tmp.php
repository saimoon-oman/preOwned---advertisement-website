<?php
session_start();
?>
<?php
include 'dbconnect.php';
$query = "Select * from ads";
$res = mysqli_query($con, $query);
$rescheck = mysqli_num_rows($res);
if ($rescheck > 0) {
  while ($row = mysqli_fetch_assoc($res)) {
    $expDate = $row['endDate'];
    $today = date("Y-m-d");
    
    $today_time = strtotime($today);
    $expire_time = strtotime($expDate);

    if ($expire_time < $today_time) { 
      $q = "Delete from ads where endDate = '".$expDate."'";
      $res1 = mysqli_query($con, $q);
    }
  }
}
?>
<?php
if (isset($_SESSION["start"])) { if( time() > $_SESSION["start"]) {
  unset($_SESSION["userid"]);
  unset($_SESSION["username"]);
  unset($_SESSION["email"]);
  unset($_SESSION["start"]);
  ?>
  <script>
    alert("Session is automatically destroyed after 15 minutes");
  </script>
  <?php
} }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ad</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/lightbox.min.css">
  <link rel="stylesheet" href="css/tmp.css">
  <script src="js/lightbox-plus-jquery.min.js"></script>
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    .footer {
      background: #152F4F;
      color: white;
    }
  </style>
</head>

<body>
  <div class="navigation">
    <nav class="navbar navbar-expand-sm navbar-light" style="padding-top: 0px; padding-bottom: 0px;">
      <div class="container-fluid">
        <form action="indeximg.php" method="POST">
          <button type="submit" class="navbar-brand" style="border: none;" name="home"><img src="images/logo2.png" alt="logo" width="150" style="border-radius: 50%;" /></button>
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

  <?php

  include 'dbconnect.php';
  $qq = "Select * from ads";
  $resqq = mysqli_query($con, $qq);
  $resqqcheck = mysqli_num_rows($resqq);
  if ($resqqcheck > 0) {
    while ($rowqq = mysqli_fetch_assoc($resqq)) {
      if (isset($_POST[$rowqq['ad_id']])) {
        $squeryfromregister = "Select * from registration where userid=" . $rowqq['user_id'];
        $resregis = mysqli_query($con, $squeryfromregister);
        $resregischeck = mysqli_num_rows($resregis);
        if ($resregischeck > 0) {
          $rowregi = mysqli_fetch_assoc($resregis);
          $pby = $rowregi['username'];
        }
        $phone = $rowqq['phone'];
        echo "<div class='container-fluid' id='ban' style='border-radius: 0 0 10px 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
          <div id='details'>
            <div class='container-fluid'>" . $rowqq['cat'] . "</div>
            <div class='container-fluid' style='font-size: 35px'>" . $rowqq['title'] . "</div>
            <div class='container-fluid'>
              <div class='row'>
                <div id='location' class='col'>
                  <img src='images/location.png' alt='location image' width='20px' />
                  " . $rowqq['loc'] . "
                </div>
                <div id='mobileNo' class='col-3'>
                  <button id='mobileNoButton'>
                    <img src='images/mobile_image.png' alt='mobile image' width='25px' />
                    <div style='display: inline; padding-left: 5px;' id='mNo'>
                      Click to view
                    </div>
                  </button>
                </div>
              </div>
            </div>
            <hr />
            <div class='container-fluid'>
              <div class='row'>
                <div id='date' class='col'> Posted On : " . $rowqq['postDate'] . " &nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp Posted By : " . $pby . "</div>
                <div id='price' class='col-4'>
                  <span>" . $rowqq['price'] . "</span>(
                  <span>" . $rowqq['isnego'] . "</span>
                  )
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class='container-fluid' id='adImages' style='border-radius: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
          <div class='row'>
            <div class='col'>
              <div class='gallery'>
                <a href='" . $rowqq['img1'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img1'] . "' alt='no image' width='580px'></a>
              </div>
              <div class='gallery' style='padding-top: 20px;'>
                <a href='" . $rowqq['img2'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img2'] . "' alt='no image' width='142px'></a>
                <a href='" . $rowqq['img3'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img3'] . "' alt='no image' width='142px'></a>
                <a href='" . $rowqq['img4'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img4'] . "' alt='no image' width='142px'></a>
                <a href='" . $rowqq['img5'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img5'] . "' alt='no image' width='142px'></a>
              </div>
            </div>
            <div class='col-3' id='adSideDetails'>
              <div class='adSideSpec'>
                <span>Price:</span>
                <span style='padding-right: 5px; padding-left: 10px'>" . $rowqq['price'] . "</span>(
                <span>" . $rowqq['isnego'] . "</span>
                )
              </div>
              <div class='adSideSpec'>
                <span>Condition:</span>
                <span style='padding-right: 5px; padding-left: 10px'>" . $rowqq['con'] . "</span>
              </div>
              <div class='adSideSpec'>
                <span>Authenticity:</span>
                <span style='padding-right: 5px; padding-left: 10px'>" . $rowqq['aut'] . "</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class='container-fluid' id='adDes' style='border-radius: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
        <div class='row'>
          <div class='col'>
            <h5>Features</h5>
            <p>
              " . $rowqq['feature'] . "
            </p>
          </div>
        </div>
        <div class='row'>
          <div class='col'>
            <h5>Description</h5>
            <p>
              " . $rowqq['des'] . "
            </p>
          </div>
        </div>
      </div>

      

        ";
      }
    }
  }
  ?>

  <script>
    document
      .getElementById('mobileNoButton')
      .addEventListener('click', displayMobileNo);

    function displayMobileNo() {
      document.getElementById('mNo').innerHTML = "<?php echo "$phone" ?>  ";
    }
  </script>

<div class="mt-5 pt-5 pb-5 footer" style='border-radius: 10px 10px 0 0; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-xs-12 about-company" style="text-align: left; padding-right: 50px;">
          <h2>About preOwned</h2>
          <p class="pr-5 text-white-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Hic sint tempore qui ratione dolor omnis iusto, fugit optio voluptates laudantium! Non tempore nam, molestias provident quod nemo ipsum error at ducimus autem voluptas iusto tempora harum nulla dolorem mollitia quam sed inventore, officia exercitationem placeat debitis illum ut! Voluptatum, saepe.</p>
          <p><a href="#"><i class="fa fa-facebook-square mr-1"><img src="images/fb1.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></i></a><a href="#"><i class="fa fa-linkedin-square"><img src="images/twitter.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></i></a><a href="#"><i class="fa fa-linkedin-square"><img src="images/insta.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></i></a></p>
        </div>
        <div class="col-lg-3 col-xs-12 links" style="text-align: left;">
          <h4 class="mt-lg-0 mt-sm-3">Links</h4>
          <ul class="m-0 p-0" style="text-align: left;">
            <li>- <a href="#">Home</a></li>
            <li>- <a href="#">About</a></li>
            <li>- <a href="#">Contact</a></li>
            <li>- <a href="#">FAQ</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-xs-12 location" style="text-align: left;">
          <h4 class="mt-lg-0 mt-sm-4">Location</h4>
          <br>
          <p><img src="images/locc.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 20px;"><span>67/9 Kamal Road</span>Uttara, Dhaka</p>
          <p class="mb-0"><i class="fa fa-phone mr-3"><img src="images/call.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 20px;">
            </i>+8801718478921</p>
          <br>
          <p><i class="fa fa-envelope-o mr-3"><img src="images/msg.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 20px;">
            </i><a id="eemail" href="mailto:preownedshop123@gmail.com">preownedshop123@gmail.com</a></p>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col copyright">
          <p class=""><small class="text-white-50">© 2019. All Rights Reserved.</small></p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>

</html>