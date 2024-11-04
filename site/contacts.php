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
  <title>Контакты | BULLERY</title>
  <link rel="stylesheet" href="./assets/css/normalize.css" />
  <link rel="stylesheet" href="./assets/css/contacts.css" />
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
<?php include('./header.php'); ?>

  <div class="flex-container">
    <div class="left-block">
      <div class="custom-form">
        <h3>Пишите нам по любым вопросам</h3>
        <form method="post" name="custom_feedback_form" enctype="multipart/form-data">
          <div class="form-group">
            <label for="custom_name">Имя <span>*</span>:</label>
            <input type="text" id="custom_name" name="custom_name" required>
          </div>
          <div class="form-group">
            <label for="custom_email">E-mail <span>*</span>:</label>
            <input type="email" id="custom_email" name="custom_email" required>
          </div>
          <div class="form-group">
            <label for="custom_phone">Номер телефона:</label>
            <input type="text" id="custom_phone" name="custom_phone">
          </div>
          <div class="form-group">
            <label for="custom_message">Сообщение <span>*</span>:</label>
            <textarea id="custom_message" name="custom_message" required></textarea>
          </div>
          <div class="form-group">
            <label for="custom_files">Файлы:</label>
            <input type="file" id="custom_files" name="custom_files[]" multiple>
          </div>
          <div class="form-group">
            <label for="custom_captcha">Введите код с картинки <span>*</span>:</label>
            <input type="text" id="custom_captcha" name="custom_captcha" required>
          </div>
          <button type="submit" class="custom-button">Отправить</button>
        </form>
      </div>
    </div>
    <div class="right-block">
      <div class="contact-info">
        <h3>Контакты</h3>
        <p>Электронная почта: art@bullery.ru</p>
        <p>Телефоны (пн-пт с 10:00 до 20:00)</p>
        <p>+7 (980) 123-45-67</p>
        <p>Профессиональное сотрудничество с дизайнерами</p>
      </div>
    </div>
  </div>

  <!-- footer -->
  <?php
  include('./footer.php');
  ?>

</body>

</html>