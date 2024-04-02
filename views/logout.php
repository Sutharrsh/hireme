<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Display SweetAlert alert
echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Logged Out',
        text: 'You have been successfully logged out!',
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        window.location.href = '?action=login';
    });
</script>";
exit();
?>
