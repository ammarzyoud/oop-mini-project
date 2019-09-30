<?php

include_once 'config/database.php';
include_once 'models/category.php';
include_once 'models/product.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);
$product = new Product($db);

// header
include_once "layout/header.php";
?>
<form class="mt-5" action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post">
    <label><b>Add Product</b></label>
    <hr>
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="name" class="form-control" name="name" placeholder="Product Name">
    </div>
    <div class="form-group">
        <label for="price">Product Price</label>
        <input type="text" class="form-control" name="price" placeholder="Price">
    </div>
    <div class="form-group">
        <label for="Description">Description</label>
        <textarea type="text" class="form-control" name="description" placeholder="Description"></textarea>
    </div>

    <div>
        <!--    Loop in assoc array and extract name into options   -->
        <?php
        $stmt = $category->read();

        echo "<select class='form-control btn btn-secondary dropdown-toggle w-25' type=\"button\" id=\"dropdownMenuButton\"
                            data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" name='category_id'>";
        echo "<option>Select category...</option>";
        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($category);
            echo "<option value='{$id}'>{$name}</option>";
        }

        echo "</select>";
        ?>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Add Product</button>
</form>

<!--POST Method-->
<?php
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){

    // set product property values
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];

    // create the product
    if($product->create()){
        echo "<div class='alert alert-success'>Product was created.</div>";
    }

    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}
?>
<!--End POST Method-->

<?php
// footer
include_once "layout/footer.php";
?>




