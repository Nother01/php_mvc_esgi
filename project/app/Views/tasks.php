<!DOCTYPE html>
<html>
<head>
    <title>Mes Tâches</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { background: #007cba; color: white; padding: 8px 15px; text-decoration: none; border-radius: 3px; }
        .btn-danger { background: #dc3545; }
        .btn-success { background: #28a745; }
        .task { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .task-header { display: flex; justify-content: space-between; align-items: center; }
        .status { padding: 3px 8px; border-radius: 3px; color: white; font-size: 12px; }
        .status.todo { background: #6c757d; }
        .status.in_progress { background: #ffc107; color: black; }
        .status.done { background: #28a745; }
        .actions a { margin-right: 10px; font-size: 14px; }
        .error { color: red; padding: 10px; margin: 10px 0; }
        .success { color: green; padding: 10px; margin: 10px 0; }
        .empty { text-align: center; color: #666; margin: 50px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Mes Tâches</h1>
        <div>
            <span>Bonjour <?= $_SESSION['user_name'] ?></span>
            <a href="/logout" class="btn btn-danger">Déconnexion</a>
        </div>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div style="background: #f8f9fa; padding: 20px; margin-bottom: 30px; border-radius: 5px;">
        <h2>Créer une nouvelle tâche</h2>
        <form method="POST" action="/tasks">
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 200px;">
                    <label>Titre:</label>
                    <input type="text" name="title" required style="width: 100%; padding: 8px;">
                </div>
                
                <div style="flex: 2; min-width: 200px;">
                    <label>Description:</label>
                    <input type="text" name="description" required style="width: 100%; padding: 8px;">
                </div>
                
                <div style="flex: 1; min-width: 120px;">
                    <label>Statut:</label>
                    <select name="status" style="width: 100%; padding: 8px;">
                        <option value="todo">À faire</option>
                        <option value="in_progress">En cours</option>
                        <option value="done">Terminé</option>
                    </select>
                </div>
                
                <div style="flex: 0; display: flex; align-items: end;">
                    <button type="submit" name="action" value="create" class="btn" style="margin-bottom: 0;">Créer</button>
                </div>
            </div>
        </form>
    </div>

    <?php if (empty($tasks)): ?>
        <div class="empty">
            <h3>Aucune tâche trouvée</h3>
        </div>
    <?php else: ?>
        <?php foreach ($tasks as $task): ?>
            <div class="task">
                <div class="task-header">
                    <h3><?= htmlspecialchars($task['title']) ?></h3>
                    <span class="status <?= $task['status'] ?>">
                        <?php
                        $statuses = ['todo' => 'À faire', 'in_progress' => 'En cours', 'done' => 'Terminé'];
                        echo $statuses[$task['status']];
                        ?>
                    </span>
                </div>
                
                <p><?= htmlspecialchars($task['description']) ?></p>
                
                <small>Créée le: <?= date('d/m/Y H:i', strtotime($task['created_at'])) ?></small>
                
                <div class="actions">
                    <a href="/tasks/edit/<?= $task['id'] ?>" class="btn btn-success">Modifier</a>
                    <a href="/tasks/delete/<?= $task['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>