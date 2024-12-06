<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up - AI tools & resources</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="website.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
    .w3-bar,h1,button {font-family: "Montserrat", sans-serif}   
    .fa-anchor,.fa-coffee {font-size:200px}
    .center-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-purple w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-purple" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="home.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Home</a>
    <a href="about.html" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">About us</a>
    <a href="contact.html" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Contact us</a>
  </div>
</div>

<!-- Sign Up Form -->
<div class="center-container">
  <h1 class="w3-margin w3-jumbo">Sign Up</h1>
  <form class="w3-container w3-card-4 w3-light-grey w3-text-purple w3-margin" style="max-width: 800px; width: 50%;" method="post">
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
        <div class="w3-rest">
            <input class="w3-input w3-border" name="username" type="text" placeholder="Username" required>
        </div>
    </div>
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope"></i></div>
        <div class="w3-rest">
            <input class="w3-input w3-border" name="email" type="text" placeholder="Email" required>
        </div>
    </div>
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
        <div class="w3-rest">
            <input class="w3-input w3-border" name="phone" type="text" placeholder="Phone number (optional)">
        </div>
    </div>
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
        <div class="w3-rest">
            <input class="w3-input w3-border" name="password" type="password" placeholder="Password" required>
        </div>
    </div>
    <button class="w3-button w3-block w3-purple w3-padding-16 w3-section w3-ripple w3-hover-black" type="submit" name="SignUp_Btn">Sign Up</button>
</form>


</div>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">
  <div class="w3-xlarge w3-padding-32">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>

</body>
</html>

<?php
session_start();

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "websitelogin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['SignUp_Btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username or email already exists
    $checkUser = "SELECT * FROM logindetails WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $checkUser);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username or Email already exists');</script>";
    } else {
        $sql = "INSERT INTO logindetails (username, email, phone, password) VALUES ('$username', '$email', '$phone', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['username'] = $username;
            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "');</script>";
        }
    }
}

mysqli_close($conn);
?>


