<?php
include("connect.php");
session_start();
$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];


    $sql_delete = "DELETE FROM cart_items WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $result_delete = mysqli_query($link, $sql_delete);

    if (!$result_delete) {
        echo "Ошибка при удалении товара: " . mysqli_error($link);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_button'])) {

    $sql_delete_cart_item = "DELETE FROM cart_items WHERE user_id = '$user_id'";
    $result_delete_cart_item = mysqli_query($link, $sql_delete_cart_item);
    if (!$result_delete_cart_item) {
        echo "Ошибка при удалении товара из корзины: " . mysqli_error($link);
    }
}

$sql_select = "SELECT * FROM paintings, cart_items WHERE paintings.id = cart_items.product_id AND cart_items.user_id = $user_id";

$result_select = mysqli_query($link, $sql_select);


if ($result_select && mysqli_num_rows($result_select) > 0) {

    $cart_items = [];
    $total_price = 0; 
    while ($row = mysqli_fetch_assoc($result_select)) {
        $cart_items[] = $row;
        $total_price += $row['price']; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Корзина | BULLERY</title>
    <link rel="stylesheet" href="./assets/css/normalize.css" />
    <link rel="stylesheet" href="./assets/css/cart.css" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
    <?php include('./header.php'); ?>

    <div class="container main-content">
        <h1 class="title-left">Корзина</h1>
        <table class="responsive-form cart-table">
            <colgroup>
                <col />
                <col width="100%" />
                <col width="10%" /> 
            </colgroup>
            <thead>
                <tr>
                    <th></th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th></th> 
                </tr>
            </thead>
            <tbody>
                <?php
                // Проверяем наличие данных
                if (!empty($cart_items)) {
                    foreach ($cart_items as $item) {
                        $title = $item["title"];
                        $price = $item["price"];
                        $image = $item["image"];
                        echo "<tr>
                                <td><img src='./assets/img/painting/{$item['image']}' alt='$title' class='product-image'></td>
                                <td>$title</td>
                                <td class='price-cell'>$price ₽</td>
                                <td>
                                    <form action='' method='post'> <!-- Убираем вызов JavaScript -->
                                        <input type='hidden' name='product_id' value='{$item['product_id']}'>
                                        <button type='submit' name='delete_product' class='delete-button'>Удалить</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Корзина пуста</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        if (!empty($cart_items)) {
            echo "<div class='total-price-container'>";
            echo "<div class='total-price'>Итого: $total_price ₽</div>";
            echo "<form action='' method='post' name='cartForm'>";
            echo "<button type='submit' class='pay-button' name='pay_button'>Оплатить</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
    <?php include('./footer.php'); ?>


        <script>
        const payButton = document.getElementById('payButton');

        payButton.addEventListener('click', function(event) {
            alert('Товар оплачен! Спасибо за покупку.');
            window.location.href = 'index.php';
        });
    </script>
</body>

</html>
