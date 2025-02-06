<html>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" sizes="192x192" href="https://raunak1089.github.io/Required-files/favicon.ico">
    <script src="https://raunak1089.github.io/all_scripts/fontawesome.js"></script> 

<head>
<link rel="stylesheet" href=".\style.css">
<title>Registration Form</title>
</head>
<body>
<img src="images/rkm.png" alt="">
<div id="bg"></div>

<div class="login-box">
  <h2>Welcome</h2>

<form class="form" action="save.php" method="post">
  
  <div class="user-box">
  <input type="text" id="name" name="name" required>
	<label for="name">Name</label>
  </div>

  <div class="user-box">
	<input type="text" id="college" name="college" required>
	<label for="college">College Name</label>
  </div>

  <div class="user-box">
	<input type="text" id="department" name="department" required>
  <label for="department">Department</label>
  </div>

	<input hidden type="text" id="regID" name="regID">

  <a href="#">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    Register
<input type="submit" value="Register">
  </a>
</form>
</div>

</body>
<script>
function generateRegistrationID() {
  // Generate a random string of 8 characters using a-zA-Z0-9 characters
  var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var result = '';
  for (var i = 0; i < 8; i++) {
    result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
  }

  // Add a timestamp to the end of the random string to make it unique
  var timestamp = Date.now();
  result += timestamp;

  return result;
}

document.querySelectorAll('input[type="submit"]')[0].onclick=()=>{
	document.querySelector('#regID').value=generateRegistrationID();
}

</script>
</html>
