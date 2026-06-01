<?php

namespace App\Base;

abstract class Controller
{
    protected ?string $layout = null;
    protected array $viewData = [];

    protected function render(string $view, array $data = []): void
    {
        $data = array_merge($this->viewData, $data);

        extract($data);

        if ($this->layout) {
            ob_start();
        }

        $viewPath = __DIR__ . "/../../views/$view.php";
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \RuntimeException("View not found: $view");
        }

        if ($this->layout) {
            $content = ob_get_clean();
            $layoutPath = __DIR__ . "/../../views/layouts/{$this->layout}.php";
            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                echo $content;
            }
        }
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    protected function redirectWithSuccess(string $url, string $message): void
    {
        Session::setSuccess($message);
        $this->redirect($url);
    }

    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    protected function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    protected function input(string $key, mixed $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }

    protected function requireRole(string|array $roles): void
    {
        Auth::requireRole($roles);
    }
}
