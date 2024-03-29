<?php
class Category
{
  private $category_id;
  private $category_name;

  public function __construct($category_id, $category_name)
  {
    $this->category_id = $category_id;
    $this->category_name = $category_name;
  }

  public function getCategoryId()
  {
    return $this->category_id;
  }

  public function getCategoryName()
  {
    return $this->category_name;
  }
}
