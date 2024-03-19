
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <h2>Welcome to the Index Page</h2>

 
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
        echo "Hello, " . $_SESSION['username'] . "! ";
        echo '<a href="index.php?action=logout">Logout</a>';
    } else {
        // Display registration button when the user is not logged in
        echo '<a href="index.php?action=register">Register</a>';
    }
    ?>



    <!-- Your other content goes here -->
</body>
</html>
