<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = intval($_POST['id'] ?? 0);

    if ($id > 0) {

        $stmt = $pdo->prepare("
            DELETE FROM tarefas
             WHERE id = :id
        ");

        $stmt->execute([':id' => $id]);
    }

    header('Location: index.php');
    exit;
}

header('Location: index.php');
