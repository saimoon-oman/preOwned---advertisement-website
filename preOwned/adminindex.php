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
      $q = "Delete from ads where endDate = '" . $expDate . "'";
      $res1 = mysqli_query($con, $q);
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
  <title>Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://usa.fontawesome.com/releases/v5.15.5/css/all.css" />
  <link rel="stylesheet" href="css/adminstyles.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>

<body>
  <div class="row">
    <section id="menu" class="col-3">
      <div class="logo">
        <img src="images/logo2.png" alt="">
        <h2>preOwned</h2>
      </div>

      <div class="items">
        <?php
        if (isset($_SESSION["adminusername"])) {echo "<li><i class='fa-solid fa-chart-pie-simple'></i><a href='#'>".$_SESSION["adminusername"]."</a></li>";} else echo "<li><i class='fa-solid fa-chart-pie-simple'></i><a href='#'>Saimoon</a></li>";
        ?>
        <li><i class="fa-solid fa-chart-pie-simple"></i><a href="admindash.php">Dashboard</a></li>
        <li><i class="fa-solid fa-chart-pie-simple"></i><a href="admincustomer.php">Clients</a></li>
        <li><i class="fa-solid fa-chart-pie-simple"></i><a href="#">Help</a></li>
        <li><i class="fa-solid fa-chart-pie-simple"></i><a href="#">Settings</a></li>
        <li><i class="fa-solid fa-chart-pie-simple"></i><a href="adminlg.php">Log Out</a></li>

      </div>
    </section>

    
    <section id="interface" class="col">
      <div class="navigation" style="padding: 25px 0;">

        <div class="n1">
          <div>
            <img id="menu-btn" src="images/menuicon1.png" alt="" style="width: 30px; margin-left: 30px;">
          </div>
          <div id="searchForm">
            <form action="adminindex.php" method="POST">
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
      </div>

      <h3 class="i-name">
        Dashboard
      </h3>

      <div class="values">
        <div class="val-box">
          <img src="images/users.png" alt="">
          <div>
            <h3><?php
                include 'dbconnect.php';
                $qq = "Select count(userid) from registration";
                $res = mysqli_query($con, $qq);
                while ($row = mysqli_fetch_assoc($res)) {
                  echo $row['count(userid)'];
                }
                ?></h3>
            <span>Total users</span>
          </div>
        </div>

        <div class="val-box">
          <img src="images/aad1.png" alt="">
          <div>
            <h3><?php
                include 'dbconnect.php';
                $qq = "Select count(ad_id) from ads";
                $res = mysqli_query($con, $qq);
                while ($row = mysqli_fetch_assoc($res)) {
                  echo $row['count(ad_id)'];
                }
                ?></h3>
            <span>Total ads</span>
          </div>
        </div>

        <div class="val-box">
          <img src="images/tk.png" alt="">
          <div>
            <h3><?php
                include 'dbconnect.php';
                $qq = "Select sum(amount) from payment";
                $res = mysqli_query($con, $qq);
                while ($row = mysqli_fetch_assoc($res)) {
                  echo $row['sum(amount)'];
                }
                ?></h3>
            <span>Total income</span>
          </div>
        </div>
      </div>

      <div class="board">
        <table width="100%">
          <thead>
            <tr>
              <td>Ads</td>
              <td>Mobile</td>
              <td>Income Details</td>
              <td></td>
              <td></td>
            </tr>
          </thead>
          <tbody>

            <?php
            if (isset($_POST['searchInAllAds'])) {
              $stext = $_POST['searchText'];

              if (strlen($stext) > 0 && isset($_POST['category']) && isset($_POST['location'])) {

                include 'dbconnect.php';

                $squery = "Select * from payment order by tran_date desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($rowpayment = mysqli_fetch_assoc($res)) {
                    $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                    $resregis = mysqli_query($con, $squeryfromregister);
                    $resregischeck = mysqli_num_rows($resregis);
                    if ($resregischeck > 0) {
                      while ($rowregis = mysqli_fetch_assoc($resregis)) {
                        $a = $_POST['category'];
                        $b = $_POST['location'];
                        $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'] . " and cat='$a' and loc='$b' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";
                        $resads = mysqli_query($con, $ssq);
                        $resadscheck = mysqli_num_rows($resads);
                        if ($resadscheck > 0) {
                          while ($rowads = mysqli_fetch_assoc($resads)) {
                            echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                          }
                        }
                      }
                    }
                  }
                }
              } else if (strlen($stext) > 0 && isset($_POST['category'])) {
                include 'dbconnect.php';

                $squery = "Select * from payment order by tran_date desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($rowpayment = mysqli_fetch_assoc($res)) {
                    $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                    $resregis = mysqli_query($con, $squeryfromregister);
                    $resregischeck = mysqli_num_rows($resregis);
                    if ($resregischeck > 0) {
                      while ($rowregis = mysqli_fetch_assoc($resregis)) {
                        $a = $_POST['category'];
                        $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'] . " and cat='$a' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";
                        $resads = mysqli_query($con, $ssq);
                        $resadscheck = mysqli_num_rows($resads);
                        if ($resadscheck > 0) {
                          while ($rowads = mysqli_fetch_assoc($resads)) {
                            echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                          }
                        }
                      }
                    }
                  }
                }
              } else if (strlen($stext) > 0 && isset($_POST['location'])) {
                include 'dbconnect.php';

                $squery = "Select * from payment order by tran_date desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($rowpayment = mysqli_fetch_assoc($res)) {
                    $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                    $resregis = mysqli_query($con, $squeryfromregister);
                    $resregischeck = mysqli_num_rows($resregis);
                    if ($resregischeck > 0) {
                      while ($rowregis = mysqli_fetch_assoc($resregis)) {
                        $b = $_POST['location'];
                        $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'] . " and loc='$b' and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";
                        $resads = mysqli_query($con, $ssq);
                        $resadscheck = mysqli_num_rows($resads);
                        if ($resadscheck > 0) {
                          while ($rowads = mysqli_fetch_assoc($resads)) {
                            echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                          }
                        }
                      }
                    }
                  }
                }
              } else if (strlen($stext) > 0) {
                include 'dbconnect.php';

                $squery = "Select * from payment order by tran_date desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($rowpayment = mysqli_fetch_assoc($res)) {
                    $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                    $resregis = mysqli_query($con, $squeryfromregister);
                    $resregischeck = mysqli_num_rows($resregis);
                    if ($resregischeck > 0) {
                      while ($rowregis = mysqli_fetch_assoc($resregis)) {

                        $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'] . " and (cat LIKE '%" . $stext . "%' OR loc LIKE '%" . $stext . "%' OR title LIKE '%" . $stext . "%' OR con LIKE '%" . $stext . "%' OR aut LIKE '%" . $stext . "%' OR feature LIKE '%" . $stext . "%' OR des LIKE '%" . $stext . "%' OR price LIKE '%" . $stext . "%' OR isnego LIKE '%" . $stext . "%' OR endDate LIKE '%" . $stext . "%' OR phone LIKE '%" . $stext . "%' OR postDate LIKE '%" . $stext . "%')  order by postDate desc";
                        $resads = mysqli_query($con, $ssq);
                        $resadscheck = mysqli_num_rows($resads);
                        if ($resadscheck > 0) {
                          while ($rowads = mysqli_fetch_assoc($resads)) {
                            echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                          }
                        }
                      }
                    }
                  }
                }
              } else if (isset($_POST['category']) && isset($_POST['location'])) {
                include 'dbconnect.php';

                $squery = "Select * from payment order by tran_date desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($rowpayment = mysqli_fetch_assoc($res)) {
                    $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                    $resregis = mysqli_query($con, $squeryfromregister);
                    $resregischeck = mysqli_num_rows($resregis);
                    if ($resregischeck > 0) {
                      while ($rowregis = mysqli_fetch_assoc($resregis)) {
                        $a = $_POST['category'];
                        $b = $_POST['location'];
                        $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'] . " and cat='$a' and loc='$b' order by postDate desc";
                        $resads = mysqli_query($con, $ssq);
                        $resadscheck = mysqli_num_rows($resads);
                        if ($resadscheck > 0) {
                          while ($rowads = mysqli_fetch_assoc($resads)) {
                            echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                          }
                        }
                      }
                    }
                  }
                }
              } else if (isset($_POST['category'])) {
                include 'dbconnect.php';

                $squery = "Select * from payment order by tran_date desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($rowpayment = mysqli_fetch_assoc($res)) {
                    $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                    $resregis = mysqli_query($con, $squeryfromregister);
                    $resregischeck = mysqli_num_rows($resregis);
                    if ($resregischeck > 0) {
                      while ($rowregis = mysqli_fetch_assoc($resregis)) {
                        $a = $_POST['category'];
                        $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'] . " and cat='$a' order by postDate desc";
                        $resads = mysqli_query($con, $ssq);
                        $resadscheck = mysqli_num_rows($resads);
                        if ($resadscheck > 0) {
                          while ($rowads = mysqli_fetch_assoc($resads)) {
                            echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                          }
                        }
                      }
                    }
                  }
                }
              } else if (isset($_POST['location'])) {
                include 'dbconnect.php';

                $squery = "Select * from payment order by tran_date desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($rowpayment = mysqli_fetch_assoc($res)) {
                    $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                    $resregis = mysqli_query($con, $squeryfromregister);
                    $resregischeck = mysqli_num_rows($resregis);
                    if ($resregischeck > 0) {
                      while ($rowregis = mysqli_fetch_assoc($resregis)) {
                        $b = $_POST['location'];
                        $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'] . " and loc='$b' order by postDate desc";
                        $resads = mysqli_query($con, $ssq);
                        $resadscheck = mysqli_num_rows($resads);
                        if ($resadscheck > 0) {
                          while ($rowads = mysqli_fetch_assoc($resads)) {
                            echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                          }
                        }
                      }
                    }
                  }
                }
              }
            } else {
              include 'dbconnect.php';

              $squery = "Select * from payment order by tran_date desc";

              $res = mysqli_query($con, $squery);
              $rescheck = mysqli_num_rows($res);
              if ($rescheck > 0) {
                while ($rowpayment = mysqli_fetch_assoc($res)) {
                  $squeryfromregister = "Select * from registration where userid=" . $rowpayment['user_id'];
                  $resregis = mysqli_query($con, $squeryfromregister);
                  $resregischeck = mysqli_num_rows($resregis);
                  if ($resregischeck > 0) {
                    while ($rowregis = mysqli_fetch_assoc($resregis)) {
                      $ssq = "Select * from ads where ad_id=" . $rowpayment['ad_id'];
                      $resads = mysqli_query($con, $ssq);
                      $resadscheck = mysqli_num_rows($resads);
                      if ($resadscheck > 0) {
                        while ($rowads = mysqli_fetch_assoc($resads)) {
                          echo "<tr>
                        <td class='ads'>
                          <img src='" . $rowads['img1'] . "' alt='ad img'>
                          <div class='ads-de'>
                            <h5><span>" . $rowads['title'] . "</span>&nbsp;&nbsp;<span>৳" . $rowads['price'] . "</span></h5>
                            <p><span>" . $rowads['cat'] . "</span>&nbsp;&nbsp;<span>" . $rowads['loc'] . "</span></p>
                            <p><span>" . $rowads['con'] . "</span>&nbsp;&nbsp;<span>" . $rowads['aut'] . "</span></p>
                            <p>Posted by: " . $rowregis['username'] . "</p>
                            <p>Email: " . $rowregis['email'] . "</p>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $rowads['phone'] . "</h5>
                          <p>Posted on: " . $rowads['postDate'] . "</p>
                          <p>Posted till: " . $rowads['endDate'] . "</< /p>
                        </td>
          
                        <td class='income-details'>
                          <h5>৳" . $rowpayment['amount'] . "</h5>
                          <p>Tran id: " . $rowpayment['tran_id'] . "</p>
                          <p>Bank Tran id: " . $rowpayment['bank_tran_id'] . "</p>
                          <p>Card type: " . $rowpayment['card_type'] . "</p>
                        </td>
          
                        <td>
                          <form action='tmpadmin.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "' type='submit' class='btn view-pro'>VIEW</button>
                          </form>
                        </td>
          
                        <td>
                          <form action='admindeleteads.php' method='POST'>
                            <button name='" . $rowads['ad_id'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                        }
                      }
                    }
                  }
                }
              }
            }
            ?>

          </tbody>
        </table>
      </div>
    </section>

    <script>
      $('#menu-btn').click(function() {
        $('#menu').toggleClass("active");
      })
    </script>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>