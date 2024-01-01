<?php
class ImageUploader
{
  private $targetDirectory;

  public function __construct($targetDirectory)
  {
    $this->targetDirectory = $targetDirectory;
  }

  public function uploadImage($file)
  {
    $targetFile = $this->targetDirectory . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
      // File is an image
      $uploadOk = 1;
    } else {
      // File is not an image
      $uploadOk = 0;
    }
    if ($file["size"] > 50000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      return false;
    } else {
      if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // File uploaded successfully
        return $targetFile;
      } else {
        echo "Sorry, there was an error uploading your file.";
        return false;
      }
    }
  }
}
