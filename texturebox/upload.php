<?php
if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
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
    if($imageFileType != "png") {
      echo "Sorry, only PNG files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $uploadedFilePath = $target_dir.basename( $_FILES["fileToUpload"]["name"]);
        $originalImg = imagecreatefrompng($uploadedFilePath);
        $upscaledImg = imagecreatetruecolor(256, 256);
        imagecopyresampled($upscaledImg, $originalImg, 0, 0, 0, 0, 256, 256, 16, 16);
        $originalPath = $target_dir."original/".basename( $_FILES["fileToUpload"]["name"]);
        $upscaledPath = $target_dir."upscaled/".basename( $_FILES["fileToUpload"]["name"]);
        imagepng($originalImg, $originalPath);
        imagepng($upscaledImg, $upscaledPath);
        imagedestroy($originalImg);
        imagedestroy($upscaledImg);
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br>";
        echo "Download link: <a href=\"download.php?filename=". basename( $_FILES["fileToUpload"]["name"]). "\">". basename( $_FILES["fileToUpload"]["name"]). "</a><br>";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
 }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Texturebox - Upload</title>
</head>
<body>
    <h1>Texturebox - Upload</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select texture to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</body>
</html>
