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
session_start();
include 'dbconnect.php';
$qq = "Select * from payment";
$resqq = mysqli_query($con, $qq);
$resqqcheck = mysqli_num_rows($resqq);
if ($resqqcheck > 0) {
  while ($rowqq = mysqli_fetch_assoc($resqq)) {
    if (isset($_POST[$rowqq['ad_id']])) {
      require_once('tcpdf/tcpdf.php');
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
      $obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $obj_pdf->SetDefaultMonospacedFont('helvetica');
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
      $obj_pdf->setPrintHeader(false);
      $obj_pdf->setPrintFooter(false);
      $obj_pdf->SetAutoPageBreak(TRUE, 10);
      $obj_pdf->SetFont('helvetica', '', 12);
      $obj_pdf->AddPage();
      $content = '';
      $content .= '  
      <div
      
    >
      <br>
      <br>
      <br>
      <h2 style="display: inline-block; margin-left: 10px;">pre<span style="color: green;">Owned</span></h2>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <h1 style="color: #ff9f29; font-size: 30px; display: inline-block; padding-top: 200px;  float: right;">RECEIPT</h1>

      <hr style="border: 2px solid #ff5f00;
      border: 2px 0px 0px 0px;
      margin: auto;
      margin: 20px 0;">
      <h3>Payment Information</h3>
      <br>
      <br>
      <hr>
      <br>
      <br>
      <br>
      <br>
      <h4>Transaction ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowqq['tran_id'].'</h4>
      <br>
      <h4>Amount&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowqq['amount'].'</h4>
      <br>
      <h4>Bank Transaction Id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowqq['bank_tran_id'].'</h4>
      <br>
      <h4>Card Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowqq['card_type'].'</h4> 
      <br>
      <h4>Transaction Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowqq['tran_date'].'" </h4>
      <br>
      <hr>
      <h2 style="color: #ff9f29;">Payment Received&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rowqq['amount'].' Tk</h2> 

      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <div style="padding-left: 600px;">
      <h6>Payment received by</h6>
      <h2 style="display: inline-block; margin-left: 10px;">pre<span style="color: green;">Owned</span></h2>

      </div>
    </div>
    </div>  
      ';
      ob_end_clean();
      $obj_pdf->writeHTML($content);
      $obj_pdf->Output('receipt.pdf', 'D');
    }
  }
}
?>