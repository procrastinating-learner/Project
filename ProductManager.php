<?php
class ProductManager
{
  private $db;

  public function __construct()
  {
    $this->db = new DbConnection();
  }

  public function deleteProduct($product_id)
  {
    $conn = $this->db->getConnection();
    $sql = "DELETE FROM product_details WHERE product_id = '$product_id'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
      $sql = "DELETE FROM products WHERE product_id = '$product_id'";
      $result = $conn->query($sql);
      return true;
    } else {
      return false;
    }
  }

  public function getProductById($id)
  {
    $conn = $this->db->getConnection();

    $sql = "SELECT * FROM products WHERE product_id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $product = new Product(
        $row['product_id'],
        $row['name'],
        $row['description'],
        $row['price'],
        $row['stock_quantity'],
        $row['category_id'],
        $row['image']
      );
    }

    return $product;
  }

  public function getProductDetailsById($id)
  {
    $conn = $this->db->getConnection();

    $sql = "SELECT details FROM product_details WHERE product_id = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    return $row['details'];
  }

  public function getAllProducts()
  {
    $conn = $this->db->getConnection();

    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    $products = array();

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $product = new Product(
          $row['product_id'],
          $row['name'],
          $row['description'],
          $row['price'],
          $row['stock_quantity'],
          $row['category_id'],
          $row['image']
        );
        $products[] = $product;
      }
    }

    return $products;
  }

  public function updateProduct($productId, $name, $description, $price, $stockQuantity, $category, $productDetails)
  {
    $conn = $this->db->getConnection();

    try {
      $this->validateName($name);
      $this->validateDescription($description);
      $this->validateProductDetails($productDetails);
      $this->validatePrice($price);
      $this->validateStockQuantity($stockQuantity);
      $sqlProduct = "UPDATE products SET name = '$name', description = '$description', price = '$price', stock_quantity = '$stockQuantity', category_id = '$category' WHERE product_id = '$productId'";

      if ($conn->query($sqlProduct) === TRUE) {
        $sqlDetails = "UPDATE product_details SET details = '$productDetails' WHERE product_id = '$productId'";

        if ($conn->query($sqlDetails) === TRUE) {
          return true; // Both product and details updated successfully
        } else {
          return false; // Details update failed
        }
      } else {
        return false; // Product update failed
      }
    } catch (InvalidArgumentException $e) {
      return $e->getMessage();
    }
  }


  public function addProduct($name, $description, $price, $stockQuantity, $image, $category, $productDetails)
  {
    $conn = $this->db->getConnection();
    try {
      $this->validateName($name);
      $this->validateDescription($description);
      $this->validateProductDetails($productDetails);
      $this->validatePrice($price);
      $this->validateStockQuantity($stockQuantity);
      $sqlProduct = "INSERT INTO products (name, description, price, stock_quantity, image, category_id) VALUES ('$name', '$description', '$price', '$stockQuantity', '$image', '$category')";

      if ($conn->query($sqlProduct) === TRUE) {
        $productId = $conn->insert_id;

        $sqlDetails = "INSERT INTO product_details (product_id, details) VALUES ('$productId', '$productDetails')";

        if ($conn->query($sqlDetails) === TRUE) {
          return true;
        } else {
          // Rollback the product insertion if details insertion fails
          $conn->query("DELETE FROM products WHERE product_id = '$productId'");
          return false;
        }
      } else {
        return false; // Product insertion failed
      }
    } catch (InvalidArgumentException $e) {
      return $e->getMessage();
    }
  }

  public function getProductsByCategoryId($category_id)
  {
    $conn = $this->db->getConnection();

    $sql = "SELECT * FROM products WHERE category_id = '$category_id'";
    $result = $conn->query($sql);

    $products = array();

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $product = new Product(
          $row['product_id'],
          $row['name'],
          $row['description'],
          $row['price'],
          $row['stock_quantity'],
          $row['category_id'],
          $row['image']
        );
        $products[] = $product;
      }
    }

    return $products;
  }

  private function validateName($name)
  {
    if (empty($name)) {
      throw new InvalidArgumentException("Name cannot be empty.");
    }
  }

  private function validateDescription($description)
  {
    if (empty($description)) {
      throw new InvalidArgumentException("Description cannot be empty.");
    }
  }

  private function validateProductDetails($productDetails)
  {
    if (empty($productDetails)) {
      throw new InvalidArgumentException("Product details cannot be empty.");
    }
  }

  private function validatePrice($price)
  {
    if (!is_numeric($price) || $price <= 0) {
      throw new InvalidArgumentException("Price must be a positive numeric value.");
    }
  }

  private function validateStockQuantity($stockQuantity)
  {
    if (!is_int($stockQuantity) || $stockQuantity < 0) {
      throw new InvalidArgumentException("Stock quantity must be a non-negative integer value.");
    }
  }
}
