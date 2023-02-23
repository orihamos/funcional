<?php
require_once __DIR__ . '/../../config/config.php';
//id from get
$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('DELETE FROM vendas WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$id_venda = $pdo->lastInsertId();

$statement = $pdo->prepare('DELETE FROM produtos WHERE id_venda = :id_venda');
$statement->bindValue(':id_venda', $id);
$statement->execute();


$statement = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();


header('Location: index.php');
