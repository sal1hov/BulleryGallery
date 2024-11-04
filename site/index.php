<?php
include("connect.php");
session_start();

mysqli_set_charset($link, "utf8");

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BULLERY | Онлайн Галерея</title>
  <link rel="stylesheet" href="./assets/css/normalize.css" />
  <link rel="stylesheet" href="./assets/css/style.css" />
  <script defer src="./assets/js/main.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
  <!-- header -->
  <?php
  include('./header.php');
  ?>

  <!-- main -->
  <main>
    <section class="fullpage-image">
      <img src="./assets/img/bc.jpg" alt="background" />
      <div class="image-text">
        <h1>BULLERY</h1>
        <h2>ИСКУССТВО ЗАВТРАШНЕГО ДНЯ УЖЕ СЕГОДНЯ</h2>
        <section id="animate">
          <a href="#catalog">Каталог</a>
        </section>
      </div>
    </section>

    <!-- Избранные работы -->

    <section class="glavtext_razmer" id="catalog">
      <div class="container">
        <div class="glavtext">
          <h2>Избранные работы</h2>
        </div>
      </div>
    </section>

    <div class="container">
      <div class="catalog">
        <?php
        $sqlFetchData = "SELECT * FROM paintings WHERE izbran = 1";
        $result = mysqli_query($link, $sqlFetchData);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="item">
                <div class="item-cont">
                    <a href="paint_page.php?id=' . $row["id"] . '">
                        <img src="./assets/img/painting/' . $row["image"] . '" alt="' . $row["title"] . '" class="img">
                    </a>
                    <div class="buttons">
                        <span class="buy" title="Положить в корзину"><img src="./assets/img/cartshop.jpg" class="cart_logo"></span>
                    </div>
                    <div class="name">
                        <a href="paint_page.php?id=' . $row["id"] . '">' . $row["title"] . '</a>
                    </div>
                    <div class="info">
                        <a href="paint_page.php?id=' . $row["id"] . '">' . $row["name_artist"] . '</a>
                    </div>
                    <div class="price">Цена: ' . number_format($row["price"], 0, ',', ' ') . ' ₽</div>
                    <div class="one-click">
                        <a class="button_card" href="paint_page.php?id=' . $row["id"] . '">Купить картину в 1 клик</a>
                    </div>
                </div>
            </div>';
          }
        } else {
          echo "<p>Все картины распроданы ¯\_(ツ)_/¯</p>";
        }
        ?>
      </div>
    </div>

    </div>
    <div class="button_all">
      <a class="button btn-wide" href="./catalog.php">Смотреть всю коллекцию</a>
    </div>
    </div>
  </main>

  <br /><br /><br />

  <!-- Новинки -->

  <section class="new_art_glav">
    <section class="glavtext_razmer">
      <div class="container">
        <div class="glavtext">
          <h2>Новинки</h2>
        </div>
      </div>
    </section>

    <div class="container">
      <div class="catalog">
        <?php
        $sqlFetchData = "SELECT * FROM paintings WHERE izbran = 2";
        $result = mysqli_query($link, $sqlFetchData);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="item">
                <div class="item-cont">
                    <a href="paint_page.php?id=' . $row["id"] . '">
                        <img src="./assets/img/painting/' . $row["image"] . '" alt="' . $row["title"] . '" class="img">
                    </a>
                    <div class="buttons">
                        <span class="buy" title="Положить в корзину"><img src="./assets/img/cartshop.jpg" class="cart_logo"></span>
                    </div>
                    <div class="name">
                        <a href="paint_page.php?id=' . $row["id"] . '">' . $row["title"] . '</a>
                    </div>
                    <div class="info">
                        <a href="paint_page.php?id=' . $row["id"] . '">' . $row["name_artist"] . '</a>
                    </div>
                    <div class="price">Цена: ' . number_format($row["price"], 0, ',', ' ') . ' ₽</div>
                    <div class="one-click">
                        <a class="button_card" href="paint_page.php?id=' . $row["id"] . '">Купить картину в 1 клик</a>
                    </div>
                </div>
            </div>';
          }
        } else {
          echo "<p>Все картины распроданы ¯\_(ツ)_/¯</p>";
        }
        ?>
      </div>
    </div>
    <div class="button_all">
      <a class="button btn-wide" href="./catalog.php">Смотреть всю коллекцию</a>
    </div>
  </section>

  <!-- footer -->
  <?php
  include('./footer.php');
  ?>
</body>

</html>