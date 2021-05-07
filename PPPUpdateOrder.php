<?php
	session_start();
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<title> Picture Perfect Portraits </title>
		<meta charset = "utf-8" />
	</head>
	<body>
		<style>
			body {
 				background-image: url('tree.jpg');
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-size: cover;
			}

			.topnav {
				background-color: #333;
				overflow: hidden;
			}

			.topnav a {
				float: left;
				color: #f2f2f2;
				text-align: center;
				padding: 10px 12px;
				text-decoration: none;
				font-size: 14px;
			}

			.topnav a:hover {
				background-color: #ddd;
				color: black;
			}

			.topnav a.active {
				background-color: #0C35CE;
				color: white;
			}

		</style>

		<div class="topnav">
			<a href="PPPHome.php">Home</a>
			<a href="PPPRecords.php">Search A Photographer's Records</a>
			<a href="PPPAppointment.php">Book a Client’s Appointment</a>
			<a href="PPPPlaceOrder.php">Place A Client’s Order</a>
			<a class="active" href="PPPUpdateOrder.php">Update A Client’s Order</a>
			<a href="PPPCancelAppointment.php">Cancel A Client’s Appointment</a>
			<a href="PPPCancelOrder.php">Cancel A Client’s Order</a>
			<a href="PPPCreateAccount.php">Create A New Client Account </a>
		</div>

		<form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  			<label for="cID">Client ID Number:</label><br>
  			<input type="text" id="cID" name="cID"><br>

  			<label for="cOrderNum">Client Order Number:</label><br>
  			<input type="text" id="cOrderNum" name="cOrderNum"><br>

			<label for="upOrder">Updated Order:</label><br>
  			<input type="text" id="upOrder" name="upOrder"><br>

			<input type="submit" value="submit">
			<input type="reset" value="reset">
		</form>

		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="hideForm">
        	<input type="hidden" id="inputBoolean" name="inputBoolean">
		</form>
		
		<?php
			// CONNECT
			ini_set('display_errors', 1);

			$conn = mysqli_connect ("sql1.njit.edu", "rc553", "LouroMuros2.", "rc553");
			if (mysqli_connect_errno()){
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

            // POST filled in info
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cID'],$_POST['cOrderNum'],$_POST['upOrder'])) {
                $clientid=$_POST["cID"];
				$cOrderNum=$_POST["cOrderNum"];
                $upOrder=$_POST["upOrder"];

				// Make form global for later use
				if(isset($_POST['cID'],$_POST['cOrderNum'],$_POST['upOrder'])){
					$_SESSION["cID"]=$clientid;
					$_SESSION["cOrderNum"]=$cOrderNum;
					$_SESSION["upOrder"]=$upOrder;
				}

                // Check if order exists
                $queryString = "SELECT * FROM PPPOrders WHERE clientID='$clientid' AND orderNumber='$cOrderNum'";
                $result = mysqli_query($conn, $queryString);

				if($result->num_rows){
					echo 
						'<script>
							var c = confirm("Are you sure you want to update your order?");
							document.getElementById("inputBoolean").value = c;
							document.getElementById("hideForm").submit();
						</script>';
				}
                else{
                    echo '<script>alert("Order Number does not exist. Please check the order number entered or that the order was placed by searching the photographers records.")</script>';
                }
            }
			// POST hidden value
			if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inputBoolean'])){
				$confirmVar=$_POST["inputBoolean"];

				$clientid=$_SESSION["cID"];
				$cOrderNum=$_SESSION["cOrderNum"];
                $upOrder=$_SESSION["upOrder"];

				if(strcmp($confirmVar, 'true') == 0){
					$update = "UPDATE PPPOrders SET orderType='$upOrder' WHERE clientID='$clientid' AND orderNumber='$cOrderNum'";
					mysqli_query($conn, $update);
					echo '<script>alert("Order Updated!")</script>';
				}
			}
        ?>
	</body>
</html>