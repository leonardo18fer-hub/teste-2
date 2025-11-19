<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $descricao  = trim($_POST['descricao']  ?? '');
    $vencimento = trim($_POST['vencimento'] ?? null);

    if ($descricao === '') {
        header('Location: index.php?error=empty');
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO tarefas (descricao, vencimento)
        VALUES (:d, :v)
    ");

    $stmt->execute([
        ':d' => $descricao,
        ':v' => ($vencimento ?: null)
    ]);

    header('Location: index.php?success=added');
    exit;
}

header('Location: index.php');
