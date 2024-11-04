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
  <title>Каталог | BULLERY</title>
  <link rel="stylesheet" href="./assets/css/normalize.css" />
  <link rel="stylesheet" href="./assets/css/catalog.css" />
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
  <!-- header -->
  <?php include('./header.php'); ?>

  <button id="toggleFiltersButton">Показать фильтр</button>


  <!-- Блок с фильтрами -->
  <div class="filters" id="filters" style="display: none;">
    <label for="minPrice">Минимальная цена:</label>
    <input type="number" id="minPrice" name="minPrice" min="0">
    <label for="maxPrice">Максимальная цена:</label>
    <input type="number" id="maxPrice" name="maxPrice" min="0">
    <label for="style">Стиль:</label>
    <select id="style" name="style">
      <option value="">Выберите стиль</option>
      <option value="Реализм">Реализм</option>
      <option value="Абстракционизм">Абстракционизм</option>
      <option value="Импрессионизм">Импрессионизм</option>

    </select>
    <button onclick="applyFilters()">Применить фильтр</button>
  </div>



  <div class="container">
    <div class="gallery" id="artGallery">

      <?php
      $sql = "SELECT paintings.*, artists.name_artist AS name_artist FROM paintings
      INNER JOIN artists ON paintings.artist_id = artists.artist_id
      WHERE paintings.status = 'утверждено'";
      $result = mysqli_query($link, $sql);
      ?>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <a href="./paint_page.php?id=<?php echo $row['id'] ?>" style="text-decoration:none">
          <div class="artwork">
            <img src="./assets/img/painting/<?php echo $row['image']; ?>" />
            <div class="info_paint">
              <h2><?php echo $row['title']; ?></h2>
              <p><?php echo $row['name_artist']; ?></p>
              <p>Размер: <?php echo $row['size_paint']; ?></p>
              <?php echo '<span class="price_paint">Цена: ' . number_format($row["price"], 0, ',', ' ') . ' ₽</span>' ?>
              <div class="butt">
                <form action="add_to_cart.php" method="post">
                  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                  <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                  <input type="hidden" name="style" value="<?php echo $row['style']; ?>">
                  <button type="submit" class="buy" title="Положить в корзину">Купить в один клик</button>
                </form>
              </div>
            </div>
          </div>
        </a>
      <?php endwhile; ?>

    </div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var buyButtons = document.querySelectorAll('.buy');
    buyButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
        event.preventDefault(); 

        var productId = this.getAttribute('data-product-id');
        var confirmation = confirm('Вы уверены, что хотите добавить этот товар в корзину?');
        
        if (confirmation) {
          addToCart(productId);
        } else {
          alert('Добавление в корзину отменено');
        }
      });
    });

    function addToCart(productId) {
      var confirmationMessage = 'Товар добавлен в корзину';
      alert(confirmationMessage);
    }
  });
</script>


  <script>
    function applyFilters() {
      var artworks = document.querySelectorAll('.artwork');

      var minPrice = parseFloat(document.getElementById('minPrice').value);
      var maxPrice = parseFloat(document.getElementById('maxPrice').value);
      var style = document.getElementById('style').value;

      artworks.forEach(function(artwork) {
        var price = parseFloat(artwork.querySelector('[name="price"]').value);
        var artworkStyle = artwork.querySelector('[name="style"]').value;

        var isVisible = true;

        if (!isNaN(minPrice) && price < minPrice) {
          isVisible = false;
        }
        if (!isNaN(maxPrice) && price > maxPrice) {
          isVisible = false;
        }
        if (style && artworkStyle !== style) {
          isVisible = false;
        }

        if (isVisible) {
          artwork.style.display = 'block';
        } else {
          artwork.style.display = 'none';
        }
      });
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var toggleFiltersButton = document.getElementById('toggleFiltersButton');
      var filters = document.getElementById('filters');

      toggleFiltersButton.addEventListener('click', function() {
        if (filters.style.display === 'none') {
          filters.style.display = 'block';
          toggleFiltersButton.textContent = 'Скрыть фильтр';
        } else {
          filters.style.display = 'none';
          toggleFiltersButton.textContent = 'Показать фильтр';
        }
      });
    });
  </script>




  <!-- footer -->

  <?php
  include('./footer.php');
  ?>

</body>

</html>