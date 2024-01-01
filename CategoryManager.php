<?php
class CategoryManager
{
  private $db;

  public function __construct()
  {
    $this->db = new DbConnection();
  }

  public function deleteCategory($category_id)
  {
    $conn = $this->db->getConnection();
    $sql = "DELETE FROM categories WHERE category_id = '$category_id'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
      return true;
    } else {
      return false;
    }
  }

  public function updateCategory($categoryId, $categoryName)
  {
    $conn = $this->db->getConnection();

    try {
      $this->validateCategoryName($categoryName);
      $sql = "UPDATE categories SET category_name = '$categoryName' WHERE category_id = '$categoryId'";

      if ($conn->query($sql) === TRUE) {
        return true;
      } else {
        return false;
      }
    } catch (InvalidArgumentException $e) {
      return $e->getMessage();
    }
  }

  public function addCategory($name)
  {
    $conn = $this->db->getConnection();
    try {
      $this->validateCategoryName($name);
      $sql = "INSERT INTO categories (category_name) VALUES ('$name')";

      if ($conn->query($sql) === TRUE) {
        return true;
      } else {
        return false;
      }
    } catch (InvalidArgumentException $e) {
      return $e->getMessage();
    }
  }

  public function getCategoryNameById($category_id)
  {
    $conn = $this->db->getConnection();

    $sql = "SELECT category_name FROM categories WHERE category_id = '$category_id'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $category = $row['category_name'];
    }

    return $category;
  }

  public function getCategories()
  {
    $conn = $this->db->getConnection();

    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    $categories = array();

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $category = new Category(
          $row['category_id'],
          $row['category_name']
        );
        $categories[] = $category;
      }
    }

    return $categories;
  }

  private function validateCategoryName($name)
  {
    if (empty($name)) {
      throw new InvalidArgumentException("Category name cannot be empty.");
    }
  }
}
