<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificação SAFE</title>
</head>
<body style="font-family: system-ui, sans-serif; color: #1f2937; line-height: 1.6;">
    <header style="margin-bottom: 24px;">
        <h1 style="font-size: 24px; color: #0f172a;">Confirmação de Entrada/Saída</h1>
    </header>

    <p>Olá,</p>
    <p>O registro de entrada/saída do aluno <strong>{{ $authorization->student_name }}</strong> foi confirmado pela portaria.</p>

    <ul style="margin: 16px 0; padding-left: 20px;">
        <li><strong>Professor:</strong> {{ $authorization->professor_name }}</li>
        <li><strong>Turma:</strong> {{ $authorization->classroom }}</li>
        <li><strong>Ação:</strong> {{ ucfirst($authorization->action) }} às {{ $authorization->scheduled_time }}</li>
        <li><strong>Aula:</strong> {{ $authorization->lesson }}º</li>
        <li><strong>Data:</strong> {{ $authorization->date->format('d/m/Y') }}</li>
        <li><strong>Autorizado por:</strong> {{ $authorization->authorized_by }}</li>
    </ul>

    <p>Esta notificação foi disparada automaticamente pelo sistema SAFE.</p>

    <footer style="margin-top: 24px; color: #475569; font-size: 14px;">SAFE - Sistema de Autorização Escolar</footer>
</body>
</html>
