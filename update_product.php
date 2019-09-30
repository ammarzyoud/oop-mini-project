<?php
include_once "layout/header.php";
?>
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

?>

<?php
if($_POST){

    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];

    if($product->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
        echo "Product was updated.";
        echo "</div>";
    }
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
        echo "Unable to update product.";
        echo "</div>";
    }
}
?>
    <h1 class="text-center">Update Product</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" class="container">
    <div>
        <label>Name</label>
        <input type='text' name='name' value='<?php echo $product->name; ?>' class='form-control' />
    </div>
        <div>
            <label>Price</label>
            <input type='text' name='price' value='<?php echo $product->price; ?>' class='form-control' />
        </div>
        <div>
            <label>Description</label>
            <textarea name='description' class='form-control'><?php echo $product->description; ?></textarea>
        </div>

        <div>
            <label>Category</label>
            <div>
                <?php
                $stmt = $category->read();

                // put them in a select drop-down
                echo "<select class='form-control btn btn-secondary dropdown-toggle w-25' name='category_id'>";

                echo "<option>Please select...</option>";
                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $category_id=$row_category['id'];
                    $category_name = $row_category['name'];

                    // current category of the product must be selected
                    if($product->category_id==$category_id){
                        echo "<option value='$category_id' selected>";
                    }else{
                        echo "<option value='$category_id'>";
                    }

                    echo "$category_name</option>";
                }
                echo "</select>";
                ?>
            </div>
        </div>
        <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
<?php
echo "<div class='mt-3'>";
echo "<a href='index.php' class='btn btn-success'>Read Products</a>";
echo "</div>";
//footer
include_once "layout/footer.php";
?>