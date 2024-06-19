<?php

function routeRequest()
{
    $url = $_SERVER['REQUEST_URI'];
    $parts = explode('/', trim($url, '/'));

    if (count($parts) < 2) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
        exit;
    }

    $className = $parts[0];
    $methodName = $parts[1];

    if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $className) || !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $methodName)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid class or method name"]);
        exit;
    }

    $filePath = './classes/' . $className . '.php';

    if (file_exists($filePath)) {
        require $filePath;

        if (class_exists($className)) {
            $instance = new $className;

            if (method_exists($instance, $methodName) && is_callable([$instance, $methodName])) {
                $result = $instance->$methodName();
                echo json_encode($result);
            } else {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Invalid class or method name"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid class or method name"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid class or method name"]);
    }
}
