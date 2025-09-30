<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">📝 Lista de Tarefas</h2>
    <form id="formTarefa" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="titulo" class="form-control" placeholder="Título da tarefa" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="descricao" class="form-control" placeholder="Descrição">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
        </div>
    </form>

    <div id="listaTarefas">
        <!-- Lista de tarefas será carregada aqui via Ajax -->
    </div>
</div>

<script>
    function carregarTarefas() {
        $.get('tarefas.php', { action: 'listar' }, function(data) {
            $('#listaTarefas').html(data);
        });
    }

    $(function() {
        carregarTarefas();

        $('#formTarefa').submit(function(e) {
            e.preventDefault();
            $.post('tarefas.php', $(this).serialize() + '&action=adicionar', function() {
                $('#formTarefa')[0].reset();
                carregarTarefas();
            });
        });

        $('#listaTarefas').on('click', '.btn-excluir', function() {
            let id = $(this).data('id');
            $.post('tarefas.php', { action: 'excluir', id: id }, carregarTarefas);
        });

        $('#listaTarefas').on('click', '.btn-toggle', function() {
            let id = $(this).data('id');
            $.post('tarefas.php', { action: 'toggle', id: id }, carregarTarefas);
        });
    });
</script>
</body>
</html>
