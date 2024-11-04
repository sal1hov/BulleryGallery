<?php
include("connect.php");
session_start();

$activeLotsQuery = "SELECT lots.*, paintings.title AS painting_title, paintings.id AS painting_id, lots.end_time AS end_time FROM lots JOIN paintings ON lots.id = paintings.lot_id WHERE lots.status = 'active'";
$activeLotsResult = mysqli_query($link, $activeLotsQuery);


?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Аукцион | BULLERY</title>
    <link rel="stylesheet" href="./assets/css/normalize.css" />
    <link rel="stylesheet" href="./assets/css/auction.css" />
</head>

<body>
    <?php include('./header.php'); ?>
    <section class="auction-container">
        <div class="container">
            <h1 class="auction-heading">Аукцион</h1>
            <?php
            if ($activeLotsResult) {
                if (mysqli_num_rows($activeLotsResult) > 0) {
                    while ($lot = mysqli_fetch_assoc($activeLotsResult)) {
                        echo '<div class="auction-lot">';
                        echo '<div class="lot-details">';
                        echo '<h2 class="lot-title"><a href="./paint_page.php?id=' . $lot['painting_id'] . '">' . $lot['painting_title'] . '</a></h2>';
                        echo '<p class="lot-description">' . $lot['description'] . '</p>';
                        echo '<p class="lot-price">Стартовая цена: ' . $lot['start_price'] . '₽</p>';
                        $endTimeUnix = strtotime($lot['end_time']);

                        echo '<p class="auction-end-time" data-end-time="' . date("Y-m-d H:i:s", $endTimeUnix) . '"></p>';

                        $lastBidQuery = "SELECT * FROM bids WHERE lot_id = {$lot['id']} ORDER BY bid_time DESC LIMIT 1";
                        $lastBidResult = mysqli_query($link, $lastBidQuery);

                        if ($lastBidResult && mysqli_num_rows($lastBidResult) > 0) {
                            $lastBid = mysqli_fetch_assoc($lastBidResult);
                            echo '<p class="last-bid">Последняя ставка: ' . $lastBid['amount'] . '₽</p>';
                        } else {
                            echo '<p class="no-bids">Пока нет ставок</p>';
                        }

                        echo '<div class="bid-form">';
                        if (time() < $endTimeUnix) {
                            echo '<form action="bid.php" method="post">';
                            echo '<input type="hidden" name="lot_id" value="' . $lot['id'] . '">';
                            echo '<input type="number" name="bid_amount" placeholder="Ваша ставка" required>';
                            echo '<input type="submit" value="Сделать ставку">';
                            echo '</form>';
                        } else {

                            echo '<p class="auction-closed">Лот закрыт</p>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="no-lots">На данный момент нет активных лотов.</p>';
                }
            } else {

                echo '<p class="error-message">Произошла ошибка при выполнении запроса: ' . mysqli_error($link) . '</p>';
            }
            ?>


        </div>
    </section>

    <script>
        window.onload = function() {

            setInterval(function() {
                var elements = document.getElementsByClassName("auction-end-time");
                for (var i = 0; i < elements.length; i++) {
                    var endTime = new Date(elements[i].getAttribute("data-end-time"));
                    var currentTime = new Date();
                    var timeLeft = endTime - currentTime;

                    if (timeLeft <= 0) {

                        elements[i].innerHTML = "<p class='auction-closed'>Аукцион завершен</p>";

                        var bidForm = elements[i].parentNode.querySelector('.bid-form');
                        if (bidForm) {
                            bidForm.innerHTML = "<p class='auction-closed'>Лот закрыт</p>";
                        }
                    } else {
                        var daysLeft = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        var hoursLeft = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutesLeft = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        var secondsLeft = Math.floor((timeLeft % (1000 * 60)) / 1000);
                        elements[i].innerHTML = "Окончание аукциона через: " + daysLeft + " дн. " + hoursLeft + " ч. " + minutesLeft + " мин. " + secondsLeft + " сек.";
                    }
                }
            }, 1000);
        };
    </script>


    <!-- footer -->
    <?php include('./footer.php'); ?>
</body>

</html>