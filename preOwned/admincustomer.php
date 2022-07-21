<?php
session_start();
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
<?php
include 'dbconnect.php';
$qq = "Select * from registration";
$resqq = mysqli_query($con, $qq);
$resqqcheck = mysqli_num_rows($resqq);
if ($resqqcheck > 0) {
  while ($rowqq = mysqli_fetch_assoc($resqq)) {
    if (isset($_POST[($rowqq['userid']) . "d"])) {
      $squeryfromregister = "delete from registration where userid=" . $rowqq['userid'];
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
        if (isset($_SESSION["adminusername"])) {
          echo "<li><i class='fa-solid fa-chart-pie-simple'></i><a href='#'>" . $_SESSION["adminusername"] . "</a></li>";
        } else echo "<li><i class='fa-solid fa-chart-pie-simple'></i><a href='#'>Saimoon</a></li>";
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
            <form action="admincustomer.php" method="POST">
              <input type="text" name="searchText" id="searchText" size="30" placeholder="Search on clinets" />


              <input class="btn button1" name="searchInAllAds" type="submit" value="Search" />
            </form>
          </div>
        </div>
      </div>

      <h3 class="i-name">
        Clients
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
              <td>Clients Id</td>
              <td>Clients Name</td>
              <td>Email</td>
              <td></td>
            </tr>
          </thead>
          <tbody>

            <?php
            if (isset($_POST['searchInAllAds'])) {
              $stext = $_POST['searchText'];

              if (strlen($stext) > 0) {
                include 'dbconnect.php';

                $squery = "Select * from registration where (userid like '%".$stext."%' or username like '%".$stext."%' or email like '%".$stext."%') order by userid desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($row = mysqli_fetch_assoc($res)) {

                    echo "<tr>
                        <td class='ads'>
                          <div class='ads-de'>
                            <h5><span>" . $row['userid'] . "</h5>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $row['username'] . "</h5>
                        </td>
          
                        <td class='income-details'>
                          <h5>" . $row['email'] . "</h5>
                        </td>
          
                        <td>
                          <form action='admincustomer.php' method='POST'>
                            <button name='" . $row['userid'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                  }
                }
              } else {
                include 'dbconnect.php';

                $squery = "Select * from registration order by userid desc";

                $res = mysqli_query($con, $squery);
                $rescheck = mysqli_num_rows($res);
                if ($rescheck > 0) {
                  while ($row = mysqli_fetch_assoc($res)) {

                    echo "<tr>
                        <td class='ads'>
                          <div class='ads-de'>
                            <h5><span>" . $row['userid'] . "</h5>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $row['username'] . "</h5>
                        </td>
          
                        <td class='income-details'>
                          <h5>" . $row['email'] . "</h5>
                        </td>
          
                        <td>
                          <form action='admincustomer.php' method='POST'>
                            <button name='" . $row['userid'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
                  }
                }
              }
            } else {
              include 'dbconnect.php';

              $squery = "Select * from registration order by userid desc";

              $res = mysqli_query($con, $squery);
              $rescheck = mysqli_num_rows($res);
              if ($rescheck > 0) {
                while ($row = mysqli_fetch_assoc($res)) {

                  echo "<tr>
                        <td class='ads'>
                          <div class='ads-de'>
                            <h5><span>" . $row['userid'] . "</h5>
                          </div>
                        </td>
          
                        <td class='mobile'>
                          <h5>" . $row['username'] . "</h5>
                        </td>
          
                        <td class='income-details'>
                          <h5>" . $row['email'] . "</h5>
                        </td>
          
                        <td>
                          <form action='admincustomer.php' method='POST'>
                            <button name='" . $row['userid'] . "d' type='submit' class='btn view-pro'>DELETE</button>
                          </form>
                        </td>
                      </tr>";
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