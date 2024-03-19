<?php
session_start();
$db = new Database();

// Get a database connection
$conn = $db->getConnection();

// Example usage of the UserController
$userController = new UserController(new UserModel($conn),new JobApplicationModel($conn));
?>