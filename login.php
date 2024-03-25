<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="sign.css">
</head>

<body>
    <header>
        <h1>Distributed systems Assignment Login Page</h1>
    </header>


    <div class="login-form">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" id="try">Login</button>
            <div style="color: red;">
                <?php
                $data = 1;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Retrieve hashed password from the database

                    // Database connection
                    $servername = "reset.mysql.database.azure.com";
                    $dbusername = "qydbtcaewv";
                    $dbpassword = "@reset123";
                    $database = "reset-db";
                    try {
                        $conn = new mysqli($servername, $dbusername, $dbpassword, $database);
                        if ($conn->connect_error) {
                            throw 'connection error';
                        }
                    } catch (\Throwable $th) {
                        echo "connection failed!!!";
                        die("Connection failed: ");
                    }

                    // User input (username or email)
                    $userInput = $_POST["username"];

                    // Prepare SQL statement
                    $sql = "SELECT `password`, `Username` FROM `users` WHERE username = ? OR email = ?";
                    $stmt = $conn->prepare($sql);

                    // Bind the parameter to the statement
                    $stmt->bind_param("ss", $userInput, $userInput);

                    // Execute the query
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->get_result();

                    // Check if the query returned any rows
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $uname  = $row['Username'];
                        $hashedPassword = $row['password'];


                        // Password entered by the user during login
                        $userEnteredPassword = $_POST["password"];
                        $hashedUserEnteredPassword = password_hash($userEnteredPassword, PASSWORD_DEFAULT);
                        // Verify if the user-entered password matches the stored hashed password
                        // password_verify($userEnteredPassword, $hashedPassword))
                        if ($userEnteredPassword == $hashedPassword) {
                            echo "match found</btr>";
                            // Start the session
                            session_start();

                            // // Store the username in the session
                            // $_SESSION["username"] = $uname;
                            // echo $_SESSION["username"];

                            echo '<div id="usn" style="display: none;">$uname</div>';
                            echo '<script>storeDivContents()</script>';

                            // Redirect to the home page
                            // header("Location: index.php");
                            echo '<script>window.location.href = "index.php"</script>';
                            exit();
                        } else {
                            // Redirect back to the login page with an error message
                            // header("Location: login.php?error=1");
                            echo "incorrect password,please retry";
                        }
                    } else {
                        // No matching user found
                        echo "Incorrect email or username, please retry";
                    }

                    // Close statement and connection
                    $stmt->close();
                    $conn->close();
                }
                ?>
            </div>
            <div>Don't have an account,<a href="signup.php">sign up</a>?</div>
            <div><a href="reset.php?data=<?php echo urlencode($data); ?>">Forgot Password?</a></div>


    </div>
    </form>

    <footer>
        <p>&copy; distributed systems assignment.</p>
    </footer>
</body>
<script>
    // Define a function to navigate to a new page
    function redirectToNewPage() {
        document.getElementById('try').innerHTML = 'Tring to navigate';
        window.location.href = "index.php";
    }


    function storeDivContents() {
        // Get the div element by its ID
        const divElement = document.getElementById('usn');

        // Check if the div element exists
        if (divElement) {
            // Get the contents of the div
            const divContents = divElement.innerHTML;

            // Store the contents in local storage
            localStorage.setItem('divContents', divContents);

            alert('Div contents stored in local storage!');
        } else {
            alert('Div element not found!');
        }
    }
</script>

</html>