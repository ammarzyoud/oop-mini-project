<?php
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

include_once 'config/database.php';
include_once 'models/product.php';
include_once 'models/category.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$category = new Category($db);

$product->id = $id;

$product->readOne();

// header
include_once "layout/header.php";

echo "<table class='table table-bordered mt-5'>";

echo "<tr>";
echo "<td>Name</td>";
echo "<td>{$product->name}</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Price</td>";
echo "<td>&#36;{$product->price}</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Description</td>";
echo "<td>{$product->description}</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Category</td>";
echo "<td>";
$category->id = $product->category_id;
$category->readName();
echo $category->name;
echo "</td>";
echo "</tr>";

echo "</table>";

echo "<div>";
echo "<a href='index.php' class='btn btn-primary mt-3'>Read Products</a>";
echo "</div>";

// footer
include_once "layout/footer.php";
?>