<?php 
    require_once('header.php'); 
    // Check if the user is logged in
    if(!isset($_SESSION['user'])) {
        header("Location: sign-in.php");
        exit();
    }
    // Handle form submission for updating settings
    if(isset($_POST['update_settings'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        // Check if email already exists
        $check_email_query = "SELECT * FROM users WHERE email='$email' AND email != '{$_SESSION['user']['email']}'";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if(mysqli_num_rows($check_email_result) > 0) {
            $errMsg = "<div class='alert alert-danger'>Email already exists. Please use a different email.</div>";
        }else{
            // Update user settings in the database
            $update_query = "UPDATE users SET name='$name', email='$email' WHERE email='{$_SESSION['user']['email']}'";
            $update_result = mysqli_query($conn, $update_query);

            if($update_result) {
                // Update session data
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
                $errMsg = "<div class='alert alert-success'>Settings updated successfully.</div>";
                // Redirect to settings page to reflect changes
                header("Location: settings.php");
            } else {
                $errMsg = "<div class='alert alert-danger'>Failed to update settings.</div>";
            }
        }
    }

    
?>
<div class="container">
    <div class="row">
        <div class="col-md-5 p-4 rounded border shadow mx-auto mt-5">
            <?php if(isset($errMsg)) echo $errMsg; ?>
            <h2 class="text-center mb-4">Settings</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION['user']['name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['user']['email'] ?>" required>
                </div>
                <button type="submit" name="update_settings" class="btn btn-primary w-100">Update Settings</button>
            </form>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>