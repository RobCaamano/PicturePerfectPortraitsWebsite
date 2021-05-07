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
			<a class="active" href="#home">Home</a>
		</div>
		
		<p></p>

		<form id = "login" method = "POST" name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<!action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  			<label for="fname">Photgrapher First Name:</label><br>
  			<input type="text" id="fName" name="fName"><br>

  			<label for="lname">Photgrapher Last Name:</label><br>
  			<input type="text" id="lName" name="lName"><br>

			<label for="password">Photographer Password:</label><br>
  			<input type="password" id="password" name="password"><br>

			<label for="id">Photographer ID #:</label><br>
  			<input type="text" id="id" name="id"><br>

			<label for="phoneNum">Photographer Phone #:</label><br>
  			<input type="text" id="phoneNum" name="phoneNum"><br>

			<label for="email" style="display:none" id="emailTXT">Photoprapher Email:</label><br>
  			<input type="text" id="email" name="email" style="display:none"><br>

			<label for="checkBox">Check the box to request an Email Confirmation:</label><br>
  			<input type="checkbox" id="checkBox" name="checkBox" onclick="addbox()"><br>

			<label for="transaction">Select a Transaction:</label><br>
			<select name="transaction" id="transaction">
				<option value="records">Search the Photographer’s Records</option>
				<option value="booking">Book a Client’s Appointment</option>
				<option value="placeOrder">Place a Client’s Order</option>
				<option value="updateOrder">Update a Client’s Order</option>
				<option value="cancelApp">Cancel a Client’s Appointment</option>
				<option value="cancelOrder">Cancel a Client’s Order</option>
				<option value="newAccount">Create a Client’s Account</option>
			</select>

			<p></p>

			<input type="button" value="login" onclick="validate()">
			<input type="reset" value="reset">
		</form>

		<script language="javascript">

		function addbox(){
			var checkBox = document.getElementById("checkBox");
			var email = document.getElementById("email");
			var emailText = document.getElementById("emailTXT");

			if(checkBox.checked == true){
				email.style.display = "block";
				emailText.style.display = "block";
			}
			else{
				email.style.display = "none";
				emailText.style.display = "none";
			}
		}

		function validate(){
			var fName = document.getElementById("fName").value;
			var lName = document.getElementById("lName").value;
			var password = document.getElementById("password").value;
			var id = document.getElementById("id").value;
			var phoneNum = document.getElementById("phoneNum").value;
			var email = document.getElementById("email").value;
			var checkBox = document.getElementById("checkBox");

			// FIRST NAME CHECKER --------------------------------------------------------------------------------------------
			var fNameCheck = true;
			if(fName.length == 0){
				alert("You must input a first name");
				document.getElementById("fName").focus();
				document.getElementById("fName").select();
				fNameCheck = false;
			}

			// LAST NAME CHECKER ---------------------------------------------------------------------------------------------	
			if (fNameCheck){
				var lNameCheck = true;
				if(lName.length == 0){
					alert("You must input a last name");
					document.getElementById("lName").focus();
					document.getElementById("lName").select();
					lNameCheck = false;
				}
			}			

			// PASSWORD CHECKER ----------------------------------------------------------------------------------------------
			var passLengthCheck = false;
			var upperCheck = false;
			var specChar = false;
			var numCheck = false;

			var specCharString = " .!#$%&*+?"
			var nums = "1234567890";

			var specIndex;

			var passAlert = "";
			
			if(lNameCheck){
				if(password.length == 0){
					alert("You must input a password");
					document.getElementById("password").focus();
					document.getElementById("password").select();
				}
				else{
					// LENGTH
					if(password.length <= 10){
						passLengthCheck = true;
					}
					// SPECIAL CHAR INDEX
					for(i = 0; i < password.length; i++){
						for(j = 0; j < specCharString.length; j++){
							if(password[i] == specCharString[j]){
								specIndex = i;
								specChar = true;
							}
						}
					}
					// UPPERCASE
					for(i = 0; i < password.length; i++){
						if(password[i] == password[i].toUpperCase() && password[i] !== password[specIndex]){
							upperCheck = true;
						}
					}
					// NUMBER CHECK
					for(i = 0; i < password.length; i++){
						for(j = 0; j < nums.length; j++){
							if(password[i] == nums[j]){
								numCheck = true;
							}
						}	
					}
					// PASSWORD ALERT SYSTEM
					if(!passLengthCheck){
						passAlert += "The password is too long. ";
					}
					if(!upperCheck){
						passAlert += "The password is missing an uppercase character. ";
					}
					if(!specChar){
						passAlert += "The password is missing a special character. ";
					}
					if(!numCheck){
						passAlert += "The password is missing a number. ";
					}

					if(passAlert !== ""){
						alert(passAlert);
						document.getElementById("password").focus();
						document.getElementById("password").select();
					}
				}
			}


			// ID CHECKER ----------------------------------------------------------------------------------------------------
			var IDLengthCheck = false;
			var IDAlert = "";

			if(passLengthCheck && specChar && upperCheck && numCheck){
				if(id.length == 0){
					alert("You must input an ID");
					document.getElementById("id").focus();
					document.getElementById("id").select();
				}
				else{
					if(id.length == 8){
						IDLengthCheck = true;
					}
					// ID ALERT SYSTEM
					if(!IDLengthCheck){
						alert("The ID must be 8 numbers long");
						document.getElementById("id").focus();
						document.getElementById("id").select();
					}
				}
			}


			// PHONE NUMBER CHECKER ------------------------------------------------------------------------------------------
			var phoneDigitCheck = false;
			var digitCount = 0;

			var phoneRegex = /^(\()?\d{3}(\))?(-|\s)?\d{3}(-|\s)\d{4}$/;

			var phoneAlert = "";
			
			if(IDLengthCheck){
				if(phoneNum.length == 0){
					alert("You must input a phone number");
					document.getElementById("phoneNum").focus();
					document.getElementById("phoneNum").select();
				}
				else{
					if(phoneRegex.test(phoneNum)){
						phoneDigitCheck = true;
					}
					//PHONE NUMBER ALERT SYSTEM
					if(!phoneDigitCheck){
						alert("Your phone number should consist of only digits, dashes and spaces. It should also only be 10 digits long.");
						document.getElementById("phoneNum").focus();
						document.getElementById("phoneNum").select();
					}
				}
			}

			// EMAIL CHECKER -------------------------------------------------------------------------------------------------
			var emailCheck = false;			

			var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{3,5}$/;

			if(phoneDigitCheck){
				if(checkBox.checked == true){
					if(email.length == 0){
						alert("You must input an email");
						document.getElementById("email").focus();
						document.getElementById("email").select();
					}					
					else{
						if(emailRegex.test(email)){
							emailCheck = true;
						}
						if(!emailCheck){
							alert("You must input a valid email");
							document.getElementById("email").focus();
							document.getElementById("email").select();						
						}

					}
				}
				else{
					emailCheck = true;
				}
			}


			// CHECK IF ALL TESTS PASS ---------------------------------------------------------------------------------------
			if(lNameCheck && fNameCheck && passLengthCheck && specChar && upperCheck && IDLengthCheck && phoneDigitCheck && emailCheck){
				verify();
			}
		}

		function verify(){
			var fName = document.getElementById("fName").value;
			var lName = document.getElementById("lName").value;
			var password = document.getElementById("password").value;
			var id = document.getElementById("id").value;
			var phoneNum = document.getElementById("phoneNum").value;
			var email = document.getElementById("email").value;
			var checkBox = document.getElementById("checkBox");

			document.getElementById("login").submit();

			// CALL VERIFY FUNCTION IF ALL FIELDS ARE CORRECT
			//alert(usernameCheck);
			//alert(passLengthCheck);
			//alert(specChar);
			//alert(upperCheck);
			//alert(IDLengthCheck);
			//alert(phoneDigitCheck);
			//alert(emailCheck);
		}		
		</script>
		<?php
			// CONNECT
			ini_set('display_errors', 1);

			$conn = mysqli_connect ("sql1.njit.edu", "rc553", "LouroMuros2.", "rc553");
			if (mysqli_connect_errno()){
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

			// POST
			$fname = $lname = $password = $id = $phoneNum = $email = "";
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$fname=$_POST["fName"];
				$lname=$_POST["lName"];
				$password=$_POST["password"];
				$pid=$_POST["id"];
				$phoneNum=$_POST["phoneNum"];
				$email=$_POST["email"];

				if(isset($_POST['fName'],$_POST['lName'],$_POST['id'])){
					$_SESSION["fName"]=$fname;
					$_SESSION["lName"]=$lname;
					$_SESSION["id"]=$id;

					if(isset($_POST['phoneNum'],$_POST['email'])){
						$phoneNum=$_POST["phoneNum"];
						$email=$_POST["email"];
					}
				}

				$_SESSION["id"] = $pid;

				$transaction=$_POST["transaction"];

				$queryString = "SELECT * FROM PPPPhotographers WHERE fname='$fname' AND lname='$lname' AND ppassword='$password' AND id='$pid'";
				if($email)
					$queryString.= " AND email = '$email'";
				$result = mysqli_query($conn, $queryString);

				if($result->num_rows){
					switch($transaction){
						case "records":
							echo
								'<body onload="document.redirectform.submit()">   
									<form action="PPPRecords.php" name="redirectform" style="display:none">
									</form>
								</body>';
							break;
						case "booking":
							echo
							'<body onload="document.redirectform.submit()">   
								<form action="PPPAppointment.php" name="redirectform" style="display:none">
								</form>
							</body>';
							break;
						case "placeOrder":
							echo
							'<body onload="document.redirectform.submit()">   
								<form action="PPPPlaceOrder.php" name="redirectform" style="display:none">
								</form>
							</body>';
							break;
						case "updateOrder":
							echo
							'<body onload="document.redirectform.submit()">   
								<form action="PPPUpdateOrder.php" name="redirectform" style="display:none">
								</form>
							</body>';
							break;
						case "cancelApp":
							echo
							'<body onload="document.redirectform.submit()">   
								<form action="PPPCancelAppointment.php" name="redirectform" style="display:none">
								</form>
							</body>';
							break;
						case "cancelOrder":
							echo
							'<body onload="document.redirectform.submit()">   
								<form action="PPPCancelOrder.php" name="redirectform" style="display:none">
								</form>
							</body>';
							break;
						case "newAccount":
							echo
							'<body onload="document.redirectform.submit()">   
								<form action="PPPCreateAccount.php" name="redirectform" style="display:none">
								</form>
							</body>';
							break;
					}
				}
				else{
					echo '<script>alert("Please enter valid data")</script>';
				}
			}
		?>

		<h1>  </h1>
		<h2>  </h2>


		
	</body>
</html>