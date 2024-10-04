<?php

 include_once ("db-connect.php");
 
if(isset($_POST["post"])){
	$name =  $_POST["item"];
	$price = $_POST["price"];
	$image = $_FILES["image"]["name"];
	$tmpName = $_FILES["image"]["tmp_name"];
	$uploadOk ="";
	
	$target = "uploads/" .basename($image);
	
	if(file_exists($target)){
		echo"sorry, file already exists";
		$uploadOk = 0;
	}
	
	if(move_uploaded_file($tmpName , $target)){
		echo "<br>";
	  echo "file uploaded successful";
	  header('Location:index.php');
   }else{
	   echo "file not uploaded";
   }
   
	
	$sql ="INSERT INTO shopping (name , price , image)
	       VALUES('$name', '$price', '$image')";
   if(mysqli_query($conn, $sql)){
	   echo "added successfully";
		echo"<br>";
	 }else{
	   echo "error" .$sql . "<br>". mysqli_error($conn);
	}
  
   mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add image to cart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<form method="post"  enctype="multipart/form-data">
<div class="form-group">
<label for = "item" >NAME</label>
<input type ="text" id="item" name="item"  placeholder ="name of item" class="form-control" />
</div>

<div class="form-group">
<label for = "price">PRICE</label>
<input type ="text" id="price" name="price" placeholder ="price of item" class="form-control" />
</div>

<div class="form-group">
<label for = "image">IMAGE</label>
<input type ="file" id="image" name="image" placeholder ="picture of item " class= "form-control" />
</div>

<input type="submit" class="btn btn-success btn-block "value="POST" name="post" />
</form>
</body>