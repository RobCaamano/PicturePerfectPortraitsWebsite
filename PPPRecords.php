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
			table {
				font-family: "Times New Roman", Times, serif;
				border: 1px solid #FFFFFF;
				width: 1000px;
				height: 200px;
				text-align: center;
				border-collapse: collapse;
			}
			table td, table.paleBlueRows th {
				border: 1px solid #FFFFFF;
				padding: 3px 2px;
			}
			table tbody td {
				font-size: 13px;
			}
			table tr:nth-child(even) {
				background: #D0E4F5;
			}
			table thead {
				background: #0B6FA4;
				border-bottom: 5px solid #FFFFFF;
			}
			table thead th {
				font-size: 17px;
				font-weight: bold;
				color: #FFFFFF;
				text-align: center;
				border-left: 2px solid #FFFFFF;
				}
			tables thead th:first-child {
				border-left: none;
			}

			tables tfoot {
				font-size: 14px;
				font-weight: bold;
				color: #333333;
				background: #D0E4F5;
				border-top: 3px solid #444444;
			}
			table tfoot td {
				font-size: 14px;
			}

		</style>

		<div class="topnav">
			<a class="active" href="PPPHome.php">Home</a>
			<a href="PPPRecords.php">Search A Photographer's Records</a>
			<a href="PPPAppointment.php">Book a Client’s Appointment</a>
			<a href="PPPPlaceOrder.php">Place A Client’s Order</a>
			<a href="PPPUpdateOrder.php">Update A Client’s Order</a>
			<a href="PPPCancelAppointment.php">Cancel A Client’s Appointment</a>
			<a href="PPPCancelOrder.php">Cancel A Client’s Order</a>
			<a href="PPPCreateAccount.php">Create A New Client Account </a>
		</div>	

		<?php
			ini_set('display_errors', 1);

			$conn = mysqli_connect ("sql1.njit.edu", "rc553", "LouroMuros2.", "rc553");
			if (mysqli_connect_errno()){
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

			//if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$pfname=$_SESSION["fName"];
			$plname=$_SESSION["lName"];
			$photoid=$_SESSION["id"];
			
			if(isset($_SESSION['phoneNum'],$_SESSION['email'])){
				$phoneNum=$_SESSION["phoneNum"];
				$email=$_SESSION["email"];
			}

			// Photographer data
			$result = $conn->query("SELECT * FROM PPPPhotographers WHERE fname='$pfname' AND lname='$plname' AND id='$photoid'");
			if(isset($_SESSION['email'])){
				if($email)
					$queryString.= " AND email = '$email'";
			}

			$table_rows = "";

			while($row = mysqli_fetch_array($result)) {
				[$pfname, $plname, $photoid, , $phoneNum, $email] = $row;
				$table_rows .= "<tr><td>$pfname</td><td>$plname</td><td>$photoid</td><td>$phoneNum</td><td>$email</td>";
			}

			// Client Data
			$queryString = "SELECT clientID FROM PPPEvents WHERE photographerID='$photoid'";
			$result = mysqli_query($conn, $queryString);
			if($result){

				$rows = mysqli_fetch_row($result);
				$clientid = $rows[0];

				$queryString2 = "SELECT * FROM PPPClients WHERE id='$clientid'";
				$result = mysqli_query($conn, $queryString2);

				if($result){
					while($row = mysqli_fetch_array($result)) {
						[$cfname, $clname,] = $row;
						$table_rows .= "<td>$cfname</td><td>$clname</td>";
					}
				}
			}

			// Event Data
			$result = $conn->query("SELECT * FROM PPPEvents WHERE photographerID='$photoid'");

			while($row = mysqli_fetch_array($result)) {
				[$eventType, $venue, $dateNTime, , , $appointmentID] = $row;
				$table_rows .= "<td>$eventType</td><td>$venue</td><td>$dateNTime</td><td>$appointmentID</td>";
			}

			// Client Orders
			$result = $conn->query("SELECT * FROM PPPOrders WHERE photographerID='$photoid'");

			$orderTypeF="";
			$orderNumF="";
			while($row = mysqli_fetch_array($result)) {
				[$orderType, $address, $orderNum, , , ] = $row;
				$orderTypeF.= $orderType.=" ";
				$orderNumF.=$orderNum.=" ";
			}
			$table_rows .= "<td>$orderTypeF</td><td>$address</td><td>$orderNumF</td></tr>";


			echo("
				<p></p>
				<table>
					<tr>
						<th>Photographer First Name</th>
						<th>Photographer Last Name</th>
						<th>Photographer ID</th>
						<th>Photographer Phone Number</th>
						<th>Photographer Email</th>
						<th>Client First Name</th>
						<th>Client Last Name</th>
						<th>Event Type</th>
						<th>Venue</th>
						<th>Date and Time</th>
						<th>Appointment ID</th>
						<th>Client's Order</th>
						<th>Client's Address</th>
						<th>Order Numbers</th>
					</tr>
					$table_rows
				</table>
			");
					
			//}
		?>


	</body>
</html>