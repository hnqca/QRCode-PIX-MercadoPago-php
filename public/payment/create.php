<?php

    // configurações gerais. Conexão com o banco de dados e credenciais do mercado pago.
    require_once  __DIR__ . '/../../app/config.php';

    /**
     * $_POST['data']:
     * string:      $nickname
     * string:      $email
     * string|null: $message
     * float:       $valueToPay
    */
    // Verifica se os dados do formulário foram recebidos.
    if (!isset($_POST['data'])) {
        return responseToJson("error", "É necessário preencher todos os dados obrigatórios antes de enviar.");
    }

    // Recupera os dados do formulário e realiza a validação dos valores.
    $data       = $_POST['data'];
    $message    = htmlspecialchars($data['message'] ?? null);
    $valueToPay = str_replace(',', '.', $data['value']);
   
    // Verifica se o email é válido.
    if (!filter_var($email = $data['email'], FILTER_VALIDATE_EMAIL)) {
        return responseToJson("error", "Informe um email válido.");
    }

    // Verifica se é um apelido válido.
    if (!preg_match('/^[a-zA-Z0-9_.\s]{2,}$/', $nickname = $data['nickname'])) {
        return responseToJson("error", "Informe um apelido válido.");
    }

    // Verifica se o valor da doação é válido.
    if (!filter_var($valueToPay, FILTER_VALIDATE_FLOAT) || $valueToPay <= 0) {
        return responseToJson("error", "informe um valor válido.");
    }
    
    // Será responsável por indentificar a doação na hora da atualização do status.
    $paymentReferenceId = password_hash(uniqid(), PASSWORD_DEFAULT);

    /**
     * Armazena os dados da doação no banco de dados.
     */
    $query = "INSERT INTO donations (id_reference, nickname, email, message, status, value) VALUES (:id_reference, :nickname, :email, :message, :status, :value)";
    $stmt  = $pdo->prepare($query);
    
    $stmt->bindValue(':id_reference', $paymentReferenceId);
    $stmt->bindValue(':nickname',     $nickname);
    $stmt->bindValue(':email',        $email);
    $stmt->bindValue(':message',      $message);
    $stmt->bindValue(':status',       "pending");
    $stmt->bindValue(':value',        $valueToPay);

    $stmt->execute();
    $donationId = $pdo->lastInsertId() ? $pdo->lastInsertId() : false;

    // Verifica se o registro foi armazenado com sucesso.
    if(!$donationId){
        return responseToJson("error", "Ops! Ocorreu um erro inesperado.");
    }

    /**
     * Preparando os dados para enviar ao Mercado Pago.
    */

    // Informações do doador:
    $payer = [
        "first_name" => $nickname,
        "email"      => $email
    ];

    // Informações sobre o pagamento:
    $informations = [
        "notification_url"   => MERCADO_PAGO_CONFIG['notification_url'],
        "description"        => "Doação de {$nickname} para o site (SEU_SITE)",
        "external_reference" => $paymentReferenceId,
        "payment_method_id"  => "pix",
        "transaction_amount" => (double) $valueToPay
    ];
        
    $payment = array_merge(["payer" => $payer], $informations);
    $payment = json_encode($payment);

    
    // Envia os dados via cURL para o Mercado Pago.
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL            => "https://api.mercadopago.com/v1/payments",
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => $payment,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . MERCADO_PAGO_CONFIG['access_token'],
            'Content-Type: application/json'
        ]
    ]);

    // Resposta do Mercado Pago com os dados de pagamento.
    $response = curl_exec($curl);
    curl_close($curl);

    // Converte a resposta para Array.
    $response = json_decode($response, true);
    
    // Filtra somente os dados que serão necessários para a realização do pagamento via Pix.
    $response = $response["point_of_interaction"]["transaction_data"];

    // Retorna os dados em JSON para o JavaScript.
    header('Content-Type: application/json');

    echo json_encode([
        "qr_code"        => $response['qr_code'],        // Código copia e cola.
        "qr_code_base64" => $response['qr_code_base64'] // Imagem do QR Code em base64.
    ]);