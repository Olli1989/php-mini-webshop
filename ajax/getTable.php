<?php
if(count($_POST)!=0){

    $myObject = json_decode($_POST['webshop']);
}
if (isset($myObject)) {
    $totalamount = 0;
    $return = '<div class="overflow-table"><table>';
    $return .= "<tr><th>ID</th><th>Image</th><th>Name</th><th>Menge</th><th>Preis</th><th>Summe</th><tr>";

    if ($myObject != null) {

        foreach ($myObject as $key => $productarray) {

            $return .= "<tr>";
            $return .= "<td>" . $key . "</td>";
            $return .= "<td><a href='productdetail.php?productid=" . $key . "'><img src='" . $productarray[1] . "'></a></td>";
            $return .= "<td><p>" . $productarray[3] . "</p></td>";
            $return .= "<td><div class='cart_amount'><input onInput='checkInput(this)' class='cartAddInput' type='text' value='" . $productarray[0] . "'><button onClick='updateCart(this," . $key . ")'>aktualisieren</button><button onClick='deleteProduct(" . $key . ")'>artikel löschen</button></div></td>";
            $return .= "<td><p>" . $productarray[2] . "€</p></td>";
            $return .= "<td><p>" . $productarray[0] * $productarray[2] . "€</p></td>";
            $return .= "</tr>";

            $totalamount += $productarray[0] * $productarray[2];
        }
    }

    $return .= "<tr><td colspan='6'><p>Gesamtsumme: <span class='highlight'>$totalamount €</span></p></td></tr>";
    $return .= '</table></div>';


    $return .= '<div class="btn btn-clear" onClick="clearCart()">Warenkorb leeren</button>';

    echo $return;
} else {
    echo '<h3>Es befinden sich noch keine Produkte im Warenkorb</h3>';
}
