<?php
// database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rannaghor";

// create connection
$link = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($link->connect_error) {
  die("Connection failed: " . $link->connect_error);
}
// Check if the user is logged in
if(!isset($_COOKIE["id"])){
    header("location: login.php");
    exit;
}

// Get the user's profile information from the database
$id = $_COOKIE["id"];
$sql = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row["username"];
    $email = $row["email"];
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
} else {
    echo "Error: Unable to retrieve user information.";
}

// Handle form submission
if (isset($_POST["submit"])) {
    // Get the form data
    $current_password = mysqli_real_escape_string($link, $_POST["current_password"]);
    $new_password = mysqli_real_escape_string($link, $_POST["new_password"]);
    $confirm_password = mysqli_real_escape_string($link, $_POST["confirm_password"]);
    $firstname = mysqli_real_escape_string($link, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($link, $_POST["lastname"]);

    // Check if the current password is correct
    $sql = "SELECT password FROM users WHERE id = '$id'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row["password"];

    

    if (password_verify($current_password, $hashed_password)) {
        // Check if the new password and confirm password match
        if (strlen($new_password)>=6 || strlen($confirm_password)>=6) {
            if($new_password == $confirm_password){
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', password = '$hashed_new_password' WHERE id = '$id'";
                mysqli_query($link, $sql);
                $success_message = "Profile updated successfully.";
            }else{
                $error_message = "New password and confirm password do not match.";
            }
        } else if(strlen($new_password)>0 || strlen($confirm_password)>0){
            $error_message = "New password and confirm password must be at least 6 characters long.";
        } else{
            // Update the first name and last name in the database
            $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname' WHERE id = '$id'";
            mysqli_query($link, $sql);
            $success_message = "Profile updated successfully.";
        }
    } else {
        $error_message = "Current password is incorrect.";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
      integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm"
      crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <link href="https://fonts.maateen.me/charukola-ultra-light/font.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="header"></div>

<div class="dash">
<h2 class="text-center my-5" id="category">User Profile</h2>
	<?php if(isset($success_message)) { ?>
		<div><?php echo $success_message; ?></div>
	<?php } ?>
	<?php if(isset($error_message)) { ?>
		<div><?php echo $error_message; ?></div>
	<?php } ?>
	<div class="prof d-flex justify-content-center">
  <form method="POST" action="">
    <label>Username</label><br>
    <input id="textbox1" type="text" value="<?php echo $username; ?>" disabled><br><br>
		<label>Email</label><br>
		<input id="textbox1" type="email" value="<?php echo $email; ?>" disabled><br><br>
		<label>First Name</label><br>
		<input id="textbox1" type="text" name="firstname" value="<?php echo $firstname; ?>"><br><br>
		<label>Last Name</label><br>
		<input id="textbox1" type="text" name="lastname" value="<?php echo $lastname; ?>"><br><br>
		<label>Current Password</label><br>
		<input id="textbox1" type="password" name="current_password"><br><br>
		<label>New Password</label><br>
		<input id="textbox1" type="password" name="new_password"><br><br>
		<label>Confirm Password</label><br>
		<input id="textbox1" type="password" m Password" name="confirm_password"><br><br>
		<input id="submit" class="btn btn mt-4" type="submit" name="submit" value="Save">
	</form>
  </div>

    <?php

      // database connection settings
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "rannaghor";

      // create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $userid = $_COOKIE["id"];

      // prepare and bind SQL statement
      $stmt = $conn->prepare("SELECT * FROM recipes WHERE userid = ?;
      ");
      $stmt->bind_param('s', $userid);

      // Execute the statement
      mysqli_stmt_execute($stmt);

      // Get the result set
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        echo '<h2 class="text-center my-5" id="category">My Recipes</h2>
        <hr class="mb-5" />';
        while($row = mysqli_fetch_assoc($result)) {
          $status = $row['approved']?"Approved":"Pending";

          echo '<div class="recipe-card">
          <div class="recipe-card-info d-grid">
            <div id="descrip">
              <img
                class="recipe-card img mx-1 me-3"
                src="uploads/' . $row["image"] . '"
              />
              <div class="txt mb-lg-3 mb-md-3">
                <h2>' . $row["name"] . '</h2>
                <p class="mt-3">
                  ' . $row["genre"] . '
                </p>
                <p>
                  ' . $row["body"] . '
                </p>
              </div>
            </div>
          </div>
          <a href="details.php?id=' . $row["id"] . '" type="button" class="btn icn2"
            >View</a
          >
          <button class="btn btn-dark mx-3" disabled>'. $status .'</button>
        </div>';
        }
      } else {
        echo '<h4 id="nofav">You currently have no recipes in your collection!</h4>';
      }

      // close statement and connection
      $stmt->close();
      $conn->close();
      ?>
</div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.6.4.min.js"
      integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
      crossorigin="anonymous"
    ></script>

    <script src="js/load_essential.js"></script>
</body>
</html>
