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
  <title>My receipts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/receipt.css" />
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    #eemail:hover,
    .llink:hover {
      text-decoration: underline;
      transition: 0.3s ease;
      color: royalblue;
    }

    body {
      background-color: #e5e7eb;
    }

    .navigation {
      background-color: #eaf6f7;
      position: sticky;
      top: 0;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      z-index: 100;
    }

    .button1 {
      background-color: #ff9f29;
      color: black;
    }

    .button1:hover {
      background-color: #ff5f00;
      font-weight: bold;
    }

    .nav-font {
      font-size: 20px;
      font-weight: bold;
    }

    #container_id {
      background-color: white;
      border-radius: 5px;
      width: 70%;
      margin: 50px auto;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    a {
      text-decoration: none;
    }

    #column1 {
      padding: 25px 20px;
    }

    #column2 {
      padding: 50px 20px;
    }

    .product {
      cursor: pointer;
      margin-bottom: 2rem;
    }

    .product img {
      transition: 0.3s all;
      width: 100%;
      height: auto;
      /* box-sizing: border-box; */
      /* object-fit: cover; */
    }

    .product:hover img {
      opacity: 0.7;
    }

    .product .view-pro {
      background: #ff9f29;
      transform: translateY(20px);
      opacity: 0;
      transition: 0.3s all;
    }

    .product:hover .view-pro {
      transform: translateY(0);
      opacity: 1;
    }

    .board {
      width: 94%;
      margin: 30px 0 30px 30px;
      overflow: auto;
      background: white;
      border-radius: 8px;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .board img {
      width: 130px;
      height: 130px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 15px;
    }

    .board h5 {
      font-weight: 600;
      font-size: 14px;
    }

    .board p {
      font-weight: 400;
      font-size: 13px;
      color: #787d8d;
    }

    .board .ads {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      text-align: start;
    }

    table {
      border-collapse: collapse;
    }

    tr {
      border-bottom: 1px solid #eef0f3;
    }

    thead td {
      font-size: 14px;
      text-transform: uppercase;
      font-weight: 400;
      background: #f9fafb;
      text-align: start;
      padding: 15px;
    }

    tbody tr td {
      padding: 10px 15px;
    }
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

  <div class="container" id="container_id">
    <div class="row">
      <div class="col-3" id="column1">
        <p style="font-size: 1.5rem;">Account</p>
        <hr>
        <a href="profile.php">My Account</a>
        <hr>
        <a href="receipt.php" style="font-weight: bold;">My Receipts</a>
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
        <h2 class="font-weight-bold" style="padding-left: 23px">Payment Receipts</h2>
        <hr style="
            background-color: #ff5f00;
            width: 100px;
            height: 5px;
            border-radius: 5px;
            border: none;
            margin-left: 23px;
          " />

        <div class="board">
          <table width="100%">
            <thead>
              <tr>
                <td>Ads</td>
                <td></td>
              </tr>
            </thead>
            <tbody>

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
                  echo "<tr>
                 <td class='ads'>
                   <img src='" . $row['img1'] . "' alt='ad img'>
                           <div class='ads-de'>
                             <h5>" . $row['title'] . "</h5>
                             <h5>Expected price: ৳" . $row['price'] . "</h5>
                             <p><span>Category: " . $row['cat'] . "</span>&nbsp;&nbsp;<span> Location:" . $row['loc'] . "</span></p>
                             <p><span>" . $row['con'] . "</span>&nbsp;&nbsp;<span>" . $row['aut'] . "</span></p>
                           </div>
                         </td>
 
                  <td>
                 <form action='t.php' method='POST'>
                   <button name='" . $row['ad_id'] . "' type='submit' class='btn button1'>DOWNLOAD</button>
                 </form>
                 </td>
 
               </tr>";
                }
              }

              ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>


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