<?php

try {
    $database_con = new mysqli('localhost', 'root', '','webshop');
}
catch (mysqli_sql_exception $e){
    echo '<h4>Datenbankverbindung ist fehlgeschlagen! ' .$e.'</h4>';
}

?>