<?php
include("connect.php");
session_start();

if (isset($_GET['artist_id'])) {
    $artist_id = $_GET['artist_id'];

    $artist_info_query = "SELECT artists.*, users.profile_photo_path, users.name, users.surname
                         FROM artists
                         JOIN users ON artists.email = users.email
                         WHERE artists.artist_id = ?";
    $artist_info_stmt = mysqli_prepare($link, $artist_info_query);

    if ($artist_info_stmt) {

        mysqli_stmt_bind_param($artist_info_stmt, "i", $artist_id);
        mysqli_stmt_execute($artist_info_stmt);

        $artist_info_result = mysqli_stmt_get_result($artist_info_stmt);

        if ($artist_info_result) {
            $artist_info = mysqli_fetch_assoc($artist_info_result);

            $paintings_query = "SELECT * FROM paintings WHERE artist_id = ?";
            $paintings_stmt = mysqli_prepare($link, $paintings_query);

            if ($paintings_stmt) {
                mysqli_stmt_bind_param($paintings_stmt, "i", $artist_id);
                mysqli_stmt_execute($paintings_stmt);

                $paintings_result = mysqli_stmt_get_result($paintings_stmt);
            } else {
                echo "Ошибка при подготовке запроса для картин: " . mysqli_error($link);
                exit();
            }
        } else {
            echo "Ошибка при выполнении запроса для информации о художнике: " . mysqli_error($link);
            exit(); 
        }
    } else {
        echo "Ошибка при подготовке запроса для информации о художнике: " . mysqli_error($link);
        exit();
    }
} else {
    header("Location: ./catalog.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $artist_info['name'] . " " . $artist_info['surname']; ?> | BULLERY</title>
    <link rel="stylesheet" href="./assets/css/normalize.css" />
    <link rel="stylesheet" href="./assets/css/artist_page.css" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body>
    <?php include('./header.php'); ?>

    <section class="artist-details container">
        <div class="artist-info">
            <img src="<?php echo $artist_info['profile_photo_path']; ?>" alt="<?php echo $artist_info['name'] . ' ' . $artist_info['surname']; ?>" title="<?php echo $artist_info['name'] . ' ' . $artist_info['surname']; ?>" />
            <h2 class="artist-name"><?php echo $artist_info['name'] . ' ' . $artist_info['surname']; ?></h2>
            <p class="artist-about"><?php echo $artist_info['about_artist']; ?></p>
        </div>
        <div class="paintings">
            <h3 class="paintings-title">Картины художника</h3>
            <?php
            if ($paintings_result !== null) {
                if (mysqli_num_rows($paintings_result) > 0) {
                    echo '<div class="paintings-grid">';
                    while ($painting = mysqli_fetch_assoc($paintings_result)) {
                        echo '<div class="painting">';
                        echo '<a href="paint_page.php?id=' . $painting['id'] . '">';
                        echo '<img src="./assets/img/painting/' . $painting['image'] . '" alt="' . $painting['title'] . '" title="' . $painting['title'] . '" />';
                        echo '</a>';
                        echo '<h4 class="painting-title"><a href="paint_page.php?id=' . $painting['id'] . '">' . $painting['title'] . '</a></h4>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p class="no-paintings">У этого художника нет картины</p>';
                }
            } else {
                echo '<p class="no-paintings">Произошла ошибка при загрузке данных</p>';
            }
            ?>
        </div>

    </section>
    <?php include('./footer.php'); ?>
</body>

</html>