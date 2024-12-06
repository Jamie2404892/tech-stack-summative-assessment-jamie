<?php
session_start();

// Redirect to home.php if the user is not signed in
if (!isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "websitelogin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Logout function
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}

// Fetch user data
$username = $_SESSION['username'];
$sql = "SELECT * FROM logindetails WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User not found. Please log in again.'); window.location.href = 'home.php';</script>";
    exit();
}

// Update user data
if (isset($_POST['Save_Btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Handle file upload
    $profilePicture = $_FILES['profilePicture'];
    if ($profilePicture['size'] > 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . $username . "." . strtolower(pathinfo($profilePicture["name"], PATHINFO_EXTENSION));
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($profilePicture["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($profilePicture["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            $profilePicturePath = $user['profile_picture'];
        } else {
            // Delete the old profile picture if it exists
            if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])) {
                unlink($user['profile_picture']);
            }

            // Move the uploaded file
            if (move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
                echo "The file ". htmlspecialchars(basename($profilePicture["name"])). " has been uploaded.";
                $profilePicturePath = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
                $profilePicturePath = $user['profile_picture'];
            }
        }
    } else {
        $profilePicturePath = $user['profile_picture'];
    }

    $sql = "UPDATE logindetails SET email = '$email', phone = '$phone', password = '$password', profile_picture = '$profilePicturePath' WHERE username = '$username'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profile updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile - AI tools & resources</title>
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
    .square-image {
        width: 100px; 
        height: 100px;
        object-fit: cover;
        border-radius: 50%; 
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

<!-- Edit Profile Form -->
<div class="center-container">
    <h1 class="w3-margin w3-jumbo">Edit Profile</h1>
    <form class="w3-container w3-card-4 w3-light-grey w3-margin" style="max-width: 800px; width: 50%;" method="post" enctype="multipart/form-data">
        <div class="w3-row w3-section">
            <div class="w3-col w3-text-purple" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="username" type="text" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col w3-text-purple" style="width:50px"><i class="w3-xxlarge fa fa-envelope"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="email" type="text" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col w3-text-purple" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="phone" type="text" value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col w3-text-purple" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="password" type="password" value="<?php echo htmlspecialchars($user['password']); ?>">
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="preview" id="preview">
                <img id="previewImage" src="<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'assets/default-pfp.jpg'; ?>" alt="Profile Picture Preview" class="square-image" style="display:block; margin-top: 10px;">
            </div>
            <div class="w3-rest">
                <input class="w3-input" type="file" id="profilePicture" name="profilePicture" accept="image/*">
            </div>
        </div>
        <button class="w3-button w3-block w3-purple w3-padding-16 w3-section w3-ripple w3-hover-black" type="submit" name="Save_Btn">Save</button>
        <form method="post">
            <button class="w3-button w3-block w3-purple w3-padding-16 w3-section w3-ripple w3-hover-black" type="submit" name="logout">Sign Out</button>
        </form>
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

<script>
    function myFunction() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }

    document.getElementById('profilePicture').onchange = function (event) {
        const [file] = event.target.files;
        if (file) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = URL.createObjectURL(file);
            previewImage.style.display = 'block';
        }
    };
</script>

</body>
</html>
