<!-- Password Reset Form -->
<form method="post" action="index.php?action=forgot-password">
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <div class="form-group">
        <label>New Password:</label>
        <input type="password" name="new_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Reset Password</button>
</form>