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

// process form data if submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST["username"];
  $password = $_POST["password"];
  $stmt = $conn->prepare("SELECT * FROM Users WHERE username=? limit 1");
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $result = $stmt->get_result();
  $value = $result->fetch_object();

  // echo $value->firstname;

  if (password_verify($password, $value->password)) {
    // set session variables
    setcookie('id', $value->id, time() + 2592000);
    echo '<script type="text/javascript">alert("Login Successful");</script>';

    // redirect to welcome page
    header("location: index.php");
  } else {
    // display error message
    echo '<script type="text/javascript">alert("Invalid username or password.");</script>';
  }
  // echo $error;
  // close statement and connection
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="google-signin-client_id"
      content="YOUR_CLIENT_ID.apps.googleusercontent.com"
    />
    <title>Login</title>
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.maateen.me/charukola-ultra-light/font.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <!-- Navbar Section Starts -->
    <div id="header"></div>

    <!-- Main Section Starts -->
    <div class="row justify-content-center">
      <div class="col-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card p-5 mt-5">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="mb-3 inputbox first">
              <i class="bi bi-envelope button"></i>
              <input
                type="text"
                class="form-control"
                id="username"
                aria-describedby="emailHelp"
                name="username"
                on
                required
              />
              <label for="username" class="form-label"
                >Username or Email address</label
              >
            </div>
            <div class="mb-3 inputbox next">
              <i class="bi bi-lock button"></i>
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                required
              />
              <label for="password" class="form-label"
                >Password</label
              >
            </div>
            <!-- <div class="my-4 form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="exampleCheck1"
              />
              <label class="form-check-label" for="exampleCheck1"
                >Remember me</label
              >
            </div> -->
            <div class="d-grid">
              <button type="submit" class="btn fav1 w-100 mt-3 mb-2">Login</button>
            </div>
            <!-- <div class="d-flex mt-2 justify-content">
              <a href="forgot_pass.html" class="text-decoration-none" style="color: #fffbed"
                >Forgot your password?</a
              >
            </div> -->
            <div class="d-flex mt-3 justify-content-center">
              <p>Don't have an account? <a href="register.html" style="color: #fffbed">Register</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      // console.log(document.cookie.indexOf("id"));
      if (document.cookie.indexOf("id") >= 0) {
        window.location.href = "index.php";
      }
    </script>

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
