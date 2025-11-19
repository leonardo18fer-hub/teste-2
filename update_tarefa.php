<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id     = intval($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($id <= 0) {
        header('Location: index.php');
        exit;
    }

    if ($action === 'toggle') {

        $q = $pdo->prepare("
            SELECT concluida
              FROM tarefas
             WHERE id = :id
        ");

        $q->execute([':id' => $id]);

        $t = $q->fetch(PDO::FETCH_ASSOC);

        if ($t) {

            $novo = $t['concluida'] ? 0 : 1;

            $u = $pdo->prepare("
                UPDATE tarefas
                   SET concluida = :c
                 WHERE id = :id
            ");

            $u->execute([
                ':c'  => $novo,
                ':id' => $id
            ]);
        }
    }

    header('Location: index.php');
    exit;
}

header('Location: index.php');
