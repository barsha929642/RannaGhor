<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Just Cook It</title>
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

    <div class="container">
      <input
          class="form-control search-click mt-5 w-100"
          type="search"
          id="searchBox"
          placeholder="Search"
          aria-label="Search"
        />
      <img
        id="homepic"
        src="./assets/homepic.jpg"
        class="img-fluid rounded w-100 mt-5"
        alt="..."
      />

      <h2 id="searchedItemsTitle" class="text-center my-5">Searched Items</h2>
      <div id="searchedItems" class="row mt-3"></div>

      <h2 class="text-center my-5" id="category">Popular Items</h2>
      <div class="row mt-3">


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

      // prepare and bind SQL statement
      $stmt = $conn->prepare("SELECT id, name, genre, body, image FROM recipes WHERE approved = 1 ORDER BY views DESC LIMIT 6");
      // $sql = "SELECT * FROM your_table ORDER BY your_column_name DESC LIMIT 6";

      // Execute the statement
      mysqli_stmt_execute($stmt);

      // Get the result set
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

          echo '<div class="col-lg-4 col-md-6 col-12 d-flex align-items-stretch mb-4">
            <div class="card w-100">
              <img
                src="uploads/' . $row["image"] . '"
                style="height: 276px"
                class="card-img-top lazy"
                alt="..."
              />
              <div class="card-body">
                <h5 class="card-title">' . $row["name"] . '</h5>
                <p class="card-text">' . $row["genre"] . '</p>
                <a href="/details.php?id=' . $row["id"] . '" class="float-left submit-button btn icn2"
                  >Details</a
                >
              </div>
            </div>
          </div>';
        }
      }
      

      // close statement and connection
      $stmt->close();
      $conn->close();
      ?>
      </div>
      <div class="d-flex justify-content-center my-5">
          <a class="btn fav" href="/all.php">
            View all
          </a>
        </form>
      </div>
    </div>

    <!-- <a href="#" class="float">
      <span class="my-float">Add New Recipe</span>
    </a> -->

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

    <script>
        // const searchBox = document.getElementById('searchBox');
        // searchBox.addEventListener('input', (e) => {
        //   const query = searchBox.value.trim().toLowerCase();
        //   console.log(query);
        // });

        $(document).ready(function () {
          $('#searchedItemsTitle').hide();
            $('#searchBox').keyup(function () {
              
              const searchText = $(this).val();

              // console.log('searchText: ' + searchText);
              if (searchText.length > 0) {
                $('#homepic').hide();
                $('#searchedItemsTitle').show();
                $.ajax({
                  type: "GET",
                  url: "search.php",
                  data: { query: searchText },
                  success: function (response) {
                      $('#searchedItems').html(response);
                  },
                });
              } else {
                $('#searchedItemsTitle').hide();
                $('#homepic').show();
                $('#searchedItems').html('');
              }
            });
        });
    </script>

    <!-- <script>
      $(document).ready(function () {
        $('#searchBox').blur(function () {
            $('#homepic').show();
            $('#searchedItems').html('');
        });
      });
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
    <script>
      LL = new LazyLoad();
    </script>

  </body>
</html>
