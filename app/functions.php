<?php

    function responseToJson(string $status, string $message, array $data = null){
        header('Content-Type: application/json');
        echo json_encode(['status' => $status, 'message' => $message, $data]);
    }

    function formatFloatToDecimal(float $value){
        return number_format($value, 2, ',', ' ');
    }