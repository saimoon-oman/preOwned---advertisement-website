<?php
session_start();
if (isset($_COOKIE["userid"])) {

  $_SESSION["userid"] = $_COOKIE["userid"];
  $_SESSION["username"] = $_COOKIE["username"];
  $_SESSION["email"] = $_COOKIE["email"];
  setcookie("userid", "", time() - 3600);
  setcookie("username", "", time() - 3600);
  setcookie("email", "", time() - 3600);

  $val_id = urlencode($_POST['val_id']);
  $store_id = urlencode("preow62d068642ae64");
  $store_passwd = urlencode("preow62d068642ae64@ssl");
  $requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_URL, $requested_url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
  curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

  $result = curl_exec($handle);

  $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

  if ($code == 200 && !(curl_errno($handle))) {

    # TO CONVERT AS ARRAY
    # $result = json_decode($result, true);
    # $status = $result['status'];

    # TO CONVERT AS OBJECT
    $result = json_decode($result);

    # TRANSACTION INFO
    $status = $result->status;
    $tran_date = $result->tran_date;
    $tran_id = $result->tran_id;
    $val_id = $result->val_id;
    $amount = $result->amount;
    $store_amount = $result->store_amount;
    $bank_tran_id = $result->bank_tran_id;
    $card_type = $result->card_type;

    # EMI INFO
    $emi_instalment = $result->emi_instalment;
    $emi_amount = $result->emi_amount;
    $emi_description = $result->emi_description;
    $emi_issuer = $result->emi_issuer;

    # ISSUER INFO
    $card_no = $result->card_no;
    $card_issuer = $result->card_issuer;
    $card_brand = $result->card_brand;
    $card_issuer_country = $result->card_issuer_country;
    $card_issuer_country_code = $result->card_issuer_country_code;

    # API AUTHENTICATION
    $APIConnect = $result->APIConnect;
    $validated_on = $result->validated_on;
    $gw_version = $result->gw_version;

    include 'dbconnect.php';
    $adId = $_COOKIE['adId'];
    setcookie("adId", "", time() - 3600);
    $uId = $_SESSION['userid'];
    $sqql = "insert into payment(ad_id, user_id, tran_date, tran_id, amount, bank_tran_id, card_type) values ('$adId', '$uId', '$tran_date', '$tran_id', '$amount', '$bank_tran_id', '$card_type')";

    $ressqql = mysqli_query($con, $sqql);

    $to_email = $_SESSION["email"];
    $subject = "Payment to preOwned successful";
    $body = "Hello " . $_SESSION['username'] . ", 
       
    
    Your payment is successful 
    
    Transaction Id: " . $tran_id . " 
    
    Amount: " . $amount . " 
    
    Bank Transaction Id: " . $bank_tran_id . " 
    
    Card Type: " . $card_type . " 
    
    Transaction Date: " . $tran_date . " 
    
    
    Thank you for being with preOwned😊";
    $headers = "From: preownedshop123@gmail.com";

    if (mail($to_email, $subject, $body, $headers)) {
?>
      <script>
        alert("Payment confirmation mail has been sent to your email.");
      </script>
<?php
    } else {
      echo "Email sending failed...";
    }
  } else {

    echo "Failed to connect with SSLCOMMERZ";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All Ads</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/allads.css" />
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

  <div class="container-fluid">
    <div class="container-fluid" style="margin: 55px 0 40px">
      <div id="searchForm">
        <form action="allads.php" method="POST">
          <input type="text" name="searchText" id="searchText" size="30" placeholder="What Are You Looking For..." />

          <select name="category" id="category">
            <option value="" disabled selected hidden>Category</option>
            <option value="mobiles">Mobiles</option>
            <option value="electronics">Electronics</option>
            <option value="vehicles">Vehicles</option>
            <option value="home&living">Home & Living</option>
            <option value="pets&animals">Pets & Animals</option>
            <option value="property">Property</option>
            <option value="agriculture">Agriculture</option>
            <option value="jobs">Jobs</option>
          </select>

          <select name="location" id="location">
            <option value="" disabled selected hidden>Location</option>
            <option value="dhaka">Dhaka</option>
            <option value="chattogram">Chattogram</option>
            <option value="sylhet">Sylhet</option>
            <option value="khulna">Khulna</option>
            <option value="barishal">Barishal</option>
            <option value="rajshahi">Rajshahi</option>
            <option value="rangpur">Rangpur</option>
            <option value="mymensingh">Mymensingh</option>
          </select>

          <input class="btn button1" name="searchInAllAds" type="submit" value="Search" />
        </form>
      </div>
    </div>

    <section id="features">
      <h2 class="font-weight-bold" style="padding-left: 23px">All Ads</h2>
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
        if (isset($_POST['c1'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='mobiles' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['c2'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='electronics' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['c3'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='vehicles' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['c4'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='home&living' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['c5'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='pets&animals' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['c6'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='property' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['c7'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='agriculture' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['c8'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where cat='jobs' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l1'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='dhaka' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l2'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='chattogram' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l3'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='sylhet' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l4'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='khulna' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l5'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='barishal' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l6'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='rajshahi' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l7'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='rangpur' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['l8'])) {
          include 'dbconnect.php';

          $squery = "Select * from ads where loc='mymensingh' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        } else if (isset($_POST['indexsearch'])) {

          $stext = $_POST['sT'];

          if (strlen($stext) > 0 && isset($_POST['cT']) && isset($_POST['lC'])) {
            include 'dbconnect.php';
            $a = $_POST['cT'];
            $b = $_POST['lC'];

            $squery = "Select * from ads where cat='$a' and loc='$b' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (strlen($stext) > 0 && isset($_POST['cT'])) {
            include 'dbconnect.php';
            $a = $_POST['cT'];

            $squery = "Select * from ads where cat='$a' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (strlen($stext) > 0 && isset($_POST['lC'])) {
            include 'dbconnect.php';
            $b = $_POST['lC'];

            $squery = "Select * from ads where loc='$b' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (strlen($stext) > 0) {
            include 'dbconnect.php';

            $squery = "Select * from ads where (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (isset($_POST['cT']) && isset($_POST['lC'])) {
            include 'dbconnect.php';

            $a = $_POST['cT'];
            $b = $_POST['lC'];
            $squery = "Select * from ads where cat='$a' and loc='$b' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (isset($_POST['cT'])) {
            include 'dbconnect.php';
            $a = $_POST['cT'];
            $squery = "Select * from ads where cat='$a' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (isset($_POST['lC'])) {
            include 'dbconnect.php';
            $b = $_POST['lC'];

            $squery = "Select * from ads where loc='$b' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          }
        } else if (isset($_POST['searchInAllAds'])) {

          $stext = $_POST['searchText'];

          if (strlen($stext) > 0 && isset($_POST['category']) && isset($_POST['location'])) {
            include 'dbconnect.php';
            $a = $_POST['category'];
            $b = $_POST['location'];

            $squery = "Select * from ads where cat='$a' and loc='$b' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (strlen($stext) > 0 && isset($_POST['category'])) {
            include 'dbconnect.php';
            $a = $_POST['category'];

            $squery = "Select * from ads where cat='$a' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (strlen($stext) > 0 && isset($_POST['location'])) {
            include 'dbconnect.php';
            $b = $_POST['location'];

            $squery = "Select * from ads where loc='$b' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (strlen($stext) > 0) {
            include 'dbconnect.php';

            $squery = "Select * from ads where (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (isset($_POST['category']) && isset($_POST['location'])) {
            include 'dbconnect.php';

            $a = $_POST['category'];
            $b = $_POST['location'];
            $squery = "Select * from ads where cat='$a' and loc='$b' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (isset($_POST['category'])) {
            include 'dbconnect.php';
            $a = $_POST['category'];
            $squery = "Select * from ads where cat='$a' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          } else if (isset($_POST['location'])) {
            include 'dbconnect.php';
            $b = $_POST['location'];

            $squery = "Select * from ads where loc='$b' order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
              }
            }
          }
        } else {
          include 'dbconnect.php';
          $squery = "Select * from ads order by postDate desc";

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
                <h6 class='p-date'>Posted by: " . $pby . "</h6>
                <button name='" . $row['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                </form>
                </div>
              ";
            }
          }
        }
        ?>

      </div>
    </section>
  </div>

  <div class="footer">
    <hr />
    <small>Copywrite 2022 &copy; Theme Created By
      <span style="color: #ff9f29">Saimoon</span> All Rights Reserved.</small>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>