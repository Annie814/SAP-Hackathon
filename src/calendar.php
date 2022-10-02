<!DOCTYPE html>
<html lang="en">

<?php
include 'connect.php';
$conn = OpenCon();

session_start();
// for single page testing
if (!isset($_SESSION['userid'])) {
    $_SESSION['userid'] = 80001;
}
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Calendar</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../startbootstrap-bare-master/dist/assets/SAPlogo.png" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../startbootstrap-bare-master/dist/css/styles.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="../lib/jquery/jquery.min.js"></script>
    <!-- datetimepicker -->
    <script src="../lib/bootstrap-date-time-picker/bootstrap5/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../lib/bootstrap-date-time-picker/bootstrap5/js/bootstrap-datetimepicker.css" />


</head>
<body>
     <nav class="navbar navbar-expand-lg navbar-dark bg-SAP py-5 sticky-top">
        <form class="container-fluid justify-content-start">
           <button class="btn btn-SAP fs-4 me-5 ms-5" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Make A Booking</button>

            <!-- The Modal -->
<!-- Modal -->
<div class="modal fade backdrop" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make A Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form_control form_datetime" />
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Check Available Tables</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
$(function(){
  $(".form_datetime").datetimepicker({
    formatViewType:'date';
  });

  $('#datetimepicker').datetimepicker();


});

</script> 
            <?php
            $result = $conn->query("SELECT UserType FROM User WHERE (User.UID='{$_SESSION['userid']}')");
            $userType = $result->fetch_array()[0];
            if ($userType == 'Admin') {
                echo "<button class='btn btn-SAP fs-4 me-5' type='button' formaction='arrange.php'>Arrange The Office</button>
                        <button class='btn btn-SAP fs-4 me-5' type='button' formaction='report.php'>Generate A Report</button>";
            }
            ?>
            </form>

        <a href="calendar.php" title=""><img src="../startbootstrap-bare-master/dist/assets/profile_image.png" class="img-responsive me-5"></a>
          

    </nav>

     <section class="section">
         <div class="card">
             <div class="card-header">
                 <h4><b>Your Bookings</b></h4>
             </div>
             <div class="card-body">
                 <table class="table table-striped" id="table1">
                     <thead>
                     <tr>
                         <th>Table Location</th>
                         <th>Standing Desk</th>
                         <th>Number of Monitors</th>
                         <th>VR setup</th>
                         <th>From</th>
                         <th>To</th>
                         <th>Edit booking</th>
                     </tr>
                     </thead>
                     <tbody>
                     <?php
                     $sql = "SELECT `Calendar`.`UID`, `Calendar`.`TableID`, `Calendar`.`DateStart`,`Calendar`.`DateFinish`, `Table`.`F_updown`, `Table`.`F_monitor`,`Table`.`F_vr_setup`, `Table`.`Floor`,`Table`.`Section`
FROM `Calendar` INNER JOIN `User` ON `User`.`UID` = `Calendar`.`UID` INNER JOIN `Table` ON `Table`.`TableID` = `Calendar`.`TableID`
ORDER BY `Calendar`.DateStart ASC";

                     $results = $conn->query($sql);
                     if ($results->num_rows > 0){
                         while($row = $results->fetch_assoc()){
                             echo "<tr><td class='col-3'><div class='d-flex align-items-center'>
                                                            <p class=' mb-0'>"."Floor ".$row["Floor"].", ". "Section ".$row["Section"].", "."Table ID ".$row["TableID"]."</p>
                                                            </td><td class='col-auto'>
                                                            <p class=' mb-0'>".$row["F_updown"]."</p>
                                                            </div></td><td class='col-auto'>
                                                            <p class=' mb-0'>".$row["F_monitor"]."</p>
                                                            </div></td><td class='col-auto'>
                                                            <p class=' mb-0'>".$row["F_vr_setup"]."</p>
                                                            </td><td class='col-auto'>
                                                            <p class='font-bold ms-3 mb-0'>".$row["DateStart"]."</p>
                                                            </div></td><td class='col-auto'>
                                                            <p class=' mb-0'>".$row["DateFinish"]."</p>
                                                            </td><td class='col-auto'>
                                                            <p class=' mb-0'>".'dummy'."</p>
                                                            </td></tr>";

                         }
                     }
                     ?>
                     </tbody>
                 </table>
             </div>
         </div>

     </section>

</body>
</html>