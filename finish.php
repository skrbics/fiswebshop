<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Simple Shopping Cart using Session in PHP</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
  <?php
$conn = new mysqli('localhost', 'fisuser', 'fis', 'fisexample');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO orders (firstName,lastName,email,address,country,zip,".
        "ccname,ccnumber,ccexpiration,cccvv) VALUES (".
          "'".$_POST['firstName']."',".
          "'".$_POST['lastName']."',".
          "'".$_POST['email']."',".
          "'".$_POST['address']."',".
          "'".$_POST['country']."',".
          "'".$_POST['zip']."',".
          "'".$_POST['cc-name']."',".
          "'".$_POST['cc-number']."',".
          "'".$_POST['cc-expiration']."',".
          "'".$_POST['cc-cvv']."')";
$conn->query($sql);
$lastID = "".$conn->insert_id;
$i = 0;
while($i<count($_SESSION['cart'])){

  $sql = "INSERT INTO orderlist (prodid, orderid, quantity) VALUES (".
          $_SESSION['cart'][$i].",".
          $lastID.",".
          $_SESSION['qty_array'][$i].")";
          $conn->query($sql);
          $i++;
}
if ($conn->sqlstate === "00000") {?>
    <div class="row"> <div class="col-sm-6"> <div class="alert alert-info text-center"> Thank you for your purchase! </div> </div> </div>
<?php
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
</body>
</html>
