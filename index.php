<?php
session_start();

include_once("db-connect.php");
//session_destroy();

  if(isset($_POST['add_cart'])){
	  
	  if(isset($_SESSION['cart'])){
		  
	  $session_array_id = array_column($_SESSION['cart'], "id");
	  
	  if (!in_array($_GET['id'],$session_array_id)){
		  
		 $session_array = array(
		"id" => $_GET['id'],
		"name" => $_POST['name'],
		"price" => $_POST['price'],
		"quantity" => $_POST['quantity']
		);
		
		$_SESSION['cart'][] = $session_array; 
	  }
	
	
		
	}else{
		$session_array = array(
		"id" => $_GET['id'],
		"name" => $_POST['name'],
		"price" => $_POST['price'],
		"quantity" => $_POST['quantity']
		);
		
		$_SESSION['cart'][] = $session_array;
	}
  }

$sql = "SELECT * FROM shopping ORDER BY id DESC";
$result = mysqli_query($conn, $sql );
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add item to cart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 <style>
.img-container{
	width:200px;
	height:300px;
	background-color:#bbb;
	width: 200px;
	margin:8px;
	padding:6px;
}

 </style>
</head>
<body>

<br><br>
<div class="container">

 <ul class="nav nav-tabs">
   <li class="nav-item">
    
     <a class="nav-link  active " data-toggle="tab" href="#product" >PRODUCT</a>
   </li>
   <li class="nav-item">
     <a class="nav-link" data-toggle="tab" href="#cart">CART
	 <span class="badge badge-danger badge-pill"><?php if(isset($_SESSION['cart'])){
		  echo count($_SESSION['cart']);
	 }else{
		echo '0' ;
	 } ?></span>
	 </a> 
   </li>
 </ul>
   
<div class="row">
   <div class="col-sm">
  <h3 class="text-center text-lg" id="product">MY SHOPPING CART</h3>
   
      <?php foreach($result AS $product){ ?>
 <div style="  margin: 5px;  float: left; ">
  <form method="post" action="index.php?id=<?php echo $product['id'] ?> " >
    <div class="border border-primary rounded text-center img-container " >
       <img class = 'img-fluid rounded'<?php echo " src='uploads/" .$product['image']."'>" ?>
       <h4> <?php echo $product['name']; ?> </h4>
       <h4  class= 'text-danger'> $<?php echo $product['price'];  ?></h4>
   <div class="form-group">
      <input type ="text" class="form-control  text-center" name="quantity" value="1">
   </div>

     <input type="hidden" name="name" value="<?php  echo $product['name'];?>" >
     <input type="hidden" name="price" value="<?php  echo $product['price'];?>" >
     <input type="submit" name="add_cart" class="btn btn-warning text-light w-75"
     value="Add to cart" >

</div>
</form>
</div>
<?php } ?>


</div>
   
  <div class="col-sm">
  
  <h3 class="text-center" id="cart"> SELECTED ITEMS </h3>
  <?php
  
 $output="";
 $total="0";
 
 $output .= '
 <table class="table table-striped table-bordered">
 <tr>
 <th> ID </th> 
 <th> NAME </th>
 <th> PRICE </th>
 <th> QUANTITY </th>
 <th> TOTAL </th>
 <th> ACTION </th>
 </tr>
 
 ';
  
  if(!empty($_SESSION['cart'])){
	  
	  
	  foreach($_SESSION['cart'] as $key => $value){
		  $output .= "
		  <tr>			  
		  <td>".$value['id']."</td>
		  <td>".$value['name']."</td>
		  <td>".$value['price']."</td>
		  <td>".$value['quantity']."</td>
		  <td>".number_format($value['price'] * $value['quantity'],2)."</td>
		  <td>
		  <a href='index.php?action=remove&id=".$value['id']."'> 
          <button type='button' class='btn btn-danger btn-block'>Remove</button>
		  </a>
		  </td>
		
		  ";
		  
		  $total = $total + $value['quantity'] * $value['price'];
	  }
	  
	  $output .= "
	  <tr>
	  <td colspan='3'></td>
	  <td><b>Total Price</b></td>
	  <td>".number_format($total,2)."</td>
	  <td>
	  <a href='index.php?action=clearall'>
	  <button class='btn btn-warning btn-block'>Clear All</button>
	  </a>
	  </td>
	  </tr>
	  ";
  }
  
  
 echo $output;
 
 
  ?>
 
  
</div>

 </div>

<?php

if (isset($_GET['action'])){
	
	if($_GET['action']=="clearall"){
		unset($_SESSION['cart']);
	}
	
	if($_GET['action']=="remove"){
		
		foreach ($_SESSION['cart'] as $key => $value){
			if ($value['id']==$_GET['id']){
				unset($_SESSION['cart'][$key]);
			}
		}
	}
}


?>
</body>
</html>