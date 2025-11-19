<?php
$databaseFile = __DIR__ . '/tarefas.db';

$pdo = new PDO('sqlite:' . $databaseFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS tarefas (
        id         INTEGER PRIMARY KEY AUTOINCREMENT,
        descricao  TEXT NOT NULL,
        vencimento DATE,
        concluida  INTEGER NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");
