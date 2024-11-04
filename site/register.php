<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Личный кабинет | BULLERY</title>
  <link rel="stylesheet" href="./assets/css/normalize.css" />
  <link rel="stylesheet" href="./assets/css/reg.css" />
  <link rel="icon" href="./assets/img/favicon.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="./assets/js/main.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>
<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = 1;

    $stmt = $link->prepare("INSERT INTO users (name, surname, email, password, role_id) VALUES (?, ?, ?, ?, ?)");


    if ($stmt) {
        $stmt->bind_param('ssssi', $name, $surname, $email, $password, $role_id);
        
        if ($stmt->execute()) {
            echo "Регистрация успешна!";

        } else {
            echo "Ошибка при выполнении запроса: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка при подготовке запроса: " . $link->error;
    }
}

?>

<body>
  <!-- header -->
  <?php
  include('./header.php');
  ?>

  <!-- рег -->

  <section class="bg-white-50 dark:bg-white" id="form_section">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-10 sm:max-w-md xl:p-0 dark:bg-slate-300">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-black-900 md:text-2xl dark:text-black text-center">
            Вы у нас впервые? Зарегистрируйтесь!
          </h1>
          <form action="register.php" method="post" class="space-y-4 md:space-y-6">
            <div>
              <label for="text" class="block mb-2 text-sm font-medium text-black-900 dark:text-black">Ваше имя</label>
              <input type="text" name="name" id="name_user" class="bg-gray-50 border border-gray-300 text-black-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-900 dark:placeholder-gray-600 dark:text-black" placeholder="Введите ваше имя" required="" />
            </div>
            <div>
              <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Ваша фамилия</label>
              <input type="text" name="surname" id="surname_user" class="bg-gray-50 border border-gray-300 text-black-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-900 dark:placeholder-gray-600 dark:text-black" placeholder="Введите вашу фамилию" required="" />
            </div>
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Ваша эл.почта
              </label>
              <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-black-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-900 dark:placeholder-gray-600 dark:text-black" placeholder="Введите вашу эл.почту" required="" />
            </div>
            <div>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Введите пароль</label>
              <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-black-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-900 dark:placeholder-gray-600 dark:text-black" required="" />
            </div>
            <div>
              <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Подтвердите пароль</label>
              <input type="password" name="password_repeat" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-black-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-900 dark:placeholder-gray-600 dark:text-black" required="" />
            </div>
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark: dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="" />
              </div>
              <div class="ml-3 text-sm">
                <label for="terms" class="font-light text-black dark:text-black">Я согласен на
                  <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">персональную обработку данных</a></label>
              </div>
            </div>
            <button window.onclick.location="./profile.php" type="submit" name="btn_reg" class="w-full text-white bg-slate-600 hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-slate-900 dark:hover:bg-slate-700 dark:focus:ring-slate-800">
              Зарегистрироваться
            </button>
            <p class="text-sm font-light text-black dark:text-black text-center">
              Уже есть аккаунт?
              <a href="./auth.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Войти</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- footer -->

  <?php
  include('./footer.php');
  ?>
</body>

</html>