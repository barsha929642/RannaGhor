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
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $unique_id = uniqid();

  // prepare and bind SQL statement
  $stmt = $conn->prepare("INSERT INTO users (id, firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $unique_id, $firstname, $lastname, $email, $username, $hashed_password);

  // execute SQL statement
  if ($stmt->execute() === TRUE) {
    header("location: success_signup.php");
  } else {
    header("location: unsuccess_signup.php");
  }

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
    <title>Register</title>
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
        <div class="card p-5 my-5">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="mb-3 inputbox first">
              <input
                type="text"
                class="form-control"
                id="firstname"
                name="firstname"
                aria-describedby="emailHelp"
                required
              />
              <label for="firstname" class="form-label">First name</label>
            </div>
            <div class="mb-3 inputbox next">
              <input
                type="text"
                class="form-control"
                id="lastname"
                name="lastname"
                aria-describedby="emailHelp"
                required
              />
              <label for="lastname" class="form-label">Last name</label>
            </div>
            <div class="mb-3 inputbox next">
              <input
                type="text"
                class="form-control"
                id="username"
                name="username"
                aria-describedby="emailHelp"
                required
              />
              <label for="username" class="form-label">Username</label>
            </div>
            <div class="mb-3 inputbox next">
              <input
                type="text"
                class="form-control"
                id="email"
                name="email"
                aria-describedby="emailHelp"
                required
              />
              <label for="email" class="form-label"
                >Email address</label
              >
            </div>
            <div id="email-error" class="error-message"></div>
            <div class="mb-3 inputbox next">
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                required
              />
              <label for="password1" class="form-label"
                >Password</label
              >
            </div>
            <div class="mb-3 inputbox next">
              <input
                type="password"
                class="form-control"
                id="password2"
                name="password2"
                required
              />
              <label for="password2" class="form-label"
                >Confirm Password</label
              >
            </div>
            <div class="my-4 form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="exampleCheck1"
                required
              />
              <label class="form-check-label" for="exampleCheck1"
                >Agree to Terms and Conditions</label
              >
            </div>
            <div class="d-grid">
              <button type="submit" class="btn fav1 w-100 mt-3 mb-2">
                Register
              </button>
            </div>
            <div class="d-flex mt-3 justify-content-center">
              <p>
                Already have an account?
                <a href="login.html" style="color: #fffbed">Login</a>
              </p>
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
