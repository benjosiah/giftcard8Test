# Assignment 1

## 1. Import the database

```bash
    Task1/user_registration.sql
```

# Assignment 2

## 1. Import the database

```bash
    Task2/task_manager.sql
```

## 2. Start the PHP Built-in Server

For testing purposes, you can use PHP's built-in server. In the project root directory, run:

```bash
php -S localhost:9000
```

This will start a web server on `http://localhost:9000`.

## 3. API Endpoints

- **GET /tasks**: Fetches all tasks.
- **POST /tasks**: Adds a new task. The body should contain `task_name` and `description`.
- **PUT /tasks/{id}**: Updates a task with the specified `id`. The body should contain updated `task_name` and `description`.
- **DELETE /tasks/{id}**: Deletes the task with the specified `id`.

## 7. Test the API with cURL

Here are some example `curl` commands to test the API:

- **Get all tasks**:

```bash
curl -X GET http://localhost:9000/tasks
```

- **Add a new task**:

```bash
curl -X POST http://localhost:9000/tasks -d "task_name=Task 1&description=This is a new task"
```

- **Update a task**:

```bash
curl -X PUT http://localhost:9000/tasks/1 -d "task_name=Updated Task&description=Updated description"
```

- **Delete a task**:

```bash
curl -X DELETE http://localhost:9000/tasks/1
```# giftcard8Test
