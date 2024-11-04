<?php
include("connect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Карточка | BULLERY</title>
  <link rel="stylesheet" href="./assets/css/normalize.css" />
  <link rel="stylesheet" href="./assets/css/paintpage.css" />
  <link rel="stylesheet" href="./assets/css/style.css" />
  <script defer src="./assets/js/main.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>
<body>
  <?php include('./header.php'); ?>
  <div class="artwork-container">
    <?php
    if (isset($_GET['id'])) {
      $catalog_id = $_GET['id'];
      $conn = mysqli_connect("localhost", "root", "123", "kama");
      if (!$conn) {
        die("Ошибка подключения: " . mysqli_connect_error());
      }
      $sql_lectures = "SELECT paintings.*, artists.name_artist AS name_artist FROM paintings
        INNER JOIN artists ON paintings.artist_id = artists.artist_id
        WHERE paintings.id = $catalog_id";
      $result_lectures = mysqli_query($conn, $sql_lectures);
      if (mysqli_num_rows($result_lectures) > 0) {
        while ($row = mysqli_fetch_assoc($result_lectures)) {
                    echo "<a class='artwork-image/ href='' rel='|Фотографии' id='0'>
                    <img title='" . $row['name_artist'] . ' ' . $row['title'] . "' src='./assets/img/painting/" . $row['image'] . "' />
                    </a>";
          echo "<div class='artwork-info'>";
          echo "<h2>{$row['title']}</h2><br />";
          echo "<span class='artwork-name'>{$row['name_artist']}</span>";
          echo "<span class='artwork-size'>{$row['size_paint']}см</span>";
          echo "<div>Материалы: <span class='artwork-material'>холст, масло</span></div>";
          echo "<div>Год: <span class='artwork-year'>{$row['date']}</span></div>";
          echo "<div>Описание: <span class='artwork-description'>{$row['description']}</span></div>";
          echo "</div>";
          echo "<div class='artwork-buy'>";
          echo "<form method = 'post' class = 'corzina'>";
          echo "<div class='price'><label>Цена:</label> {$row['price']}руб</div>";
          echo "<span class='btn'>";
          echo "<button name = 'david' class='orange addToCart' data-product-id='{$row['id']}'>";
          echo "<span class='incart'>В корзину</span>";
          echo "<input type='hidden' name='id' value='{$row['id']}'>";
          echo "</button>";
          echo "</span>";
          echo "</form>";
          echo "</div>";
          
        }
      } else {
        echo "Картины не найдены.";
      }
    } else {
      echo "Картины не найдены.";
    }
    ?>
  </div>
  <?php include('./footer.php'); ?>


  <?php 
  
  if (isset($_POST ['david'])) {
    $product_id = $_POST ['id'];
    $user_id = $_SESSION['user_id'];
    $add = mysqli_query($link, "INSERT INTO cart_items (product_id, user_id) VALUES ($product_id, $user_id)");
  }
  ?>

</body>

</html>


