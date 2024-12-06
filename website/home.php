<?php
session_start();
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "websitelogin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the username and password are valid
    $sql = "SELECT * FROM logindetails WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM logindetails WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    
    // Generate a unique query parameter using the current timestamp
    $queryParam = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>AI Tools & Resources</title>
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
        .hero {
            background: url('assets/ai-background.jpg') no-repeat center center/cover;
            color: white;
            padding: 128px 16px;
            text-align: center;
        }
        .feature-box {
            padding: 64px 16px;
        }
        .feature-box h2 {
            margin-bottom: 32px;
        }
        .feature-box .w3-third {
            padding: 16px;
        }
        .feature-box img {
            width: 100%;
            border-radius: 10px;
        }
        .tool-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        .nav-profile-picture {
            height: 30px;
            width: 30px;
            object-fit: cover;
            border-radius: 50%;
            vertical-align: middle;
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
    <?php if(isset($_SESSION['username'])): ?>
        <a href="profile.php" class="w3-bar-item w3-button w3-right w3-padding-large w3-hover-white">
        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="nav-profile-picture">
        </a>
    <?php else: ?>
        <a class="w3-bar-item w3-button w3-right w3-padding-large w3-hover-white w3-large w3-purple" href="javascript:void(0);" onclick="openLogin()" title="Login">Login</a>
    <?php endif; ?>
  </div>
  
  <!-- Login pop up -->
  <div id="navLogin" class="w3-bar-block w3-white w3-hide w3-large">
        <div></div>
        <form class="w3-container w3-card-4 w3-right w3-white" style="width: 30%;" method="post" action="">
          <p>
          <input class="w3-input" name="username" type="text" style="width:90%" required>
          <label>Username</label></p>
          <p>
          <input class="w3-input" name="password" type="password" style="width:90%" required>
          <label>Password</label></p>
          <p>
              <a href="#" class="w3-text-purple">Forgotten password</a>
          </p>
          <p>
          <input id="milk" class="w3-check" type="checkbox" checked="checked">
          <label>Stay logged in</label></p>
          <p>
          <button class="w3-button w3-section w3-teal w3-ripple" type="submit" name="login">Log in</button>
          <a href="signup.php" class="w3-button w3-section w3-teal w3-light-grey">Sign up</a>
          </p>
        </form>
  </div>
</div>

<!-- Hero Section -->
<header class="hero w3-purple">
    <h1 class="w3-margin w3-jumbo">Discover the Best AI Tools</h1>
    <p class="w3-xlarge">Explore, compare, and stay updated with the latest AI resources.</p>
    <a href="tools.html" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-text-black">Get Started</a>
</header>

<!-- Features Section -->
<div class="w3-row-padding feature-box w3-light-grey w3-container">
  <div class="w3-content">
      <h2 class="w3-center">Why Choose Our Platform?</h2>
      <div class="w3-third w3-center">
          <i class="fa fa-cogs w3-text-purple w3-jumbo"></i>
          <h3>Easy to Use</h3>
          <p>Our platform is user-friendly and easy to navigate.</p>
      </div>
      <div class="w3-third w3-center">
          <i class="fa fa-th-list w3-text-purple w3-jumbo"></i>
          <h3>Comprehensive</h3>
          <p>We offer a wide range of AI tools and resources.</p>
      </div>
      <div class="w3-third w3-center">
          <i class="fa fa-refresh w3-text-purple w3-jumbo"></i>
          <h3>Up-to-Date</h3>
          <p>Stay updated with the latest advancements in AI technology.</p>
      </div>
  </div>
</div>

<!-- Tools Section -->
<div class="w3-row-padding w3-container">
    <div class="w3-content">
        <h2 class="w3-center">Popular AI Tools</h2>
        <div class="w3-third w3-center">
            <img src="assets/toolcard_gpt.png" alt="Tool Image" width="100" height="100">
            <h3>ChatGPT</h3>
            <p>OpenAI's text model, delivering versatile responses.</p>
        </div>
        <div class="w3-third w3-center">
            <img src="assets/toolcard_copilot.webp" alt="Tool Image" width="100" height="100">
            <h3>Copilot</h3>
            <p>Microsoft's AI assistant, providing smart and efficient support.</p>
        </div>
        <div class="w3-third w3-center">
            <img src="https://pbs.twimg.com/profile_images/1771237092716343298/SYZM0yv6_400x400.png" alt="Tool Image" width="100" height="100">
            <h3>SentinelOne</h3>
            <p>AI-driven cybersecurity platform for endpoint, cloud, and data protection.</p>
        </div>
    </div>
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

<script>
    function myFunction() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }

    function openLogin() {
        var x = document.getElementById("navLogin");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "test");
        }
    }
</script>

</body>
</html>
