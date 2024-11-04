<?php
include("connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: logout.php"); 
  exit();
}


$userId = $_SESSION['user_id'];
$fetchUserQuery = "SELECT name, surname FROM users WHERE id = $userId";
$fetchUserResult = mysqli_query($link, $fetchUserQuery);
$userData = mysqli_fetch_assoc($fetchUserResult);

$name = isset($userData['name']) ? $userData['name'] : '';
$surname = isset($userData['surname']) ? $userData['surname'] : '';

// Проверка на удаление аккаунта
if (isset($_POST['del_ak'])) {
  $userId = $_SESSION['user_id'];

  // Удаление аккаунта
  $deleteAccountQuery = "DELETE FROM users WHERE id = $userId";
  $deleteAccountResult = mysqli_query($link, $deleteAccountQuery);

  if ($deleteAccountResult) {
    session_unset();
    session_destroy();
    header("Location: logout.php");
    exit();
  } else {
    echo "Ошибка при удалении аккаунта";
  }
}

// Проверка изменения почты
if (isset($_POST['changeEmail'])) {
  $userId = $_SESSION['user_id'];
  $currentEmail = $_POST['currentEmail'];
  $newEmail = $_POST['newEmail'];

  // Проверка текущей почты
  $checkEmailQuery = "SELECT * FROM users WHERE id = $userId AND email = '$currentEmail'";
  $checkEmailResult = mysqli_query($link, $checkEmailQuery);

  if (mysqli_num_rows($checkEmailResult) > 0) {
    // Обновление почты
    $updateEmailQuery = "UPDATE users SET email = '$newEmail' WHERE id = $userId";
    $updateEmailResult = mysqli_query($link, $updateEmailQuery);

    echo "Почта успешно изменена";
  } else {
    echo "Текущая почта не соответствует вашему аккаунту";
  }
}

// Проверка изменения пароля
if (isset($_POST['changePassword'])) {
  $userId = $_SESSION['user_id'];
  $currentPassword = $_POST['currentPassword'];
  $newPassword = $_POST['newPassword'];

  // Проверка текущего пароля
  $checkPasswordQuery = "SELECT password FROM users WHERE id = $userId";
  $checkPasswordResult = mysqli_query($link, $checkPasswordQuery);
  $hashedPassword = mysqli_fetch_row($checkPasswordResult)[0];

  if ($hashedPassword && password_verify($currentPassword, $hashedPassword)) {
    // Обновление пароля
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updatePasswordQuery = "UPDATE users SET password = '$newHashedPassword' WHERE id = $userId";
    $updatePasswordResult = mysqli_query($link, $updatePasswordQuery);

    echo "Пароль успешно изменен";
  } else {
    echo "Текущий пароль не соответствует вашему аккаунту";
  }
}

// Проверка аутентификации
if (!isset($_SESSION['user_id'])) {
  header("Location: auth.php");
  exit();
}

// Получение идентификатора
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
} else {
  header("Location: auth.php");
  exit();
}

// Запрос заказов
$ordersQuery = "SELECT * FROM orders WHERE user_id = $userId AND (status = 'выполнен' OR status = 'доставлен')";
$ordersResult = mysqli_query($link, $ordersQuery);


// Проверка добавления картины
if (isset($_POST['addPainting'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $size_paint = $_POST['size_paint'];
  $artist_id = $_SESSION['user_id'];

  // Обработка загружаемого файла
  $targetDirectory = "./assets/img/painting/";
  $targetFile = $targetDirectory . basename($_FILES["photo"]["name"]);
  $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

  // Проверка, является ли файл изображением
  $check = getimagesize($_FILES["photo"]["tmp_name"]);
  if($check !== false) {
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      echo "Извините, только JPG, JPEG, PNG файлы разрешены.";
    } else {
      if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        $addPaintingQuery = "INSERT INTO paintings (title, description, price, size_paint, image, artist_id, status) VALUES ('$title', '$description', $price, '$size_paint', '".basename($_FILES["photo"]["name"])."', $artist_id, 'ожидает')";
        $addPaintingResult = mysqli_query($link, $addPaintingQuery);

        if ($addPaintingResult) {
          echo "Картина успешно добавлена и ожидает модерации.";
        } else {
          echo "Ошибка при добавлении картины: " . mysqli_error($link);
        }
      } else {
        echo "Произошла ошибка при загрузке файла.";
      }
    }
  } else {
    echo "Файл не является изображением.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Личный кабинет | BULLERY</title>
  <link rel="stylesheet" href="./assets/css/profile.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
  <link rel="stylesheet" href="./assets/css/normalize.css" />
  <link rel="icon" href="./assets/img/favicon.png" />
  <script src="https://cdn.tailwindcss.com" sync></script>
  <script defer src="./assets/js/profile.js"></script>
</head>

<body>
  <!-- header -->
  <?php
  include('./header.php');
  ?>
  <?php
  if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
    echo '
  <div class="profile-photo-container">';

    $fetchProfilePhotoQuery = "SELECT profile_photo_path FROM users WHERE id = $userId";
    $fetchProfilePhotoResult = mysqli_query($link, $fetchProfilePhotoQuery);
    $profilePhotoData = mysqli_fetch_assoc($fetchProfilePhotoResult);
    $profilePhoto = isset($profilePhotoData['profile_photo_path']) ? $profilePhotoData['profile_photo_path'] : '';

    if (empty($profilePhoto) && isset($_SESSION['role']) && $_SESSION['role'] == 2) {
      $profilePhoto = "./assets/img/default_photo_profile.jpg"; // Путь к дефолтному изображению
    }

    if (!empty($profilePhoto)) {
      echo '<img src="' . $profilePhoto . '" alt="Фото профиля" class="profile-photo">';
    } else {
      echo '<img src="./assets/img/default_profile_photo.jpg" alt="Альтернативное изображение" class="profile-photo">';
    }

    echo '
  </div>';
  }
  ?>

  <div class="container mx-auto">
    <div id="welcome_text">
      <h1 class="text-3xl font-bold text-center my-10">
        Добро пожаловать,
        <?php echo isset($name) ? $name . ' ' . $surname : 'Пользователь'; ?>
      </h1>
    </div>
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    ?>
      <div class="flex flex-wrap" id="tabs-id">
        <div class="w-full">
          <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row justify-center">
            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center" id="button1">
              <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-sky-600 hover:bg-sky-800 hover:text-white focus:outline-none focus:shadow-outline duration-500 cursor-pointer" onclick="changeActiveTab(event,'tab-orders')">Заказы</a>
            </li>
            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center" id="button2">
              <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-sky-600 hover:text-white-800 bg-white hover:bg-sky-800 hover:text-white focus:outline-none focus:shadow-outline duration-500 cursor-pointer" onclick="changeActiveTab(event,'tab-options')">
                <i class="fas fa-cog text-base mr-1"></i> Настройки
              </a>
            </li>
          </ul>
          <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
            <div class="px-4 py-5 flex-auto">
              <div class="tab-content tab-space">
                <div class="block" id="tab-orders">
                  <h1 class="text-3xl font-bold pt-8 lg:pt-0 text-center">Заказы</h1>
                  <div class="catalog">
                    <!-- Вывод заказов пользователя -->
                    <?php
                    if ($ordersResult) {
                      if (mysqli_num_rows($ordersResult) > 0) {
                        while ($order = mysqli_fetch_assoc($ordersResult)) {
                          echo '<div class="order">
                <p>Номер заказа: ' . $order['order_id'] . '</p>
                <p>Картина: ' . $order['painting_id'] . '</p>
                <p>Количество: ' . $order['quantity'] . '</p>
                <p>Дата заказа: ' . $order['order_date'] . '</p>
            </div>';
                        }
                      } else {
                        echo '<p>У вас нет заказов</p>';
                      }
                    } else {
                      echo "Ошибка выполнения запроса: " . mysqli_error($link);
                    }
                    ?>
                  </div>
                </div>
                <div class="hidden" id="tab-options">
                  <h1 class="text-3xl font-bold pt-8 lg:pt-0 text-center">Настройки</h1>
                  <div class="settings_list">
                    <!-- Формы изменения почты и пароля -->
                    <i class="fa fa-envelope" aria-hidden="true"><a href="#"> Сменить Email</a></i>
                    <form action="" method="post" id="changeEmailForm">
                      <label for="currentEmail">Текущая почта:</label>
                      <input type="email" name="currentEmail" required />

                      <label for="newEmail">Новая почта:</label>
                      <input type="email" name="newEmail" required />

                      <input type="submit" name="changeEmail" value="Изменить почту" onclick="confirmChange(event, 'changeEmailForm')" />
                    </form>
                    <i class="fa fa-lock" aria-hidden="true"><a href="#"> Сменить пароль</a></i>
                    <form action="" method="post" id="changePasswordForm">
                      <label for="currentPassword">Текущий пароль:</label>
                      <input type="password" name="currentPassword" required />

                      <label for="newPassword">Новый пароль:</label>
                      <input type="password" name="newPassword" required />

                      <input type="submit" name="changePassword" value="Изменить пароль" onclick="confirmChange(event, 'changePasswordForm')" />
                    </form>

                    <!-- Форма удаления аккаунта -->
                    <div class="delete_account">
                      <i class="fa fa-envelope" aria-hidden="true"><a href="#"> Удалить аккаунт</a></i>
                      <form method="post" onsubmit="return confirmDelete()">
                        <button class="btn btn-danger" name="del_ak">
                          Удалить аккаунт
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

  </div>

  <?php
if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {

    $artist_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM paintings WHERE artist_id = $artist_id";
    $result = mysqli_query($link, $sql); 

    echo '
    <div class="flex flex-wrap" id="tabs-id">
      <div class="width_arist m-auto">
        <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
          <li class="-mb-px mr-2 last:mr-0 flex-auto text-center" id="button1">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-sky-600 hover:bg-sky-800 hover:text-white focus:outline-none focus:shadow-outline duration-500 cursor-pointer" onclick="changeActiveTab(event,\'tab-profile\')">Мои картины</a>
          </li>
          <li class="-mb-px mr-2 last:mr-0 flex-auto text-center" id="button3">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-sky-600 hover:text-white-800 bg-white hover:bg-sky-800 hover:text-white focus:outline-none focus:shadow-outline duration-500 cursor-pointer" onclick="changeActiveTab(event,\'tab-options\')">
              <i class="fas fa-cog text-base mr-1"></i> Настройки
            </a>
          </li>
        </ul>
        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
          <div class="px-4 py-5 flex-auto">
            <div class="tab-content tab-space">
              <div class="block" id="tab-profile">
                <h1 class="text-3xl font-bold pt-8 lg:pt-0">Мои картины</h1>
                <div class="catalog">';

    // Вывод картин
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
                  <div class="item">
                    <div class="item-cont">
                    <img src="./assets/img/painting/' . $row['image'] . '" alt="' . $row['title'] . '" class="w-32 h-32 object-cover rounded-full">
                      <div class="price">' . $row['title'] . '</div>
                    </div>
                  </div>';
    }

    echo '
                </div>
              </div>
              <div class="hidden" id="tab-options">
                 <h1 class="text-3xl font-bold pt-8 lg:pt-0">Настройки</h1>
                  <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-sky-500 opacity-25"></div>
                    <div class="settings_list">

                     <i class="fa fa-user" aria-hidden="true"><a href="#"> Загрузить фото профиля</a></i>
                      <form action="upload_profile_photo.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="artist_id" value="' . $artist_id . '">
                         <label for="profile_photo">Выберите фото профиля:</label>
                        <input type="file" name="profile_photo" accept="image/*" required><br>
                        <input type="submit" value="Загрузить фото профиля">
                       </form>

                    <i class="fa fa-envelope" aria-hidden="true"><a href="#"> Добавить работу</a></i>
                     <form method="post" enctype="multipart/form-data" action="upload_paint.php">
                      <input type="hidden" name="artist_id" value="' . $artist_id . '">
        
                       <label for="title">Название картины:</label>
                      <input type="text" name="title" required><br>
        
                       <label for="description">Описание картины:</label>
                         <textarea name="description" id="description" maxlength="255" required></textarea><br>
                         <span id="charCount">0 / 255</span><br>
        
                       <label for="price">Цена:</label>
                      <input type="number" name="price" required><br>
        
                       <label for="size_paint">Размер картины:</label>
                     <input type="text" name="size_paint" required><br>
        
                     <label for="photo">Фото:</label>
                      <input type="file" name="photo" accept="image" required><br>
                      <input type="submit" value="Добавить картину">
                     </form>
                     <i class="fa fa-envelope" aria-hidden="true"><a href="#"> Сменить Email</a></i>
                     <form action="" method="post" id="changeEmailForm">
                    <label for="currentEmail">Текущая почта:</label>
                    <input type="email" name="currentEmail" required />

                    <label for="newEmail">Новая почта:</label>
                    <input type="email" name="newEmail" required />

                    <input type="submit" name="changeEmail" value="Изменить почту" onclick="confirmChange(event, \'changeEmailForm\')" />
                    </form>
                    <i class="fa fa-lock" aria-hidden="true"><a href="#"> Сменить пароль</a></i>
                   <form action="" method="post" id="changePasswordForm">
                    <label for="currentPassword">Текущий пароль:</label>
                    <input type="password" name="currentPassword" required />

                    <label for="newPassword">Новый пароль:</label>
                    <input type="password" name="newPassword" required />

                    <input type="submit" name="changePassword" value="Изменить пароль" onclick="confirmChange(event, \'changePasswordForm\')" />
                    </form>

                    <div class="delete_account">
                    <i class="fa fa-envelope" aria-hidden="true"><a href="#"> Удалить аккаунт</a></i>

                    <!-- Добавлен JavaScript-код для подтверждения удаления аккаунта -->
                    <form method="post" onsubmit="return confirmDelete()">
                      <button class="btn btn-danger" name="del_ak">
                        Удалить аккаунт
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
} else {
    echo '<p>У вас пока нет добавленных картин.</p>';
}
?>




  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>

  <script type="text/javascript">
function confirmDelete() {
  var confirmDelete = confirm("Вы уверены, что хотите удалить аккаунт?");
  if (!confirmDelete) {
    event.preventDefault(); 
  }
}

function confirmChange(event, formId) {
  var confirmChange = confirm("Вы уверены, что хотите изменить данные?");
  if (!confirmChange) {
    event.preventDefault();
  }
}

    function changeActiveTab(event, tabID) {
      let element = event.target;
      while (element.nodeName !== "A") {
        element = element.parentNode;
      }
      ulElement = element.parentNode.parentNode;
      aElements = ulElement.querySelectorAll("li > a");
      tabContents = document.getElementById("tabs-id").querySelectorAll(".tab-content > div");

      for (let i = 0; i < aElements.length; i++) {
        aElements[i].classList.remove("text-white");
        aElements[i].classList.remove("bg-sky-600");
        aElements[i].classList.add("text-sky-600");
        aElements[i].classList.add("bg-white");
      }

      for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.add("hidden");
        tabContents[i].classList.remove("block");
      }

      element.classList.remove("text-sky-600");
      element.classList.remove("bg-white");
      element.classList.add("text-white");
      element.classList.add("bg-sky-600");
      document.getElementById(tabID).classList.remove("hidden");
      document.getElementById(tabID).classList.add("block");
    }
  </script>

<script>
    const textarea = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    textarea.addEventListener('input', function() {
        const count = textarea.value.length;
        charCount.textContent = count + ' / 255';

        if (count > 255) {
            textarea.value = textarea.value.slice(0, 255);
            charCount.textContent = '255 / 255';
        }
    });
</script>
</body>

</html>