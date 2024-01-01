<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
include 'CategoryManager.php';
include 'Category.php';
include 'DbConnection.php';

$categoryManager = new CategoryManager();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
  $categoryName = $_POST['category_name'];

  $resultMessage = $categoryManager->addCategory($categoryName);

  $categories = $categoryManager->getCategories();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_category'])) {
  $categoryId = $_POST['edit_category_id'];
  $categoryName = $_POST['edit_category_name'];

  $resultMessage = $categoryManager->updateCategory($categoryId, $categoryName);

  $categories = $categoryManager->getCategories();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_category_id'])) {
  $deleteCategoryId = $_GET['delete_category_id'];
  $categoryManager->deleteCategory($deleteCategoryId);
  $categories = $categoryManager->getCategories();
}

$categories = $categoryManager->getCategories();
?>

<?php include 'head.php'; ?>

<body>
  <?php include 'navbar.php'; ?>
  <main class="container" style="padding-top:5rem; padding-bottom:3rem;height: 100%;">
    <div class="content py-5">
      <!-- Add Category Modal -->
      <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="category-name" class="form-label">Category Name:</label>
                  <input type="text" class="form-control" id="category-name" name="category_name">
                </div>
                <button type="submit" class="btn btn-primary" name="add_category">Add Category</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Category Modal -->
      <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <input type="hidden" id="edit_category_id" name="edit_category_id">
                <div class="mb-3">
                  <label for="edit_category_name" class="form-label">Category Name:</label>
                  <input type="text" class="form-control" id="edit_category_name" name="edit_category_name">
                </div>
                <button type="submit" class="btn btn-primary" name="edit_category">Save Changes</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php if (isset($resultMessage)) { ?>
        <div class="text-danger mt-3"><?php echo $resultMessage; ?></div>
      <?php } ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $category) {
          ?>
            <tr>
              <td><?php echo $category->getCategoryId(); ?></td>
              <td><?php echo $category->getCategoryName(); ?></td>
              <td>
                <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-category-id="<?php echo $category->getCategoryId(); ?>" data-category-name="<?php echo $category->getCategoryName(); ?>">Edit</a>
                <a href="?delete_category_id=<?php echo $category->getCategoryId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add New Category</button>


    </div>
  </main>
  <?php include 'footer.php' ?>