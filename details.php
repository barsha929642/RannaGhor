<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Details</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
      integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm"
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

    <!-- main Section Starts -->

    <div class="container">
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
      $id = $_GET["id"];
      $stmt = $conn->prepare("SELECT * FROM recipes WHERE id=? limit 1");
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $value = $result->fetch_object();

      $newValue = $value->views + 1;

      $updt_stmt = $conn->prepare("UPDATE recipes SET views=? WHERE id=?");
      $updt_stmt->bind_param('ss', $newValue, $id);
      $updt_stmt->execute();

      // echo $error;
      $array = explode(";", $value->ingredients);
        
      echo '<div class="d-flex justify-content-center">
        <img
          id="chick"
          src="uploads/' . $value->image . '"
          class="img-fluid rounded mt-5"
          alt="..."
        />
      </div>
      <h2 id="chicknam" class="my-5">'.$value->name.'</h2>
      <hr class="my-5"/>
      <div class="boro">
        <p id="p">Description</p>
        <p>
          '.$value->body.'
        </p>

        <p id="p">Ingredients</p>
        <ul type="radio">';
        foreach ($array as $ing) {
            echo '<li>'.$ing.'</li>';
        }
        echo '</ul>
        <p id="p">Instructions</p>

          '.$value->instructions.'
      </div></div>';

      // Favourite Section
      
      if (isset($_COOKIE["id"])) {
        $userid = $_COOKIE["id"];

      // prepare and bind SQL statement
        $stmt = $conn->prepare("SELECT * from user_fav where user_id=? and recipe_id=?");
        $stmt->bind_param('ss', $userid, $value->id);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        
          echo '<div class="d-flex justify-content-center my-5">
          <form action="favorites.php" method="POST">
            <input type=text name="recipe_id" value="'.$value->id.'" hidden>
            <button type="submit" class="btn fav w-100">
              '; 
              if (mysqli_num_rows($result) > 0) {
                echo "Remove from Favorites";
              } else {
                echo "Add to Favorites";
              }
              echo '
            </button>
          </form>
          </div>';
        } else {
          echo '<div class="d-flex justify-content-center my-5">
          <form action="favorites.php" method="POST">
            <input type=text name="recipe_id" value="'.$value->id.'" hidden>
            <button type="submit" class="btn fav w-100">
              Add to Favorites
            </button>
          </form>
          </div>';
        }

      $stmt->close();
      $conn->close();
    ?>

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
  </body>
</html>
