<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];

        $sql = "INSERT INTO cart_items (user_id, product_id) VALUES ('$user_id', '$product_id')";
        $result = mysqli_query($link, $sql);

        if ($result) {
            header("Location: cart.php");
            exit;
        } else {
            echo 'Ошибка при добавлении товара в корзину: ' . mysqli_error($link);
        }
    } else {
        echo '<script>alert("Для добавления товара в корзину необходимо авторизоваться."); window.location.href = "catalog.php";</script>';
        exit;
    }
} else {
    echo 'Недопустимый метод запроса';
}
?>
