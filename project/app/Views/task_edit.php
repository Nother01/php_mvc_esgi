<!DOCTYPE html>
<html>
<head>
    <title>Modifier la tâche</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        textarea { height: 100px; resize: vertical; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-right: 10px; }
        .btn-secondary { background: #6c757d; }
        .back-link { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="back-link">
        <a href="/tasks">← Retour aux tâches</a>
    </div>

    <h1>Modifier la tâche</h1>

    <form method="POST">
        <div class="form-group">
            <label>Titre:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" required><?= htmlspecialchars($task['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Statut:</label>
            <select name="status">
                <option value="todo" <?= $task['status'] == 'todo' ? 'selected' : '' ?>>À faire</option>
                <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>En cours</option>
                <option value="done" <?= $task['status'] == 'done' ? 'selected' : '' ?>>Terminé</option>
            </select>
        </div>

        <button type="submit">Modifier la tâche</button>
        <a href="/tasks" class="btn-secondary" style="text-decoration: none; padding: 10px 20px; color: white;">Annuler</a>
    </form>
</body>
</html>