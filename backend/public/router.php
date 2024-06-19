<?php

function routeRequest()
{
    // get the request URL
    $url = $_SERVER['REQUEST_URI'];
    $parts = explode('/', trim($url, '/'));

    if (count($parts) < 2) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
        exit;
    }

    // get the class and method name
    $className = $parts[0];
    $methodName = $parts[1];

    if (!isValidName($className) || !isValidName($methodName)) {
        sendErrorResponse("Invalid class or method name");
    }

    // check if the class and method exist
    $filePath = './classes/' . $className . '.php';
    if (!file_exists($filePath)) {
        sendErrorResponse("Invalid class or method name");
    }
    require $filePath;

    // check if the class and method exist
    if (!class_exists($className)) {
        sendErrorResponse("Invalid class or method name");
    }
    $instance = new $className;

    // check if the method exists and is callable
    if (!method_exists($instance, $methodName) || !is_callable([$instance, $methodName])) {
        sendErrorResponse("Invalid class or method name");
    }

    // call the method and return the result
    $result = $instance->$methodName();
    echo json_encode($result);
}

// check if a string is a valid class or method name
function isValidName($name)
{
    return preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $name);
}

// send an error response
function sendErrorResponse($message)
{
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $message]);
    exit;
}
