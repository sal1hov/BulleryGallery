<header>
    <nav>
      <div class="container_header">
        <a href="./index.php" class="logo">BULLERY</a>
        <div class="menu-toggle">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <ul class="menu">
          <li><a href="./index.php" class="active">Главная</a></li>
          <li><a href="./catalog.php">Каталог</a></li>
          <li><a href="./artist.php">Художники</a></li>
          <li><a href="./contacts.php">Контакты</a></li>
          <li><a href="./auction.php">Аукцион</a></li>
        </ul>
        <ul class="twobuttons">
          <li><a href="./cart.php">Корзина</a></li>
          <?php
            session_start();
            if(isset($_SESSION['user_id'])){
                echo '<li><a href="./profile.php">Личный кабинет</a></li>';
                echo '<li><a href="./logout.php">Выйти</a></li>';
            } else {
                echo '<li><a href="./auth.php">Личный кабинет</a></li>';
            }
          ?>
        </ul>
      </div>
    </nav>
  </header>