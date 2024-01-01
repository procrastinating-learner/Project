<?php

class Product
{
  private $product_id;
  private $name;
  private $description;
  private $price;
  private $stock_quantity;
  private $category;
  private $image;
  private $db;

  public function __construct($product_id, $name, $description, $price, $stock_quantity, $category, $image)
  {
    $this->product_id = $product_id;
    $this->name = $name;
    $this->description = $description;
    $this->price = $price;
    $this->stock_quantity = $stock_quantity;
    $this->category = $category;
    $this->image = $image;
    $this->db = new DbConnection();
  }

  public function getProductId()
  {
    return $this->product_id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function getStockQuantity()
  {
    return $this->stock_quantity;
  }

  public function getCategory()
  {
    $categoryManager = new CategoryManager();
    $cat = $categoryManager->getCategoryNameById($this->category);
    return $cat;
  }

  public function getCategoryId()
  {
    return $this->category;
  }

  public function getImage()
  {
    return $this->image;
  }
}
