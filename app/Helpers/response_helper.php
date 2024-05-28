<?php

if (!function_exists('successResponse')) {
    function successResponse($status, $message, $data = null, $token = null): array
    {
        if ($data === null) {
            return [
                "status" => $status,
                "message" => $message,
            ];
        }

        if ($token !== null) {
            return [
                "status" => $status,
                "message" => $message,
                "data" => $data,
                "token" => $token
            ];
        }

        return [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($status, $message, $error): array
    {
        return array(
            "status" => $status,
            "message" => $message,
            "error" => $error
        );
    }
}

if (!function_exists('failResponse')) {
    function failResponse($status, $message): array
    {
        return array(
            "status" => $status,
            "message" => $message
        );
    }
}

