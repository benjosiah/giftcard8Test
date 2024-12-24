<?php
class API {
    private TaskManager $taskManager;
    protected $validate;

    public function __construct() {
        $db = new Database();
        $pdo = $db->connection;
        $this->taskManager = new TaskManager($pdo);
        $this->validate = new Validation();
    }

    public function handleRequest(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $resource = $requestUri[0] ?? '';
        $id = isset($requestUri[1]) ? intval($requestUri[1]) : null;

        switch ($resource) {
            case 'tasks':
                $this->handleTaskRequest($requestMethod, $id);
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Resource not found']);
                break;
        }
    }

    private function handleTaskRequest($method, $id): void
    {
        switch ($method) {
            case 'GET':
                $this->getTasks($id);
                break;
            case 'POST':
                $this->createTask();
                break;
            case 'PUT':
                $this->updateTask($id);
                break;
            case 'DELETE':
                $this->deleteTask($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                break;
        }
    }

    private function getTasks($id) {
        $tasks = $this->taskManager->fetchTasks($id);
        if ($id && !$tasks) {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
        } else {
            echo json_encode($tasks);
        }
    }

    private function createTask() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->validate->validateRequired('name', $data['name']);
        $this->validate->validateRequired('description', $data['description']);
        $errors = $this->validate->getErrors();


        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            return;
        }

        $taskId = $this->taskManager->addTask($data);
        echo json_encode(['message' => 'Task created successfully', 'task_id' => $taskId]);
    }

    private function updateTask($id) {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID is required']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $rowCount = $this->taskManager->updateTask($id, $data);

        if ($rowCount) {
            echo json_encode(['message' => 'Task updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found or no changes made']);
        }
    }

    private function deleteTask($id) {
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID is required']);
            return;
        }

        $rowCount = $this->taskManager->deleteTask($id);

        if ($rowCount) {
            echo json_encode(['message' => 'Task deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
        }
    }
}
