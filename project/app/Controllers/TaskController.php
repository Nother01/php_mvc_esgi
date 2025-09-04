<?php

require_once __DIR__ . '/../Models/Task.php';
require_once __DIR__ . '/UserController.php';

class TaskController {
    private $taskModel;
    private $userController;

    public function __construct() {
        $this->taskModel = new Task();
        $this->userController = new UserController();
        session_start();
    }

    public function index() {
        $this->userController->checkAuth();
        
        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'create') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'] ?? 'todo';

            if ($this->taskModel->create($title, $description, $userId, $status)) {
                $_SESSION['success'] = 'tache créée avec succès';
            } else {
                $_SESSION['error'] = 'erreur lors de la création';
            }

            header('Location: /tasks');
            exit;
        }
        
        $tasks = $this->taskModel->findByUserId($userId);

        include __DIR__ . '/../Views/tasks.php';
    }

    public function create() {
        $this->userController->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'] ?? 'todo';
            $userId = $_SESSION['user_id'];

            if ($this->taskModel->create($title, $description, $userId, $status)) {
                $_SESSION['success'] = 'tache créée avec succès';
            } else {
                $_SESSION['error'] = 'erreur lors de la création';
            }

            header('Location: /tasks');
            exit;
        }

        include __DIR__ . '/../Views/task_create.php';
    }

    public function edit($id) {
        $this->userController->checkAuth();
        
        $userId = $_SESSION['user_id'];
        $task = $this->taskModel->findById($id, $userId);

        if (!$task) {
            $_SESSION['error'] = 'tache non trouvée';
            header('Location: /tasks');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            if ($this->taskModel->update($id, $title, $description, $status, $userId)) {
                $_SESSION['success'] = 'tache modifiée avec succès';
            } else {
                $_SESSION['error'] = 'erreur lors de la modification';
            }

            header('Location: /tasks');
            exit;
        }

        include __DIR__ . '/../Views/task_edit.php';
    }

    public function delete($id) {
        $this->userController->checkAuth();
        
        $userId = $_SESSION['user_id'];

        if ($this->taskModel->delete($id, $userId)) {
            $_SESSION['success'] = 'tache supprimée avec succès';
        } else {
            $_SESSION['error'] = 'erreur lors de la suppression';
        }

        header('Location: /tasks');
        exit;
    }
}