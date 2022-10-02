
<!DOCTYPE html>
<html lang="en">

<?php
include '../connect.php';
$conn = OpenCon();
session_start();

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
</head>


<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-SAP py-5 sticky-top">
    <form class="container-fluid justify-content-start">
        <button class="btn btn-SAP fs-4 me-5 ms-5" type="submit" formaction="table_booking.php">Make A Booking</button>

        <?php
        $result = $conn->query("SELECT UserType FROM User WHERE (User.UID='{$_SESSION['userid']}')");
        $userType = $result->fetch_array()[0];
        if ($userType == 'Admin') {
            echo "<button class='btn btn-SAP fs-4 me-5' type='button' formaction='arrange.php'>Arrange The Office</button>
                        <button class='btn btn-SAP fs-4 me-5' type='button' formaction='report.php'>Generate A Report</button>";
        }
        ?>
    </form>

    <a href="#" title=""><img src="../startbootstrap-bare-master/dist/assets/profile_image.png" class="img-responsive me-5"></a>


</nav>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Find a Testing Centre</h4>
            <p> Use the filters to find a  BC testing centre best suited to your needs.</p>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form" action="test_booking_filter.php" method="post">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="city-column">City</label>
                                <p> Select your preferred city </p>
                                <select class="choices form-select" name="city">
                                    <option value=""> All</option>
                                    <?php
                                    $sql = "SELECT DISTINCT city FROM Testing_Center";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) {

                                            echo "<option value=".$row["city"];
                                            if(isset($_GET['Vcity'])) {
                                                if($_GET['Vcity'] == $row["city"]){
                                                    echo " selected='selected'";
                                                }
                                            }
                                            echo ">".$row["city"]."</option>";
//
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="vaccine-column">Testing Method</label>
                                <p> Select all your preferred testing methods </p>
                                <select class="choices form-select" name="vkinds">
                                    <option value=""> All</option>
                                    <?php
                                    $sql = "SELECT kind FROM Testing_Kit";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while($row = $result->fetch_assoc()) {
                                            $k = str_replace(' ', '_', $row["kind"]);
                                            echo "<option value=".$k;
                                            if(isset($Vkinds)) {
                                                $Vkinds = str_replace("_", " ", $_GET['Vkinds']);
                                                if($Vkinds == $row["kind"]){
                                                    echo " selected='selected'";
                                                }
                                            }
                                            echo ">".$row["kind"]."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox5"
                                       class='form-check-input' name="allkits" value="division"
                                    <?php
                                    if (!empty($_GET['Division'])) {       //columns selected
                                        echo "checked";
                                    }
                                    ?>
                                >
                                <label for="checkbox5"> Show Testing Centres that have All Kits in Stock</label>
                            </div>
                        </div>
                        <!--								   <div class="col-md-6 col-12">-->
                        <!--									<div class="checkbox">-->
                        <!--									    <input type="checkbox" id="checkbox5"-->
                        <!--										   class='form-check-input' unchecked>-->
                        <!--									    <label for="checkbox5"> Open Now</label>-->
                        <!--									</div>-->
                        <!--								  </div>-->
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit"
                                    class="btn btn-primary me-1 mb-1"
                                    formaction="testing_centres_filter.php" name="submit">
                                Submit</button>
                            <!--                                        <button type="reset"-->
                            <!--                                                class="btn btn-light-secondary me-1 mb-1" formaction="vaccine_centres_filter.php" name="reset">-->
                            <!--                                            Reset</button>-->
                        </div>
                    </div>
                    <br>
                    <table class="table table-striped" id="table1">
                        <tr>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Opening Time</th>
                            <th>Closing Time</th>
                        </tr>
                        <?php
                        $result = '';
                        if (isset($_GET['Division']) && ($_GET['Division'] == "division")){

                            $sql_division = "SELECT * FROM Testing_Center AS tc Where 
                                                NOT EXISTS 
                                                ((SELECT tk.kind FROM Testing_Kit AS tk) 
                                                EXCEPT 
                                                (SELECT it.kind FROM Inventory_Of_Tests AS it where tc.facility_ID = it.facility_ID))";
                            $result = mysqli_query($conn, $sql_division);
                        } else {
                            if (isset($_GET['Vkinds'])) {
                                $vkind = str_replace("_"," ",$_GET['Vkinds']);
                                $sql_join = "CREATE VIEW tc_it_join AS
                                                                        SELECT tc.facility_ID, tc.phone, tc.address, tc.opening_time, tc.closing_time, tc.drivethru, tc.city,
                                                                                it.kind
                                                                        FROM Testing_Center AS tc
                                                                        JOIN Inventory_Of_Tests AS it
                                                                        ON tc.facility_ID = it.facility_ID";

                                $result = mysqli_query($conn, $sql_join);
                                if ($result ==0) {
                                    //echo "join unseccessful";
                                }

                                if (isset($_GET['Vcity'])){       //city is selected
                                    $vcity = $_GET['Vcity'];
                                    $sql = " SELECT * FROM tc_it_join Where city like '$vcity' AND kind like '$vkind'";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $sql = "SELECT * FROM tc_it_join Where kind like '$vkind'";
                                    $result = $conn->query($sql);
                                }
                            } else{

                                if (isset($_GET['Vcity'])){
                                    $vcity = $_GET['Vcity'];
                                    $sql = "SELECT * FROM Testing_Center Where city like '$vcity'";
                                    $result = $conn->query($sql);
//                                                var_dump($result);
                                } else {
                                    $sql = "SELECT * FROM Testing_Center";
                                    $result = $conn->query($sql);
                                }
                            }
                        }

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td class='border-class'>" . $row["address"] .
                                    "</td><td class='border-class'>" . $row["phone"] .
                                    "</td><td class='border-class'>" . $row["city"] .
                                    "</td><td class='border-class'>" . $row["opening_time"] .
                                    "</td><td class='border-class'>" . $row["closing_time"] .
                                    "</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "0 results";
                        }

                        CloseCon($conn);
                        ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</section>

</body>


<body>
    <div id="app">
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>BC Covid-19 Testing Centres</h3>
            </div>
		  <section id="multiple-column-form">
			<div class="row match-height">
			    <div class="col-12">
				   <div class="card">
					  <div class="card-header">
						 <h4 class="card-title">Find a Testing Centre</h4>
						 <p> Use the filters to find a  BC testing centre best suited to your needs.</p>
					  </div>
					  <div class="card-content">
						 <div class="card-body">
							<form class="form" action="test_booking_filter.php" method="post">
							    <div class="row">
								   <div class="col-md-6 col-12">
									<div class="form-group">
									    <label for="city-column">City</label>
                                        <p> Select your preferred city </p>
                                        <select class="choices form-select" name="city">
                                            <option value=""> All</option>
                                            <?php
                                            $sql = "SELECT DISTINCT city FROM Testing_Center";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while($row = $result->fetch_assoc()) {

                                                    echo "<option value=".$row["city"];
                                                    if(isset($_GET['Vcity'])) {
                                                        if($_GET['Vcity'] == $row["city"]){
                                                            echo " selected='selected'";
                                                        }
                                                    }
                                                    echo ">".$row["city"]."</option>";
//
                                                }
                                            }
                                            ?>
                                        </select>
									</div>
								   </div>
                                   <div class="col-md-6 col-12">
												<div class="form-group">
													<label for="vaccine-column">Testing Method</label>
													<p> Select all your preferred testing methods </p>
                                                    <select class="choices form-select" name="vkinds">
                                                        <option value=""> All</option>
                                                        <?php
                                                        $sql = "SELECT kind FROM Testing_Kit";
                                                        $result = $conn->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            // output data of each row
                                                            while($row = $result->fetch_assoc()) {
                                                                $k = str_replace(' ', '_', $row["kind"]);
                                                                echo "<option value=".$k;
                                                                if(isset($Vkinds)) {
                                                                    $Vkinds = str_replace("_", " ", $_GET['Vkinds']);
                                                                    if($Vkinds == $row["kind"]){
                                                                        echo " selected='selected'";
                                                                    }
                                                                }
                                                                echo ">".$row["kind"]."</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
											    </div>
                                    </div>
								   <div class="col-md-6 col-12">
									 <div class="checkbox">
										<input type="checkbox" id="checkbox5"
										    class='form-check-input' name="allkits" value="division"
                                            <?php
                                            if (!empty($_GET['Division'])) {       //columns selected
                                                    echo "checked";
                                            }
                                            ?>
                                        >
										<label for="checkbox5"> Show Testing Centres that have All Kits in Stock</label>
									 </div>
								   </div>
<!--								   <div class="col-md-6 col-12">-->
<!--									<div class="checkbox">-->
<!--									    <input type="checkbox" id="checkbox5"-->
<!--										   class='form-check-input' unchecked>-->
<!--									    <label for="checkbox5"> Open Now</label>-->
<!--									</div>-->
<!--								  </div>-->
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit"
                                                class="btn btn-primary me-1 mb-1"
                                                formaction="testing_centres_filter.php" name="submit">
                                            Submit</button>
<!--                                        <button type="reset"-->
<!--                                                class="btn btn-light-secondary me-1 mb-1" formaction="vaccine_centres_filter.php" name="reset">-->
<!--                                            Reset</button>-->
                                    </div>
							    </div>
                                <br>
							    <table class="table table-striped" id="table1">
								    <tr>
									   <th>Address</th>
									   <th>Phone</th>
									   <th>City</th>
									   <th>Opening Time</th>
									   <th>Closing Time</th>
								    </tr>
								    <?php
                                    $result = '';
                                    if (isset($_GET['Division']) && ($_GET['Division'] == "division")){

                                        $sql_division = "SELECT * FROM Testing_Center AS tc Where 
                                                NOT EXISTS 
                                                ((SELECT tk.kind FROM Testing_Kit AS tk) 
                                                EXCEPT 
                                                (SELECT it.kind FROM Inventory_Of_Tests AS it where tc.facility_ID = it.facility_ID))";
                                        $result = mysqli_query($conn, $sql_division);
                                    } else {
                                        if (isset($_GET['Vkinds'])) {
                                            $vkind = str_replace("_"," ",$_GET['Vkinds']);
                                            $sql_join = "CREATE VIEW tc_it_join AS
                                                                        SELECT tc.facility_ID, tc.phone, tc.address, tc.opening_time, tc.closing_time, tc.drivethru, tc.city,
                                                                                it.kind
                                                                        FROM Testing_Center AS tc
                                                                        JOIN Inventory_Of_Tests AS it
                                                                        ON tc.facility_ID = it.facility_ID";

                                            $result = mysqli_query($conn, $sql_join);
                                            if ($result ==0) {
                                                //echo "join unseccessful";
                                            }

                                            if (isset($_GET['Vcity'])){       //city is selected
                                                $vcity = $_GET['Vcity'];
                                                $sql = " SELECT * FROM tc_it_join Where city like '$vcity' AND kind like '$vkind'";
                                                $result = mysqli_query($conn, $sql);
                                            } else {
                                                    $sql = "SELECT * FROM tc_it_join Where kind like '$vkind'";
                                                    $result = $conn->query($sql);
                                                    }
                                            } else{

                                            if (isset($_GET['Vcity'])){
                                                $vcity = $_GET['Vcity'];
                                                $sql = "SELECT * FROM Testing_Center Where city like '$vcity'";
                                                $result = $conn->query($sql);
//                                                var_dump($result);
                                            } else {
                                                $sql = "SELECT * FROM Testing_Center";
                                                $result = $conn->query($sql);
                                            }
                                        }
                                    }

                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr><td class='border-class'>" . $row["address"] .
                                                "</td><td class='border-class'>" . $row["phone"] .
                                                "</td><td class='border-class'>" . $row["city"] .
                                                "</td><td class='border-class'>" . $row["opening_time"] .
                                                "</td><td class='border-class'>" . $row["closing_time"] .
                                                "</td></tr>";
                                        }
                                        echo "</table>";
                                    } else {
                                        echo "0 results";
                                    }

								   CloseCon($conn);
								    ?>
								</tbody>
							 </table>
							</form>
						 </div>
					  </div>
				   </div>
			    </div>
			</div>
				   
			    </div>
			</div>

		 </section>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets~/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="../assets/choices.min.js"></script>	
    
</body>

</html>