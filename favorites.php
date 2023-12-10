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

  $recipe_id = $_POST["recipe_id"];
  $userid = $_COOKIE["id"];
  $unique_id = uniqid();

  // prepare and bind SQL statement
  $stmt = $conn->prepare("SELECT * from user_fav where user_id=? and recipe_id=?");
  $stmt->bind_param('ss', $userid, $recipe_id);

  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Get the result set
  $result = mysqli_stmt_get_result($stmt);

  // echo mysqli_num_rows($result);

  if (mysqli_num_rows($result) > 0) {
    $stmt = $conn->prepare("DELETE FROM user_fav WHERE user_id = ? and recipe_id = ?;");
    $stmt->bind_param("ss", $userid, $recipe_id);

    $stmt->execute();

  } else {
    $stmt = $conn->prepare("INSERT INTO user_fav (id, user_id, recipe_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $unique_id, $userid, $recipe_id);

    $stmt->execute();
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Favourites</title>
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

    <div>
      <h2 class="text-center my-5" id="category">My Collection</h2>
      <hr />
      <div class="recipe-cards" id="cards">
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

      $userid = $_COOKIE["id"];

      // prepare and bind SQL statement
      $stmt = $conn->prepare("SELECT r.*
        FROM user_fav uf
        JOIN recipes r ON uf.recipe_id = r.id
        WHERE uf.user_id = ?;
      ");
      $stmt->bind_param('s', $userid);

      // Execute the statement
      mysqli_stmt_execute($stmt);

      // Get the result set
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

          echo '<div class="recipe-card">
                  <div class="recipe-card-info d-grid">
                    <div id="descrip">
                      <img
                        class="recipe-card img mx-1 me-3 lazy"
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
                  <a href="details.php?id=' . $row["id"] . '" type="button" class="btn icn2 mx-5"
                    >View</a
                  >
                </div>';
        }
      } else {
        echo '<h4 id="nofav">You currently have no recipes in your collection!</h4>';
      }

      // close statement and connection
      $stmt->close();
      $conn->close();
      ?>

      <!-- <div class="recipe-cards" id="cards">
        <div class="recipe-card">
          <div class="recipe-card-info d-grid">
            <div id="descrip">
              <img
                class="recipe-card img mx-2"
                src="assets/biryani.png"
                alt="Chicken Alfredo Pasta"
              />
              <div class="txt mb-lg-3 mb-md-3">
                <h2>Biriyani</h2>
                <p>
                  A spiced mix of meat and rice, traditionally cooked over an
                  open fire in a leather pot.
                </p>
              </div>
            </div>
          </div>
          <a href="details.php" type="button" class="btn btn-dark mx-5"
            >View Recipe</a
          >
        </div>
        <div class="recipe-card">
          <div class="recipe-card-info">
            <div id="descrip">
              <img
                class="recipe-card img mx-2"
                src="assets/pizza.jpg"
                alt="Pepperoni Pizza"
              />
              <div class="txt mb-lg-2 mb-md-2">
                <h2>Pepperoni Pizza</h2>
                <p>
                  An American pizza variety which includes one of the country's
                  most beloved toppings.
                </p>
              </div>
            </div>
          </div>
          <a href="details.php" type="button" class="btn btn-dark mx-5"
            >View Recipe</a
          >
        </div>
      </div> -->
    </div>

    <!-- Footer Section Starts -->

    <div id="footer"></div>

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
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
    <script>
      LL = new LazyLoad();
    </script>
  </body>
</html>
