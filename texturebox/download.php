<?php
  $filename = $_GET['filename'];
  $originalPath = "uploads/original/".$filename;
  $upscaledPath = "uploads/upscaled/".$filename;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Texturebox - <?php echo $filename ?></title>
</head>
<body>
  <h1>Texturebox - <?php echo $filename ?></h1>
  <h2>Preview:</h2>
  <img src="<?php echo $upscaledPath ?>" alt="Texture Preview">
  <br>
  <a href="<?php echo $originalPath ?>" download>Download Original Texture</a>
</body>
</html>
