<?php

    function jsonResponse(string $status, string $message, ?array $data = null)
    {
        header("Content-Type: application/json");

        $response = [
            "status"  => $status,
            "message" => $message,
            "data"    => $data
        ];
    
        $json = json_encode($response, JSON_PRETTY_PRINT);

        die ($json);
    }


    function checkDataRequest(array $requiredFields = null)
    {
        $data = json_decode(file_get_contents('php://input'))->data ?? false;

        if (!$data) {
            return jsonResponse("error", "nenhum dado enviado na requisição.");
        }

        if ($requiredFields) {
            foreach ($requiredFields as $key) {
                if (!isset($data->$key)) {
                    $values = implode(", ", $requiredFields);
                    return jsonResponse("error", "({$values}). São dados obrigatórios.");
                }
            }
        }

        return $data;
    }