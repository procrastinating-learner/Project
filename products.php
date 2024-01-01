<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
include 'ProductManager.php';
include 'CategoryManager.php';
include 'Product.php';
include 'Category.php';
include 'DbConnection.php';
include 'ImageUploader.php';

$productManager = new ProductManager();
$categoryManager = new CategoryManager();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply_filter'])) {
  $filteredCategoryId = $_POST['filter_category'];
  if (isset($filteredCategoryId) && $filteredCategoryId != "all")
    $products = $productManager->getProductsByCategoryId($filteredCategoryId);
  else {
    $products = $productManager->getAllProducts();
  }
} else {
  $products = $productManager->getAllProducts();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
  $productName = $_POST['product_name'];
  $productDescription = $_POST['product_description'];
  $productPrice = $_POST['product_price'];
  $productStockQuantity = $_POST['product_stock_quantity'];
  $productCategory = $_POST['product_category'];
  $productDetails = $_POST['product_details'];

  $imageUploader = new ImageUploader("images/");
  $uploadedImage = $imageUploader->uploadImage($_FILES["product_image"]);

  if ($uploadedImage) {
    $resultMessage = $productManager->addProduct($productName, $productDescription, $productPrice, $productStockQuantity, $uploadedImage, $productCategory, $productDetails);
  } else {
    $resultMessage = 'Image not valid';
  }

  $products = $productManager->getAllProducts();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
  $productId = $_POST['edit_product_id'];
  $productName = $_POST['edit_product_name'];
  $productDescription = $_POST['edit_product_description'];
  $productPrice = $_POST['edit_product_price'];
  $productStockQuantity = $_POST['edit_product_stock_quantity'];
  $productCategory = $_POST['edit_product_category'];
  $productDetails = $_POST['edit_product_details'];

  $resultMessage = $productManager->updateProduct($productId, $productName, $productDescription, $productPrice, $productStockQuantity, $productCategory, $productDetails);

  $products = $productManager->getAllProducts();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_product_id'])) {
  $deleteProductId = $_GET['delete_product_id'];
  $productManager->deleteProduct($deleteProductId);
  $products = $productManager->getAllProducts();
}

$allCategories = $categoryManager->getCategories();
?>

<?php include 'head.php'; ?>

<body>
  <?php include 'navbar.php'; ?>
  <main class="container" style="padding-top:5rem; padding-bottom:3rem;height: 100%;">
    <div class="content py-5">
      <!-- Add Product Modal -->
      <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="product-name" class="form-label">Product Name:</label>
                  <input type="text" class="form-control" id="product-name" name="product_name">
                </div>
                <div class="mb-3">
                  <label for="product-category" class="form-label">Product Category:</label>
                  <select class="form-select" name="product_category">
                    <?php
                    foreach ($allCategories as $category) {  ?>
                      <option value="<?php echo $category->getCategoryId(); ?>"><?php echo $category->getCategoryName(); ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="product-description" class="form-label">Product Description:</label>
                  <input type="text" class="form-control" id="product-description" name="product_description">
                </div>
                <div class="mb-3">
                  <label for="product-price" class="form-label">Product Price:</label>
                  <input type="text" class="form-control" id="product-price" name="product_price">
                </div>
                <div class="mb-3">
                  <label for="product-quantity" class="form-label">Product Quantity:</label>
                  <input type="number" class="form-control" id="product-quantity" name="product_stock_quantity">
                </div>
                <div class="mb-3">
                  <label for="product-image" class="form-label">Product Image Name:</label>
                  <input type="file" class="form-control" id="product_image" name="product_image">
                </div>
                <div class="mb-3">
                  <label for="product-details" class="form-label">Product Details:</label>
                  <input type="text" class="form-control" id="product-details" name="product_details">
                </div>
                <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Product Modal -->
      <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <input type="hidden" id="edit_product_id" name="edit_product_id">
                <div class="mb-3">
                  <label for="edit_product_name" class="form-label">Product Name:</label>
                  <input type="text" class="form-control" id="edit_product_name" name="edit_product_name">
                </div>
                <div class="mb-3">
                  <label for="edit_product_category" class="form-label">Product Category:</label>
                  <select class="form-select" name="edit_product_category" id="edit_product_category">
                    <?php
                    foreach ($allCategories as $category) { ?>
                      <option value="<?php echo $category->getCategoryId(); ?>"><?php echo $category->getCategoryName(); ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="edit_product_description" class="form-label">Product Description:</label>
                  <input type="text" class="form-control" id="edit_product_description" name="edit_product_description">
                </div>
                <div class="mb-3">
                  <label for="edit_product_price" class="form-label">Product Price:</label>
                  <input type="text" class="form-control" id="edit_product_price" name="edit_product_price">
                </div>
                <div class="mb-3">
                  <label for="edit_product_stock_quantity" class="form-label">Product Quantity:</label>
                  <input type="number" class="form-control" id="edit_product_stock_quantity" name="edit_product_stock_quantity">
                </div>
                <div class="mb-3">
                  <label for="edit_product_details" class="form-label">Product Details:</label>
                  <input type="text" class="form-control" id="edit_product_details" name="edit_product_details">
                </div>
                <button type="submit" class="btn btn-primary" name="edit_product">Save Changes</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <form method="post" action="">
        <div class="mb-3">
          <label for="filter_category" class="form-label">Filter by Category:</label>
          <select class="form-select" name="filter_category" id="filter_category">
            <option value="all">All Categories</option>
            <?php
            foreach ($allCategories as $category) {  ?>
              <option value="<?php echo $category->getCategoryId(); ?>"><?php echo $category->getCategoryName(); ?></option>
            <?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" name="apply_filter">Apply Filter</button>
      </form>

      <?php if (isset($resultMessage)) { ?>
        <div class="text-danger mt-3"><?php echo $resultMessage; ?></div>
      <?php } ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) {
            $productDetails = $productManager->getProductDetailsById($product->getProductId());

          ?>
            <tr>
              <td><?php echo $product->getProductId(); ?></td>
              <td><?php echo $product->getName(); ?></td>
              <td><?php echo $product->getDescription(); ?></td>
              <td><?php echo $product->getPrice(); ?></td>
              <td><?php echo $product->getStockQuantity(); ?></td>
              <td><?php echo $product->getCategory(); ?></td>
              <td>
                <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="<?php echo $product->getProductId(); ?>" data-product-name="<?php echo $product->getName(); ?>" data-product-category="<?php echo $product->getCategoryId(); ?>" data-product-category-name="<?php echo $product->getCategory(); ?>" data-product-description="<?php echo $product->getDescription(); ?>" data-product-details="<?php echo $productDetails; ?>" data-product-price="<?php echo $product->getPrice(); ?>" data-product-stock-quantity="<?php echo $product->getStockQuantity(); ?>">Edit</a>
                <a href="?delete_product_id=<?php echo $product->getProductId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Product</button>


    </div>
  </main>
  <?php include 'footer.php' ?>