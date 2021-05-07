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
			<a class="active" href="PPPAppointment.php">Book a Client’s Appointment</a>
			<a href="PPPPlaceOrder.php">Place A Client’s Order</a>
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

			<label for="eventType">Event Type:</label><br>
  			<input type="text" id="eventType" name="eventType"><br>

			<label for="venue">Venue:</label><br>
  			<input type="text" id="venue" name="venue"><br>

			  <label for="dateNTime">Date and Time:</label><br>
  			<input type="text" id="dateNTime" name="dateNTime"><br>

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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $cfname=$_POST["cfName"];
                $clname=$_POST["clName"];
                $clientid=$_POST["clientid"];
				$eventType=$_POST["eventType"];
				$venue=$_POST["venue"];
                $dateNTime=$_POST["dateNTime"];
				
                $rand = rand(100000, 999999);

                // Check if client exists
                $queryString = "SELECT * FROM PPPClients WHERE fname='$cfname' AND lname='$clname' AND id='$clientid'";
                $result = mysqli_query($conn, $queryString);

				if($result->num_rows){
                    $strict = "SET sql_mode = ''";
  					mysqli_query($conn, $strict);
					
					$insert = "INSERT INTO PPPAppointments (fname, lname, id, eventType, venue, dateNTime, appointmentID) VALUES ('$cfname', '$clname', '$clientid', '$eventType', '$venue', '$dateNTime', '$rand')";
                    mysqli_query($conn, $insert);
					echo '<script>alert("Appointment Booked!")</script>';
				}
                else{
                    echo '<script>alert("Please create an account first")</script>';
					
                }

            }
        ?>

	</body>
</html>