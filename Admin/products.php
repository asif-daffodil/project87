<?php
require_once('./header.php');



// addCategory
if (isset($_POST['addCategory'])) {
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $insertQuery = "INSERT INTO categories (name) VALUES ('$categoryName')";
    if (mysqli_query($conn, $insertQuery)) {
        // Add sweetalert success message
        echo "<script>
            Swal.fire({
                title: 'Success',
                text: 'Category added successfully!',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,

            })
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// select all categories from the database
$query = "SELECT * FROM categories ORDER BY id DESC";
$catResult = mysqli_query($conn, $query);
?>
<div class="container-fluid">
    <div class="row vh-100 overflow-hidden position-relative flex p-0">
        <?php
        require_once('./navbar.php');
        ?>
        <div class="col-12 d-flex p-0">
            <div class="bg-dark text-white px-3 overflow-y-scroll flex-shrink-0 py-5" style="width: max-content;">
                <?php require_once('./sidebar.php'); ?>
            </div>
            <div class="flex-grow-1 overflow-y-scroll py-5">
                <div class="row">
                    <div class="col-md-12 py-4">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#category">Manage Category</button>
                    </div>
                </div>
            </div>
            <?php
            require_once('./footer.php');
            ?>
        </div>
    </div>
</div>

<!-- full screen category modal -->
<div class="modal fade" id="category" tabindex="-1" aria-labelledby="categoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryLabel">Manage Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Category management content goes here -->
                <div class="row">
                    <div class="col-md-6">
                        <?php if ($catResult->num_rows > 0) {  ?>
                            <table class="table table-striped" id="categoryTable">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sn = 1;
                                    while ($row = mysqli_fetch_assoc($catResult)) {
                                        echo "<tr>
                                        <td>{$sn}</td>
                                        <td>{$row['name']}</td>
                                        <td>
                                            <button class='btn btn-sm btn-primary' onclick='editCat({$row['id']})'>Edit</button>
                                            <button class='btn btn-sm btn-danger' onclick='delCat({$row['id']})'>Delete</button>
                                        </td>
                                      </tr>";
                                        $sn++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p>No categories found.</p>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="addCategory" id="addCatBtn">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let table = new DataTable('#categoryTable', {
        "lengthMenu": [5, 10, 25, 50, 100],
    });

    const delCat = id => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to delete the category
                $.ajax({
                    url: 'delete_category.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your category has been deleted.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Reload the page to see the changes
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the category.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an error processing your request.',
                            'error'
                        );
                    }
                });
            }
        })
    }

    const editCat = id => {
        // Fetch the category data using AJAX
        $.ajax({
            url: 'get_category.php',
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    // Populate the form with the category data
                    $('#categoryName').val(response.data.name);
                    // Show the modal
                    $('#addCatBtn').text('Update Category');
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error fetching the category data.',
                        'error'
                    );
                }
            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'There was an error processing your request.',
                    'error'
                );
            }
        });
    }
</script>