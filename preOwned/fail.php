<?php

include 'dbconnect.php';
$q = "Delete from ads where ad_no='".$_COOKIE["adId"]."'";
$res = mysqli_query($con, $q);

include 'allads.php';

?>
