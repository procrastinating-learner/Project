<?php
include_once 'DbConnection.php';
include_once 'Product.php';
include_once 'ProductManager.php';
include 'head.php';
include 'icons.php';
include 'navbar.php';

$productManager = new ProductManager();

if (isset($_GET['id'])) {
  $productId = $_GET['id'];
  $product = $productManager->getProductById($productId);
  $productDetails = $productManager->getProductDetailsById($productId);
  if ($product) {
?>
    <div class="bg-light-blue mb-5 overflow-x-hidden pb-3" style="padding-top: 8rem;">
      <div class="row">
        <div class="col-md-3">
          <img src="<?php echo $product->getImage(); ?>" alt="<?php echo $product->getName(); ?>" class="img-fluid">
        </div>
        <div class="col-md-9 product-details" style="justify-content: center;display: flex;flex-direction: column;">
          <p class="text-black"><strong>Name:</strong> <?php echo $product->getName(); ?></p>
          <p class="text-black"><strong>Price:</strong> <?php echo $product->getPrice(); ?> MAD</p>
          <p class="text-black"><strong>Description:</strong> <?php echo $product->getDescription(); ?></p>
          <p class="text-black"><strong>Details:</strong> <?php echo $productDetails; ?></p>
        </div>
      </div>
    </div>

<?php
  } else {
    echo 'Product not found.';
  }
} else {
  echo 'Product ID not provided.';
}
include 'footer.php'
?>