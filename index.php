<?php
require_once 'database.php';

$pendentes  = $pdo->query("
    SELECT *
      FROM tarefas
     WHERE concluida = 0
  ORDER BY vencimento IS NULL,
           vencimento ASC
")->fetchAll(PDO::FETCH_ASSOC);

$concluidas = $pdo->query("
    SELECT *
      FROM tarefas
     WHERE concluida = 1
  ORDER BY vencimento ASC
")->fetchAll(PDO::FETCH_ASSOC);

$success = $_GET['success'] ?? '';
$error   = $_GET['error']   ?? '';
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Gerenciador de Tarefas</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <style>
        body{font-family:Arial;max-width:1000px;margin:30px auto;color:#333}
        h1{margin-bottom:6px}
        .container{display:grid;grid-template-columns:1fr 380px;gap:20px}
        .card{background:#fff;border:1px solid #ddd;padding:16px;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.03)}
        form input,form button,form label{display:block;width:100%;margin-bottom:8px}
        input[type="text"],input[type="date"]{padding:8px;border:1px solid #ccc;border-radius:4px}
        button{padding:8px 12px;border:none;border-radius:6px;cursor:pointer}
        .btn-primary{background:#2b7cff;color:white}
        .btn-danger{background:#e04b4b;color:white}
        .btn-ghost{background:#f5f5f5}
        ul{list-style:none;padding:0;margin:0}
        li{padding:10px 8px;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between;align-items:center}
        .meta{font-size:.9rem;color:#666}
        .completed{text-decoration:line-through;color:#888}
        .message{padding:8px;margin-bottom:12px;border-radius:6px}
        .msg-success{background:#e6f6ea;color:#216e34;border:1px solid #c9e6ce}
        .msg-error{background:#fdecea;color:#822;border:1px solid #f5c2c2}
        @media(max-width:880px){.container{grid-template-columns:1fr}}
    </style>
</head>

<body>

    <h1>Gerenciador de Tarefas</h1>

    <?php if ($success === 'added'): ?>
        <div class="message msg-success">Tarefa adicionada.</div>
    <?php endif; ?>

    <?php if ($error === 'empty'): ?>
        <div class="message msg-error">Descrição vazia.</div>
    <?php endif; ?>

    <div class="container">

        <div class="card">

            <h2>Pendentes (<?= count($pendentes) ?>)</h2>

            <ul>
                <?php foreach ($pendentes as $t): ?>
                <li>
                    <div>
                        <strong><?= htmlspecialchars($t['descricao']) ?></strong>
                        <div class="meta">
                            Vencimento:
                            <?= $t['vencimento'] ? date('d/m/Y', strtotime($t['vencimento'])) : '—' ?>
                        </div>
                    </div>

                    <div>
                        <form method="post" action="update_tarefa.php" style="display:inline">
                            <input type="hidden" name="id"     value="<?= $t['id'] ?>">
                            <input type="hidden" name="action" value="toggle">
                            <button class="btn-primary">Concluir</button>
                        </form>

                        <form method="post" action="delete_tarefa.php" style="display:inline">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <button class="btn-danger">Excluir</button>
                        </form>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>

            <h3>Concluídas (<?= count($concluidas) ?>)</h3>

            <ul>
                <?php foreach ($concluidas as $t): ?>
                <li>
                    <div>
                        <strong class="completed"><?= htmlspecialchars($t['descricao']) ?></strong>
                        <div class="meta">
                            Vencimento:
                            <?= $t['vencimento'] ? date('d/m/Y', strtotime($t['vencimento'])) : '—' ?>
                        </div>
                    </div>

                    <div>
                        <form method="post" action="update_tarefa.php" style="display:inline">
                            <input type="hidden" name="id"     value="<?= $t['id'] ?>">
                            <input type="hidden" name="action" value="toggle">
                            <button class="btn-ghost">Desmarcar</button>
                        </form>

                        <form method="post" action="delete_tarefa.php" style="display:inline">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <button class="btn-danger">Excluir</button>
                        </form>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>

        <div class="card">

            <h2>Nova Tarefa</h2>

            <form method="post" action="add_tarefa.php">
                <label>Descrição</label>
                <input type="text" name="descricao" required>

                <label>Vencimento</label>
                <input type="date" name="vencimento">

                <button class="btn-primary">Adicionar</button>
            </form>

        </div>

    </div>

</body>
</html>
