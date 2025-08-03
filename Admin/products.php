<?php
require_once('./header.php');

// select all categories from the database


if (isset($_POST['addProduct'])) {
    $productName = $_POST['productName'];
    $productCategory = $_POST['productCategory'];
    $productPrice = $_POST['productPrice'];
    $productDescription = trim(htmlspecialchars(stripslashes($_POST['productDescription'])));
    $productImage = $_FILES['productImage']['name'];
    $productImageTemp = $_FILES['productImage']['tmp_name'];

    // new image name to avoid conflicts
    $productImage = time() . '_' . $productImage;

    $query = "INSERT INTO products(`name`, `category_id`, `price`, `description`, `image`) VALUES('$productName', $productCategory, $productPrice, '$productDescription', '$productImage')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        move_uploaded_file($productImageTemp, "../images/products/$productImage");
        echo "<script>Swal.fire('Success', 'Product added successfully.', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error', 'Failed to add product. Please try again.', 'error');</script>";
    }
}

$query = "SELECT * FROM categories ORDER BY id DESC";
$catResult = mysqli_query($conn, $query);

// select all products from the database
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);

?>
<div class="container-fluid">
    <div class="row vh-100 overflow-y-scroll position-relative flex p-0">
        <?php
        require_once('./navbar.php');
        ?>
        <div class="col-12 d-flex p-0">
            <div class="bg-dark text-white px-3 overflow-y-scroll flex-shrink-0 py-5" style="width: 260px;">
                <?php require_once('./sidebar.php'); ?>
            </div>
            <div class="flex-grow-1 overflow-y-scroll py-5">
                <div class="row">
                    <div class="col-md-12 py-4">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#category">Manage
                            Category</button>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#product">Add New
                            Product</button>
                    </div>
                    <?php if ($result->num_rows > 0) { ?>
                        <div class="col-md-12">
                            <table class="table table-striped" id="productTable">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sn = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $sn++ . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['category_id'] . "</td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        echo "<td style='max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>" . $row['description'] . "</td>";
                                        echo "<td><img src='../images/products/" . $row['image'] . "' alt='" . $row['name'] . "' width='50'></td>";
                                        echo "<td>
                                        <button class='btn btn-sm btn-primary'>Edit</button>
                                        <button class='btn btn-sm btn-danger'>Delete</button>
                                    </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
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
                        <?php if ($catResult->num_rows > 0) { ?>
                            <table class="table table-striped" id="categoryTable">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="categoryTableBody">

                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p>No categories found.</p>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" id="addCategoryForm">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" data-id=""
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="addCategory" id="addCatBtn">Add
                                Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- full screen product modal -->
<div class="modal fade" id="product" tabindex="-1" aria-labelledby="productLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Product management content goes here -->
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" id="addProductForm">
                    <!-- Add your product form fields here -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="productCategory" class="form-label">Category</label>
                        <select class="form-select" id="productCategory" name="productCategory" required>
                            <option value="">Select Category</option>
                            <?php while ($row = mysqli_fetch_assoc($catResult)) { ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="productDescription" name="productDescription" rows="3"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addProduct">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // get all categories using AJAX
    const getCatData = () => {
        $.ajax({
            url: '/admin/ajax/get_all_category.php',
            type: 'GET',
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    let rows = '';
                    response.data.forEach((category, index) => {
                        rows += `<tr id="cat-${category.id}">
                        <td>${index + 1}</td>
                        <td>${category.name}</td>
                        <td>
                            <button class='btn btn-sm btn-primary' onclick='editCat(${category.id})'>Edit</button>
                            <button class='btn btn-sm btn-danger' onclick='delCat(${category.id})'>Delete</button>
                        </td>
                    </tr>`;
                    });

                    // Destroy previous DataTable if exists
                    if ($.fn.DataTable.isDataTable('#categoryTable')) {
                        $('#categoryTable').DataTable().clear().destroy();
                    }

                    $('#categoryTableBody').html(rows);

                    // Re-initialize DataTable
                    $('#categoryTable').DataTable({
                        "lengthMenu": [5, 10, 25, 50, 100],
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error fetching the categories.',
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

    getCatData();

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
                    url: '/admin/ajax/delete_category.php',
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
                            })
                            // Reload the categories table and data table
                            getCatData();
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
            url: '/admin/ajax/get_category.php',
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
                    $('#categoryName').data('id', response.data.id);
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

    // Handle form submission for adding/updating category
    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        if ($('#addCatBtn').text().trim().replace(/\s+/g, ' ') === 'Add Category') {
            $.ajax({
                url: '/admin/ajax/add_category.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Optionally, you can reload the categories table or append the new category
                        $('#addCategoryForm')[0].reset();
                        getCatData();

                    } else {
                        Swal.fire(
                            'Error!',
                            response.error,
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

        if ($('#addCatBtn').text() === 'Update Category') {
            // Update category logic
            const id = $('#categoryName').data('id'); // Assuming you set the ID in data-id attribute
            $.ajax({
                url: '/admin/ajax/update_category.php',
                type: 'POST',
                data: {
                    id: id,
                    categoryName: $('#categoryName').val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        Swal.fire({
                            title: 'Updated!',
                            text: 'Category updated successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Reload the categories table and data table
                        getCatData();
                        $('#addCategoryForm')[0].reset();
                        $('#addCatBtn').text('Add Category');
                    } else {
                        Swal.fire(
                            'Error!',
                            response.error,
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
    });

    $('#productTable').DataTable({
        "lengthMenu": [5, 10, 25, 50, 100],
    });
</script>