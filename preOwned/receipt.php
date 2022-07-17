<?php
session_start();
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