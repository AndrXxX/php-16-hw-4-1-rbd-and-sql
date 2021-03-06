<?php
$homeWorkNum = '4.1';
$homeWorkCaption = 'Реляционные базы данных и SQL.';

$host = 'localhost';
$db = 'global';
$user = '123';
$password = '123';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);

/**
 * Составляем запрос
 */
$sql = "SELECT * FROM books WHERE name LIKE ? AND author LIKE ? AND isbn LIKE ?";
$statement = $pdo->prepare($sql);
$statement->execute([getSQLRequest('name'), getSQLRequest('author'), getSQLRequest('isbn')]);

/**
 * Возвращает содержимое $_GET[$request] или пустую строку
 * @param $request
 * @return string
 */
function getValueFromGET($request)
{
    if (!empty($_GET[$request])) {
        return htmlspecialchars($_GET[$request]);
    } else {
        return '';
    }
}

/**
 * Возвращает строку для фильтра WHERE в SQL запросе
 * например, если $_GET[$request] == 123, то возвращает: %123%
 * @param $request
 * @return string
 */
function getSQLRequest($request)
{
    return '%' . getValueFromGET($request) . '%';
}

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <title>Домашнее задание по теме <?= $homeWorkNum ?> <?= $homeWorkCaption ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1>Библиотека успешного человека</h1>

    <form method="GET">
      <input type="text" name="isbn" placeholder="ISBN" value="<?= getValueFromGET('isbn') ?>"/>
      <input type="text" name="name" placeholder="Название книги" value="<?= getValueFromGET('name') ?>"/>
      <input type="text" name="author" placeholder="Автор книги" value="<?= getValueFromGET('author') ?>"/>
      <input type="submit" value="Поиск"/>
    </form>

    <table>
      <tr>
        <th>Название</th>
        <th>Автор</th>
        <th>Год выпуска</th>
        <th>Жанр</th>
        <th>ISBN</th>
      </tr>

      <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
      <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['author'] ?></td>
        <td><?= $row['year'] ?></td>
        <td><?= $row['genre'] ?></td>
        <td><?= $row['isbn'] ?></td>
      </tr>
      <?php endwhile; ?>

    <table>
  </body>
</html>
