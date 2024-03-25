<?php
// Function to logout
function logout()
{
    // Start the session
    session_start();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    echo '<script>';
    echo 'localStorage.removeItem("divContents");';
    echo '</script>';

    // Redirect to the login page after logout
    // header("Location: login.php");
    echo '<script>window.location.href = "login.php"</script>';
    exit();
}
logout();
?>