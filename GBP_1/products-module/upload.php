<?php
$target_dir = "../img/";

$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);
$target_file = $target_dir . $newfilename;

// Resize
$width = 180;
$height = 80;
$ratio = $width/$height;
if($ratio > 1) {
    $new_width = 300;
    $new_height = 300/$ratio;
}
else {
    $new_width = 300*$ratio;
    $new_height = 300;
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $file_path = $_FILES["fileToUpload"]["tmp_name"];
  if (file_exists($file_path)) {
    $check = getimagesize($file_path);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  } else {
    echo "File not found.";
    $uploadOk = 0;
  }
}
// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
   
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $src = imagecreatefromstring(file_get_contents($target_file));
    $dst = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagedestroy($src);
    imagepng($dst, $target_file);
    imagedestroy($dst);

    echo "The file ". htmlspecialchars( basename( $target_file)). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}