<?php

if (!isset($_COOKIE['id'])) {
  header("location: login.php");
}



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
  $name = $_POST["name"];
  $body = $_POST["body"];
  $genre = $_POST["genre"];
  $ingredients = $_POST["ingredients"];
  $instructions = $_POST["instructions"];
  $userid = $_COOKIE["id"];
  $unique_id = uniqid();

  if(isset($_FILES['image'])){
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];

    $parts = explode(".", $file_name);
    $extension = end($parts);
    $new_file_name = "Image" . uniqid() . "." . $extension;
    move_uploaded_file($file_tmp,"uploads/".$new_file_name);

    // prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO recipes (id, userid, name, genre, image, body, ingredients, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $unique_id, $userid, $name, $genre, $new_file_name, $body, $ingredients, $instructions);
  
    // execute SQL statement
    if ($stmt->execute() === TRUE) {
      echo '<script type="text/javascript">alert("Recipe Added Successfully");</script>';

      header("location: index.php");
    } else {
      echo '<script type="text/javascript">alert("Something went wrong");</script>';
    }
  
    // close statement and connection
    $stmt->close();
    $conn->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Recipe</title>
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
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            
            <div class="mb-3 inputbox first">
              <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                aria-describedby=""
                required
              />
              <label class="form-label">Recipe name</label>
            </div>

            <div class="mb-3 inputbox next">
              <input
                type="text"
                class="form-control"
                id="genre"
                name="genre"
                aria-describedby=""
                required
              />
              <label class="form-label">Recipe Genre</label>
            </div>

            <div class="my-3 form-group">
            <label class="form-label me-2">Picture </label>
              <input
                type="file"
                id="image"
                name="image"
                required
              />
              
            </div>
            
            <div class="mb-3 inputbox next">
              <input
                type="text"
                class="form-control"
                id="body"
                name="body"
                aria-describedby=""
                required
              />
              <label class="form-label">Description</label>
            </div>
            <div class="mb-3 inputbox next">
              <input
                type="text"
                class="form-control"
                id="ingredients"
                name="ingredients"
                required
              />
              <label class="form-label">Ingredients ( Separated by ';' )</label>
            </div>
            <div class="mb-3 inputbox next">
              <input
                type="text"
                class="form-control"
                id="instructions"
                name="instructions"
                required
              />
              <label class="form-label">Instructions</label>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn fav1 w-100 mt-3 mb-2">
                Add Recipe
              </button>
            </div>
            <div class="d-flex mt-3 justify-content-center"></div>
          </form>
        </div>
      </div>
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
