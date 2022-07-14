<?php
include_once('header.php');
include_once('database/database_con.php');
?>


<main>

    <?php
    $select = "SELECT * FROM products";

    try {
        $result = $database_con->query($select);

        if ($result->num_rows > 0) {
            echo '<div class="row flex-wrap">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-4 shop">';
                echo '<a href="productdetail.php?productid=' . $row['product_id'] . '"><img src="' . $row['product_picture'] . '"></a>';
                echo '<div class="shop_add">';
                echo '<span class="product_price">' . $row['product_price'] . '€</span>';
                echo '<div>';
                $productid = $row['product_id'];
                $productprice = $row['product_price'];
                $productpicture = '"' . $row['product_picture'] . '"';
                $productname = '"'.$row['product_name'].'"';
                echo "<i class='shopAddCart add_card fa-solid fa-cart-plus' onclick='addToCart(1,$productid,$productpicture,$productprice,$productname)' ></i>";
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    } catch (mysqli_sql_exception $e) {
        echo '<h4>Produkte konnten nicht geladen werden!</h4>';
    }
    ?>


</main>

<?php
$database_con->close();
include_once('footer.php');
?>