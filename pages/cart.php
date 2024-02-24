<?php
echo '<div style="background-color:whitesmoke; opacity:0.9; margin-top:5em; padding:1px;">'; 
echo '<form method="post" action="index.php?page=5">';
$ruser = '';
if (!isset($_SESSION['reg']) || $_SESSION['reg'] == "") {
    $ruser = "cart";
} else {
    $ruser = $_SESSION['reg'];
}

//подсчёт итоговой стоимости за все продукты в корзине
$total = 0;
foreach ($_COOKIE as $key => $val) {
    $pos = strpos($key, "_");
    if (substr($key, 0, $pos) == $ruser) {
        $id = substr($key, $pos + 1);   //$id=$val;
        $item = Item::ShowfromDb($id);
        $total += $item->price;
        $item->DrawForCart();
    }
}
//кнопка - создать заказ. попадают данные в таблицу cart
echo '<hr';
echo "<span style='margin-left:10px;'> Итоговая стоимость: </span> <span>" . $total . "</span><br>";
echo '<button type="submit" class="btn btn-success" name="suborder" style="margin-left:10px; font-size:25px; background-color:#F4A900;">Заказать</button>';
echo '</form>';
if (isset($_POST['suborder'])) {
    foreach ($_COOKIE as $key => $val) {
        $pos = strpos($key, "_");
        if (substr($key, 0, $pos) == $ruser) {
            $id = substr($key, $pos + 1);
            $item = Item::ShowfromDb($id);
            $item->Order();
        }
    }
?>
    <script>
        function DeleteAll(uname) {
            var array = document.cookie.split(';');
            for (i = 0; i < array.length; i++) {
                if (array[i - 1].indexOf(uname) === 1) {
                    var thrCookie = array[i - 1].split('=');
                    var date = new Date(new Date().getTime() - 60000);
                    document.cookie = theCookie[0] + "=id; path=/ expires=" + date.toUTCString();
                }
            }
        }
    </script>
<?php
    echo '</div>';
    echo"<script>";
    echo "eraseCookie('$ruser');";
    echo "window.location=document.URL;";
    echo "</script>";
}
?>
