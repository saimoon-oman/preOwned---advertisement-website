<?php
session_start();
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
include 'adminindex.php';
?>
