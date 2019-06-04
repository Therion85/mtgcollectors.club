<?php

$config = parse_ini_file('../config.ini', true);
$db = $config['database'];
$servername = $db['hostname'];
$username = $db['username'];
$password = $db['password'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=mtg", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die('There was a problem with the website. Please try again later.');
}

$input = $_GET["cardName"];

$sql = "SELECT name,
               cost,
               color,
               type,
               text,
               cardset
          FROM mtg.cards
         WHERE name = :input";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':input', $input, PDO::PARAM_STR);
$stmt->execute();
$card = $stmt->fetch();

echo <<<CARDS
<html>
  <head>
    <h1 style="color: blue">{$card['name']}</h1>
  </head>
  <body>
    <h4>Mana Cost: {$card['cost']}</h4>
    <h4>Card Type: {$card['type']}</h4>
    <h4>Color: {$card['color']}</h4>
    <h4>Card Txt: {$card['text']}</h4>
    <h4>Set: {$card['cardset']}</h4>
  </body>
</html>
CARDS;
