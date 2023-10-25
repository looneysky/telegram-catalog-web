<?php
require_once 'application/engine/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_count_text = $_POST['user_count_text'];
    $link_href = $_POST['link_href'];
    $link_text = $_POST['link_text'];
    $channel_description_text = $_POST['channel_description_text'];
    $img_src = $_POST['img_src'];
    $category_text = $_POST['category_text'];
    echo("200");

    // Проверка наличия записи с данным URL
    $sql = "SELECT * FROM `groups` WHERE `url` = '$link_href'";
    $result = $conn->query($sql);

    // Проверка наличия записи с данным именем
    $sql2 = "SELECT * FROM `groups` WHERE `name` = '$link_text'";
    $result2 = $conn->query($sql2);

    if ($result->num_rows > 0 || $result2->num_rows > 0) {
        // Если запись существует, обновляем ее
        $updateSql = "UPDATE `groups` SET `avatar`='$img_src', `description`='$channel_description_text', `subs`='$user_count_text', `category`='$category_text' WHERE `url`='$link_href' OR `name`='$link_text'";
        $updateResult = $conn->query($updateSql);
        echo("Уже существует");
    } else {
        // Если записи не существует, создаем новую запись
        $insertSql = "INSERT INTO `groups` (`id`, `name`, `avatar`, `url`, `description`, `subs`, `category`) VALUES (NULL, '$link_text', '$img_src', '$link_href', '$channel_description_text', '$user_count_text', '$category_text');";
        $insertResult = $conn->query($insertSql);
        echo("Создал");
    }

    $conn->close();
} else {
    echo("Method is not allowed");
}
?>
