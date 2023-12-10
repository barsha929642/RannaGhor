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

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $query = $_GET["query"];
        $searchQuery = mysqli_real_escape_string($link, $query);

        $stmt = $link->prepare("SELECT id, name, genre, body, image FROM recipes WHERE approved = 1 and name LIKE CONCAT('%', ?, '%') ORDER BY views DESC LIMIT 6");
        $stmt->bind_param("s", $searchQuery);
        $stmt->execute();

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        $response = "";

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            $response = $response . '<div class="col-lg-4 col-md-6 col-12 d-flex align-items-stretch mb-4">
                <div class="card w-100">
                <img
                    src="uploads/' . $row["image"] . '"
                    style="height: 276px"
                    class="card-img-top"
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
        } else {
            $response = '<h4 id="nofav" class="text-center">Your query has 0 search results!</h4>';
        }
        
        echo $response;

        $stmt->close();
    }    

    $link->close();
?>