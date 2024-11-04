<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['artist_id'])) {
        $artist_id = $_POST['artist_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $size_paint = $_POST['size_paint'];

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $file_name = $_FILES['photo']['name'];
            $file_tmp = $_FILES['photo']['tmp_name'];

            $target_dir = "./assets/img/painting"; 
            $target_file = $target_dir . basename($file_name);

            if (move_uploaded_file($file_tmp, $target_file)) {
                $insert_query = "INSERT INTO paintings (artist_id, title, description, price, size_paint, image, status) VALUES ('$artist_id', '$title', '$description', '$price', '$size_paint', '$file_name', 'ожидает')";

                if (mysqli_query($link, $insert_query)) {
                    echo '<script>alert("Картина отправлена на проверку!"); window.location.href = "profile.php";</script>';
                } else {
                    echo "Ошибка: " . mysqli_error($link);
                }
            } else {
                echo "Ошибка при загрузке файла.";
            }
        } else {
            echo "Ошибка: Файл не был загружен или возникла ошибка при загрузке.";
        }
    } else {
        echo "Ошибка: Не удалось получить идентификатор художника.";
    }
}
?>
