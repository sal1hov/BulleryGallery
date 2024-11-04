<?php
session_start();

include("connect.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profile_photo'])) {
        $artist_id = $_SESSION['user_id']; 
        $target_dir = "./assets/img/uploads/";

        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);

        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $updatePhotoQuery = "UPDATE users SET profile_photo_path = '$target_file' WHERE id = $artist_id";
            $updatePhotoResult = mysqli_query($link, $updatePhotoQuery);

            if ($updatePhotoResult) {

                echo "<script>alert('Фото профиля успешно загружено.');</script>";
                header("Location: profile.php");
                exit(); 
            } else {
                echo "Ошибка при обновлении пути к фото профиля в базе данных.";
            }
        } else {
            echo "Ошибка при загрузке фото профиля.";
        }
    } else {
        echo "Файл фото профиля не был выбран.";
    }
} else {
    echo "Недопустимый метод запроса.";
}
?>
