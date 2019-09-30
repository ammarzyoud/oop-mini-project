<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$from_record = (1000 * $page) - 1000;

include_once 'config/database.php';
include_once 'models/product.php';
include_once 'models/category.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$category = new Category($db);

$stmt = $product->readAll($from_record, 1000);
$num = $stmt->rowCount();

// header
include_once "layout/header.php";
?>

<?php
if ($num > 0) {

    echo "<table class='table table-hover table-responsive table-bordered mt-5'>";
    echo "<tr>";
    echo "<th>Product</th>";
    echo "<th>Price</th>";
    echo "<th>Description</th>";
    echo "<th>Category</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        echo "<tr>";
        echo "<td>{$name}</td>";
        echo "<td>{$price}</td>";
        echo "<td>{$description}</td>";
        echo "<td>";
        $category->id = $category_id;
        $category->readName();
        echo $category->name;
        echo "</td>";

        echo "<td>";
        echo "
            <a href='update_product.php?id={$id}' class='btn btn-info left-margin'>
                <span class='glyphicon glyphicon-edit'></span> Edit
            </a>
            
             <a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                <span class='glyphicon glyphicon-list'></span> Read
            </a>
             
            <a delete-id='{$id}' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Delete
            </a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div class='text-danger'>Error No Products Found</div>";
}
?>

<?php
// footer
include_once "layout/footer.php";
?>