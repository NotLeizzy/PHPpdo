<?php
require 'config.php';

if (isset($_POST['add'])) {
   
$name = $_POST['name'];
$email = $_POST['email'];  
$product = $_POST['product'];   
$amount = $_POST['amount'];

//insert sa users table
$stmt = $pdo->prepare("INSERT INTO  users (name, email) 
VALUES (?, ?)");
$stmt->execute([$name, $email]);

//get the last inserted user id
$users_id = $pdo->lastInsertId();

//Insert into orders the user id

$stmt2 = $pdo->prepare("INSERT INTO orders (users_id, product, amount)
VALUES (?, ?, ?)");
$stmt2->execute([$users_id, $product, $amount]);

echo "User and Order added successfully!";
}
?>