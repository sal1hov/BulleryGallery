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
    <link rel="stylesheet" href="./assets/css/artist.css" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
    <!-- header -->
    <?php include('./header.php'); ?>

    <h1 class="zagalovok">Художники</h1>
    <div class="container">
        <?php
        $sql = "SELECT artists.*, users.profile_photo_path
            FROM artists
            JOIN users ON artists.email = users.email";
        $result = mysqli_query($link, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo '<section class="section artist-grid container fadeIn">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<article class="artist-item">';
                    echo '<span class="artist--img">';
                    // Добавляем ссылку на страницу художника
                    echo '<a href="artist_page.php?artist_id=' . $row["artist_id"] . '" class="artist--link">';
                    if (!empty($row["profile_photo_path"])) {
                        echo '<img src="' . $row["profile_photo_path"] . '" alt="' . $row["name_artist"] . '" title="' . $row["name_artist"] . '">';
                    } else {
                        echo 'Изображение не доступно';
                    }
                    echo '</a>';
                    echo '</span>';
                    echo '<span class="artist--content">';
                    echo '<ul class="menu">';
                    echo '<li class="menu-item artist--name"><a href="artist_page.php?artist_id=' . $row["artist_id"] . '">' . $row["name_artist"] . '</a></li>';
                    echo '</ul>';
                    echo '</span>';
                    echo '</article>';
                }
                echo '</section>';
            } else {
                echo "0 results";
            }
        } else {
            echo "Error: " . mysqli_error($link);
        }
        ?>
    </div>
    <!-- footer -->
    <?php include('./footer.php'); ?>
</body>

</html>