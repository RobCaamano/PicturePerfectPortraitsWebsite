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
			<a href="PPPUpdateOrder.php">Update A Client’s Order</a>
			<a class="active" href="PPPCancelAppointment.php">Cancel A Client’s Appointment</a>
			<a href="PPPCancelOrder.php">Cancel A Client’s Order</a>
			<a href="PPPCreateAccount.php">Create A New Client Account </a>
		</div>

        <form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  			<label for="cid">Client ID Number:</label><br>
  			<input type="text" id="cid" name="cid"><br>

  			<label for="cAppID">Client Appointment ID:</label><br>
  			<input type="text" id="cAppID" name="cAppID"><br>

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

            // POST filled info
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cid'],$_POST['cAppID'])) {
                $clientid=$_POST["cid"];
				$cAppID=$_POST["cAppID"];

				// Make form global for later use
				if(isset($_POST['cid'],$_POST['cAppID'])){
					$_SESSION["cid2"]=$clientid;
					$_SESSION["cAppID2"]=$cAppID;
				}

                // Check if client exists
                $queryString = "SELECT * FROM PPPAppointments WHERE id='$clientid' AND appointmentID='$cAppID'";
                $result = mysqli_query($conn, $queryString);

				if($result->num_rows){		
					echo
					'<script>
							var c = confirm("Are you sure you want to cancel your appointment?");
							document.getElementById("inputBoolean").value = c;
							document.getElementById("hideForm").submit();
						</script>';
				}
                else{
                    echo '<script>alert("Either Appointment ID or Client ID do not exist.")</script>';
					
                }

            }
			// POST hidden value
			if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inputBoolean'])){
				$confirmVar=$_POST["inputBoolean"];

				$clientid=$_SESSION["cid2"];
				$cAppID=$_SESSION["cAppID2"];

				if(strcmp($confirmVar, 'true') == 0){
					$delete = "DELETE FROM PPPAppointments WHERE id='$clientid' AND appointmentID='$cAppID'";
                    mysqli_query($conn, $delete);
					echo '<script>alert("Appointment Cancelled!")</script>';
				}
			}
        ?>

	</body>
</html>