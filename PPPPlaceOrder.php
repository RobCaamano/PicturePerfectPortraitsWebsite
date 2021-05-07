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
			<a class="active" href="PPPPlaceOrder.php">Place A Client’s Order</a>
			<a href="PPPUpdateOrder.php">Update A Client’s Order</a>
			<a href="PPPCancelAppointment.php">Cancel A Client’s Appointment</a>
			<a href="PPPCancelOrder.php">Cancel A Client’s Order</a>
			<a href="PPPCreateAccount.php">Create A New Client Account </a>
		</div>

        <form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  			<label for="cfName">Client First Name:</label><br>
  			<input type="text" id="cfName" name="cfName"><br>

  			<label for="clName">Client Last Name:</label><br>
  			<input type="text" id="clName" name="clName"><br>

			<label for="clientid">Client ID Number:</label><br>
  			<input type="text" id="clientid" name="clientid"><br>

			<label for="appid">Client Appointment ID:</label><br>
  			<input type="text" id="appid" name="appid"><br>

			<label for="orderType">Type of Order:</label><br>
  			<input type="text" id="orderType" name="orderType"><br>

			<label for="address">Shipping Address:</label><br>
  			<input type="text" id="address" name="address"><br>

			<input type="submit" value="submit">
			<input type="reset" value="reset">
		</form>

        <?php
			// CONNECT
			ini_set('display_errors', 1);

			$conn = mysqli_connect ("sql1.njit.edu", "rc553", "LouroMuros2.", "rc553");
			if (mysqli_connect_errno()){
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

            // POST
			$fname = $lname = $clientid = $appid = $orderType = $address = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $fname=$_POST["cfName"];
                $lname=$_POST["clName"];
                $clientid=$_POST["clientid"];
                $appid=$_POST["appid"];
				$orderType=$_POST["orderType"];
                $address=$_POST["address"];

				$photoid = $_SESSION["id"];

				$rand = rand(100000, 999999);

                // Check if appointment exists
                $queryString = "SELECT * FROM PPPAppointments WHERE fname='$fname' AND lname='$lname' AND id='$clientid'";
                $result = mysqli_query($conn, $queryString);

				if($result->num_rows){
					$insert = "INSERT INTO PPPOrders (orderType, shippingAddress, orderNumber, photographerID, clientID, appointmentID) VALUES ('$orderType', '$address', '$rand', '$photoid', '$clientid', '$appid')";
					mysqli_query($conn, $insert);
					echo '<script>alert("Order Booked!")</script>';
				}
				// Wrong client data
                else{
                    echo 
						'<script>
							var c = confirm("Did you book an appointment first?");
							if(c!=true)
								window.location.href = "PPPAppointment.php";
						</script>';
                }

            }
        ?>

	</body>
</html>

						