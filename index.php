<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <header>
        <h1>Home page</h1>
        <div><?php 'aaa' ?>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <form class="find" action="index.php" method="get">
                <label for="admission_number">Adm No:</label>
                <input type="text" id="admission_number" name="admission_number" required>
                <button type="submit" name="get">Search</button>
            </form>
        </nav>
    </header>

    <div id="maindiv">
        <div class="main-content" id="div1">
            <div class="main-content" id="div2">
                <?php
                // echo session_save_path();
                // if ($_SESSION['username']) {
                //     // Display user details if logged in
                //     echo "<h2>Welcome, " . $_SESSION['username'] . "</h2>";
                //     echo "<div class='profile-image'><img src='assets\profile.png' alt='Profile Image'></div>";
                // } else {
                //     // Display login button if not logged in
                //     echo "<a href='login.php' class='button'>Login</a>";
                // }
                ?>
                <div id="in" style="display: none;">
                    <h2 id='h2'></h2>
                    <div class='profile-image'><img src='assets\profile.png' alt='Profile Image'></div>
                </div>

                <div id="out" style="display: none;">
                    <a href='login.php' class='button'>Login</a>
                </div>
            </div>
            <?php
            // Database connection
            $servername = "reset.mysql.database.azure.com";
            $dbusername = "qydbtcaewv";
            $dbpassword = "@reset123";
            $database = "reset-db";
            try {
                $conn = new mysqli($servername, $dbusername, $dbpassword, $database);
                if ($conn->connect_error) {
                    throw 'connection error';
                } else {
                    // echo "connection success!";
                }
            } catch (\Throwable $th) {

                die("Connection failed: ");
            }
            // $conn = new mysqli($servername, $dbusername, $dbpassword, $database);
            // if ($conn->connect_error) {
            //     echo "connection failed!!!";
            //     die("Connection failed: " . $conn->connect_error);
            // }

            // Check if the search button was clicked
            if (isset($_GET["get"])) {
                // Sanitize the input to prevent SQL injection
                $admission_number = $_GET["admission_number"];

                // Prepare the SQL statement with a parameter placeholder
                $sql = "SELECT `UID`, `Username`, `email`, `password`, `Name`, `mobile`, `address` FROM `users` WHERE `Username` LIKE ? OR `email` LIKE ? OR `UID` LIKE ?";
                $stmt = $conn->prepare($sql);

                // Bind the parameters to the statement
                $searchTermWithWildcards = '%' . $admission_number . '%';
                $stmt->bind_param("sss", $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards);



                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();
                // echo $result->num_rows;
                if ($result->num_rows > 0) {
                    echo "<h2>Student Details</h2>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<p><strong>Name:</strong> " . $row["Name"] . "</p>";
                        echo "<p><strong>Admission Number:</strong> " . $row["UID"] . "</p>";
                        echo "<p><strong>Mobile Number:</strong> " . $row["mobile"] . "</p>";
                        echo "<hr>"; // Optional: Add a horizontal line between each student's details
                    }
                } else {
                    echo "No student found with admission number: " . $admission_number;
                }


                // Close statement
                $stmt->close();
            }
            // Close connection
            $conn->close();
            ?>

        </div>
        <div class="main-content" id="div3">
            <?php
            // Database connection
            $servername = "reset.mysql.database.azure.com";
            $dbusername = "qydbtcaewv";
            $dbpassword = "@reset123";
            $database = "reset-db";

            $conn = new mysqli($servername, $dbusername, $dbpassword, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch names and admission numbers
            $sql = "SELECT `UID`, `Name` FROM `users`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Members</h2>";
                echo "<table class='student-table'>";
                echo "<tr><th>Name</th><th>Admission Number</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Name"] . "</td>";
                    echo "<td>" . $row["UID"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No students found";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>
    <footer>
        <p>&copy; Distributed systems assignment</p>
    </footer>
</body>
<script>
    // Retrieve data from local storage
    const storedData = localStorage.getItem('divContents');

    // Check if data retrieval was successful
    if (storedData) {
        // Display the "in" div and hide the "out" div
        document.getElementById('in').style.display = 'block';
        document.getElementById('out').style.display = 'none';

        // Update the content of the h2 element
        const h2Element = document.getElementById('h2');
        h2Element.textContent = storedData;
    } else {
        // Display the "out" div and hide the "in" div
        document.getElementById('out').style.display = 'block';
        document.getElementById('in').style.display = 'none';
        window.location.href = "login.php";
    }
</script>

</html>