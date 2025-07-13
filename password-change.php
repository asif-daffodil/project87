<?php 
require_once('header.php'); 
// Check if the user is logged in
if(!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if(isset($_POST['change-password'])) {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    // Check if current password is correct
    $check_password_query = "SELECT * FROM users WHERE email='{$_SESSION['user']['email']}'";
    $check_password_result = mysqli_query($conn, $check_password_query);

    if(mysqli_num_rows($check_password_result) > 0) {
        $user = mysqli_fetch_assoc($check_password_result);
        // Verify password
        if(strlen($newPassword) < 6) {
            $errMsg = "<div class='alert alert-danger'>New password must be at least 6 characters long.</div>";
        } else if($newPassword === $currentPassword) {
            $errMsg = "<div class='alert alert-danger'>New password cannot be the same as current password.</div>";
        }else if($newPassword !== $confirmPassword) {
            $errMsg = "<div class='alert alert-danger'>New password and confirm password do not match.</div>";
        }else{
            if(password_verify($currentPassword, $user['pass'])) {
                // Update password in the database
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $update_password_query = "UPDATE users SET pass='$hashed_password' WHERE email='{$_SESSION['user']['email']}'";
                $update_password_result = mysqli_query($conn, $update_password_query);
    
                if($update_password_result) {
                    $errMsg = "<div class='alert alert-success'>Password changed successfully.</div>";
                } else {
                    $errMsg = "<div class='alert alert-danger'>Failed to change password.</div>";
                }
            } else {
                $errMsg = "<div class='alert alert-danger'>Incorrect current password.</div>";
            }
        }
    } else {
        $errMsg = "<div class='alert alert-danger'>User not found.</div>";
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-5 p-4 rounded border shadow mx-auto mt-5">
            <?php if(isset($errMsg)) echo $errMsg; ?>
            <h2 class="text-center mb-4">Change Password</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="current-password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current-password" name="current-password" required>
                </div>
                <div class="mb-3">
                    <label for="new-password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new-password" name="new-password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="change-password">Change Password</button>
            </form>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>