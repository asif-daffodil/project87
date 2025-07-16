<?php 
require_once('header.php'); 
// Check if the user is logged in
if(!isset($_SESSION['user'])) {
    header("Location: sign-in.php");
    exit();
}

if(isset($_POST['upload_picture'])) {
    // Handle the file upload
    if(isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] == 0) {
        $file = $_FILES['profile-picture'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp', 'image/bmp'];
        
        // Check file type
        if(in_array($file['type'], $allowedTypes)) {
            $uploadDir = './images/';
            $fileName = uniqid('profile_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $uploadFilePath = $uploadDir . $fileName;

            // Move the uploaded file
            if(move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                // Delete if previous image exists
                if($_SESSION['user']['pic']) {
                    $previousFilePath = $uploadDir . $_SESSION['user']['pic'];
                    if(file_exists($previousFilePath)) {
                        unlink($previousFilePath);
                    }
                }
                // Update user profile picture in session or database
                $_SESSION['user']['pic'] = $fileName;
                $query = "UPDATE users SET pic = '$fileName' WHERE email = '{$_SESSION['user']['email']}'";
                mysqli_query($conn, $query);
                header("Location: profile-picture.php");
                exit();
            } else {
                $errMsg = "Failed to upload the file.";
            }
        } else {
            $errMsg = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
    } else {
        $errMsg = "No file uploaded or there was an error uploading the file.";
    }
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-5 p-4 rounded border shadow mx-auto mt-5">
            <?php if(isset($errMsg)) echo $errMsg; ?>
            <h2 class="text-center mb-4">Profile Picture</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profile-picture" class="form-label text-center d-block">
                        <img src="<?= $_SESSION['user']['pic'] ? './images/'.$_SESSION['user']['pic']: './images/pp.webp' ?>" alt="" class="img-fluid rounded-circle mb-2 img-thumbnail" style="width: 150px; height: 150px;" id="profile-pic-preview">
                        <p><i class="fa-solid fa-user"></i> Upload Profile Picture</p>
                    </label>
                    <input type="file" class="form-control" id="profile-picture" name="profile-picture" accept="image/*" required>
                </div>
                <button type="submit" name="upload_picture" class="btn btn-primary w-100">Upload Picture</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('profile-picture').addEventListener('change', function() {
        const file = this.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-pic-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?php require_once('footer.php'); ?>