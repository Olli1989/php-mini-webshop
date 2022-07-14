<?php 
    include_once('header.php');
    include_once('database/database_con.php');
?>


<main>

    <?php
        $select = "SELECT * FROM products";

        try {
            $result = $database_con->query($select);

            $additionalProducts = [];
            $additionalProductsDetails = [];

            if($result->num_rows>0){

                while($row = $result->fetch_assoc()){

                    if($row['product_id']==$_GET['productid'] ){
                        echo '<div>';
                            echo '<div class="row detail-hero">';
                                echo '<img class="col-6" src="'.$row['product_picture'].'">';
                                echo '<div class="col-6 detail-desc">';
                                    echo '<h2>'.$row['product_name'].'</h2>';
                                    echo '<p>'.$row['product_description'].'</p>';
                                    echo '<div class="detail_add_cart">';
                                        echo '<input id="detailAddCartInput" type="text" value="1">';
                                        $productid = $row['product_id'];
                                        $productprice = $row['product_price'];
                                        $productpicture = '"' . $row['product_picture'] . '"';
                                        $productname = '"'.$row['product_name'].'"';                                      
                                        echo "<i id='detailAddCart' class='add_card fa-solid fa-cart-plus' data-id=$productid data-price=$productprice data-picture=$productpicture data-name=$productname></i>";
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    } else if(count($additionalProducts)<3) {
                        $additionalProductsDetails[0] = $row['product_id'];
                        $additionalProductsDetails[1] = $row['product_picture'];
                        array_push($additionalProducts, $additionalProductsDetails);
                    }

                }

            }

            $select2 = "SELECT * FROM products WHERE product_id not like '". $_GET['productid']."' ORDER BY RAND() LIMIT 3";

            $result = $database_con->query($select2);
            echo '<div>';
                echo '<h3>Diese Produkte könnte Sie auch interessieren</h3>';
                echo '<div class="row">';

            if($result->num_rows>0){
                while($row = $result->fetch_assoc()){

                    echo '<div class="col-4">';
                        echo '<a href="productdetail.php?productid='.$row['product_id'].'"><img src="'.$row['product_picture'].'"></a>';
                    echo '</div>';

                }
            }
                echo '</div>';
            echo '</div>';


        } catch(mysqli_sql_exception $e){
            echo '<h4>Produkte konnten nicht geladen werden!</h4>';
        }
    ?>


</main>

<?php 
    $database_con->close();
    include_once('footer.php');
?>