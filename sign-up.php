<?php 
    require_once('header.php');

    // Check if the user is already logged in
    if(isset($_SESSION['user'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission
    if(isset($_POST['signup'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $check_email_query = "SELECT * FROM users WHERE email='$email'";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if(mysqli_num_rows($check_email_result) > 0) {
            $errMsg = "<div class='alert alert-danger'>Email already exists. Please use a different email.</div>";
        }

        // check strong password
        if(!isset($errMsg) && strlen($password) < 6) {
            $errMsg = "<div class='alert alert-danger'>Password must be at least 6 characters long.</div>";
        }

        if(!isset($errMsg)) {
            // Insert user into the database
            $query = "INSERT INTO users (name, email, pass) VALUES ('$name', '$email', '$hashed_password')";
            $result = mysqli_query($conn, $query);
    
            if($result) {
                $_SESSION['user'] = [
                    'name' => $name,
                    'email' => $email
                ];
                header("Location: index.php");
                exit();
            } else {
                $errMsg = "<div class='alert alert-danger'>Error signing up. Please try again.</div>";
            }
        }


    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-5 p-4 rounded border shadow mx-auto mt-5">
            <?php if(isset($errMsg)) echo $errMsg; ?>
            <h2 class="text-center mb-4">Sign Up</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
            </form>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>