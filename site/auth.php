<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $link->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $user = $result->fetch_assoc();
            if ($user && password_verify($password, $user['password'])) {
                echo "Авторизация успешна!";

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role_id'];

                if ($_SESSION['role'] == 3) {

                    header("Location: ./admin/admin_profile.php");
                } elseif ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) {

                    header("Location: profile.php"); 
                }
                exit();
            } else {
                echo "Ошибка при авторизации!";
            }
        } else {
            echo "Ошибка: " . $link->error;
        }


        $result->close();

        $stmt->close();
    } else {
        echo "Ошибка при подготовке запроса: " . $link->error;
    }
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Войти | BULLERY</title>
    <link rel="stylesheet" href="./assets/css/normalize.css" />
    <link rel="stylesheet" href="./assets/css/auth.css" />
    <script src="https://cdn.tailwindcss.com" sync></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" sync></script>
</head>

<body>
    <!-- header -->
    <header>
        <nav>
            <div class="container">
                <a href="./index.php" class="logo">BULLERY</a>
                <div class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="menu">
                    <li><a href="./index.php" class="active">Главная</a></li>
                    <li><a href="./catalog.php">Каталог</a></li>
                    <li><a href="#">Художники</a></li>
                    <li><a href="./contacts.php">Контакты</a></li>
                </ul>
                <ul class="twobuttons">
                    <li><a href="./cart.php">Корзина</a></li>
                    <li><a href="./auth.php">Личный кабинет</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- авторизация -->

    <section class="bg-white-50 dark:bg-white">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-slate-300">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-black md:text-2xl dark:text-black text-center">
                        Добро пожаловать!
                    </h1>
                    <form method="post" class="space-y-4 md:space-y-6">
                        <div>
                            <label for="tel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Ваша
                                почта</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-black-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-900 dark:placeholder-gray-600 dark:text-black" placeholder="Введите эл.почту" required="" />

                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Пароль</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-black-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-900 dark:placeholder-gray-600 dark:text-black" required="" />
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" aria-describepdoy="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300" />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-black dark:text-black">Запомнить меня?</label>
                                </div>
                            </div>
                            <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Забыли
                                пароль?</a>
                        </div>
                        <button name="btn_log" type="submit" class="w-full text-white bg-slate-600 hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-slate-900 dark:hover:bg-slate-700 dark:focus:ring-slate-800">
                            Войти
                        </button>
                        <p class="text-sm font-light text-gray-500 dark:text-black text-center">
                            Нет аккаунта?
                            <a href="./register.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Зарегистрируйтесь!</a>
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