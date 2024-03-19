<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add your CSS links or styles here -->
</head>
<body>
    <h2>Login</h2>
    <?php
    // Display error message if present
    if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') {
        echo '<p style="color: red;">Invalid email or password</p>';
    }
    ?>
    <form action="index.php?action=login_process" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
