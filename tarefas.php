<?php
include 'db.php';

$action = $_REQUEST['action'] ?? '';

if ($action == 'adicionar') {
    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    if ($titulo) {
        $stmt = $pdo->prepare("INSERT INTO tarefas (titulo, descricao) VALUES (?, ?)");
        $stmt->execute([$titulo, $descricao]);
    }
}

elseif ($action == 'listar') {
    $stmt = $pdo->query("SELECT * FROM tarefas ORDER BY criada_em DESC");
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>Status</th><th>Título</th><th>Descrição</th><th>Ações</th></tr></thead><tbody>';
    foreach ($stmt as $tarefa) {
        $checked = $tarefa['concluida'] ? '✔️' : '❌';
        $linha = $tarefa['concluida'] ? 'table-success' : '';
        echo "<tr class='$linha'>";
        echo "<td><button class='btn btn-sm btn-toggle btn-outline-secondary' data-id='{$tarefa['id']}'>$checked</button></td>";
        echo "<td>" . htmlspecialchars($tarefa['titulo']) . "</td>";
        echo "<td>" . htmlspecialchars($tarefa['descricao']) . "</td>";
        echo "<td><button class='btn btn-sm btn-danger btn-excluir' data-id='{$tarefa['id']}'>Excluir</button></td>";
        echo "</tr>";
    }
    echo '</tbody></table>';
}

elseif ($action == 'excluir') {
    $id = $_POST['id'] ?? 0;
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
    $stmt->execute([$id]);
}

elseif ($action == 'toggle') {
    $id = $_POST['id'] ?? 0;
    $stmt = $pdo->prepare("UPDATE tarefas SET concluida = NOT concluida WHERE id = ?");
    $stmt->execute([$id]);
}
