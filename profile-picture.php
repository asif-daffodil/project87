<?php 
require_once('header.php'); 
// Check if the user is logged in
if(!isset($_SESSION['user'])) {
    header("Location: sign-in.php");
    exit();
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
                        <img src="<?= $_SESSION['user']['pic'] ? './images/'.$_SESSION['user']['pic']: './images/pp.webp' ?>" alt="" class="img-fluid rounded-circle mb-2 img-thumbnail" style="width: 150px; height: 150px;">
                        <p><i class="fa-solid fa-user"></i> Upload Profile Picture</p>
                    </label>
                    <input type="file" class="form-control" id="profile-picture" name="profile-picture" accept="image/*" required>
                </div>
                <button type="submit" name="upload_picture" class="btn btn-primary w-100">Upload Picture</button>
            </form>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>