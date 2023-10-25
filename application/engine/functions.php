<?php
require_once __DIR__ . '/../config.php';

function getAllGroups($start, $limit) {
    global $conn; // Подключение к базе данных из config.php

    // Подготавливаем SQL запрос с использованием LIMIT и OFFSET
    $sql = "SELECT * FROM `groups` LIMIT $start, $limit";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    $rows = array(); // Создаем пустой массив для хранения всех строк

    if($result->num_rows > 0) {
        // Добавляем каждую строку в массив $rows
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    return $rows; // Возвращаем массив всех строк результата запроса
}

function getGroupById($id) {
    global $conn; // Подключение к базе данных из config.php

    // Подготавливаем SQL запрос для выборки группы по ID
    $sql = "SELECT * FROM `groups` WHERE `id` = '$id'";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        // Получаем первую строку из результата запроса
        $row = $result->fetch_assoc();
        return $row; // Возвращаем ассоциативный массив с данными о группе
    } else {
        return null; // Если нет результатов, возвращаем null или другое значение по вашему выбору
    }
}


function countAllGroups() {
    global $conn; // Подключение к базе данных из config.php

    // Подготавливаем SQL запрос для подсчета общего количества строк
    $sql = "SELECT COUNT(*) as count FROM `groups`";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        // Получаем количество строк из результата запроса
        $row = $result->fetch_assoc();
        return $row['count']; // Возвращаем общее количество строк
    }

    return 0; // Если нет строк, возвращаем 0
}

function countGroupsBySearch($searchTerm) {
    global $conn; // Подключение к базе данных из config.php

    // Экранируем специальные символы в строке поиска для безопасности
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

    // Подготавливаем SQL запрос для подсчета общего количества строк, соответствующих поисковому запросу
    $sql = "SELECT COUNT(*) as count FROM `groups` WHERE `name` LIKE '%$searchTerm%' OR `description` LIKE '%$searchTerm%'";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        // Получаем количество строк из результата запроса
        $row = $result->fetch_assoc();
        return $row['count']; // Возвращаем общее количество строк
    }

    return 0; // Если нет строк, возвращаем 0
}

function getGroupsBySearch($searchTerm, $start, $limit) {
    global $conn; // Подключение к базе данных из config.php

    // Экранируем специальные символы в строке поиска для безопасности
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

    // Подготавливаем SQL запрос для поиска групп по имени и описанию с использованием LIMIT и OFFSET
    $sql = "SELECT * FROM `groups` WHERE `name` LIKE '%$searchTerm%' OR `description` LIKE '%$searchTerm%' LIMIT $start, $limit";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    $rows = array(); // Создаем пустой массив для хранения всех строк

    if($result->num_rows > 0) {
        // Добавляем каждую строку в массив $rows
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    return $rows; // Возвращаем массив всех строк результата запроса
}

function countCategoriesBySearch($searchTerm) {
    global $conn; // Подключение к базе данных из config.php

    // Экранируем специальные символы в строке поиска для безопасности
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

    // Подготавливаем SQL запрос для подсчета общего количества строк, соответствующих поисковому запросу
    $sql = "SELECT COUNT(*) as count FROM `groups` WHERE `category` LIKE '%$searchTerm%'";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        // Получаем количество строк из результата запроса
        $row = $result->fetch_assoc();
        return $row['count']; // Возвращаем общее количество строк
    }

    return 0; // Если нет строк, возвращаем 0
}

function getGroupsByCategory($searchTerm, $start, $limit) {
    global $conn; // Подключение к базе данных из config.php

    // Экранируем специальные символы в строке поиска для безопасности
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

    // Подготавливаем SQL запрос для поиска групп по категории с использованием LIMIT и OFFSET
    $sql = "SELECT * FROM `groups` WHERE `category` LIKE '%$searchTerm%' LIMIT $start, $limit";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    $rows = array(); // Создаем пустой массив для хранения всех строк

    if($result->num_rows > 0) {
        // Добавляем каждую строку в массив $rows
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    return $rows; // Возвращаем массив всех строк результата запроса
}

function getGroupsByCategoryExcludingId($searchTerm, $excludeId) {
    global $conn; // Подключение к базе данных из config.php

    // Экранируем специальные символы в строке поиска и исключаемом идентификаторе для безопасности
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);
    $excludeId = intval($excludeId);

    // Подготавливаем SQL запрос для поиска групп по категории с исключением определенного id
    $sql = "SELECT * FROM `groups` WHERE `category` LIKE '%$searchTerm%' AND `id` <> $excludeId";

    // Выполняем SQL-запрос
    $result = $conn->query($sql);

    $rows = array(); // Создаем пустой массив для хранения всех строк

    if($result->num_rows > 0) {
        // Добавляем каждую строку в массив $rows
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    return $rows; // Возвращаем массив всех строк результата запроса
}

?>