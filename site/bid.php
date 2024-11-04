<?php

include("connect.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lot_id = $_POST['lot_id'];

    if (isset($_POST['bid_amount']) && is_numeric($_POST['bid_amount'])) {
        $bid_amount = intval($_POST['bid_amount']); 
        $bid_time = date('Y-m-d H:i:s');
        $winning_bid = 0;
        $start_price_query = "SELECT start_price FROM lots WHERE id = '$lot_id'";
        $start_price_result = mysqli_query($link, $start_price_query);
        
        if ($start_price_result && mysqli_num_rows($start_price_result) > 0) {
            $start_price_row = mysqli_fetch_assoc($start_price_result);
            $start_price = intval($start_price_row['start_price']);

            if ($bid_amount >= $start_price) {
                $insertBidQuery = "INSERT INTO bids (lot_id, user_id, amount, bid_time, winning_bid) VALUES ('$lot_id', '{$_SESSION['user_id']}', '$bid_amount', '$bid_time', '$winning_bid')";
                $insertBidResult = mysqli_query($link, $insertBidQuery);

                if ($insertBidResult) {

                    echo "<script>alert('Ставка успешно размещена!'); window.location.href = 'auction.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Произошла ошибка при размещении ставки: " . mysqli_error($link) . "');</script>";
                }
            } else {
                echo "<script>alert('Ошибка: Ставка должна быть больше или равна стартовой цене.'); window.location.href = 'auction.php';</script>";
            }
        } else {
            echo "<script>alert('Произошла ошибка при размещении ставки: " . mysqli_error($link) . "');</script>";
        }
    } else {
        echo "<script>alert('Ошибка: Неверное значение ставки.');</script>";
    }
}

?>
