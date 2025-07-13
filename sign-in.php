<?php 
require_once('header.php'); 
// Check if the user is already logged in
if(isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if(isset($_POST['signin'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists in the database
    $check_email_query = "SELECT * FROM users WHERE email='$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if(mysqli_num_rows($check_email_result) > 0) {
        $user = mysqli_fetch_assoc($check_email_result);

        // Check if password is correct
        if(password_verify($password, $user['pass'])) {
            $_SESSION['user'] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'pic' => $user['pic'] ?? null
            ];
            header("Location: index.php");
            exit();
        } else {
            $errMsg = "<div class='alert alert-danger'>Incorrect password.</div>";
        }
    } else {
        $errMsg = "<div class='alert alert-danger'>Email not found. Please sign up.</div>";
    }
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-5 p-4 rounded border shadow mx-auto mt-5">
            <?php if(isset($errMsg)) echo $errMsg; ?>
            <h2 class="text-center mb-4">Sign In</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="signin" class="btn btn-primary w-100">Sign In</button>
            </form>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>