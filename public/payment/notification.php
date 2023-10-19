<?php
   // Conexão com o banco de dados e credenciais do mercado pago
   require_once __DIR__ . '/../../app/config.php';

   $paymentId = $_REQUEST['id'] ?? null;

   if (!$paymentId) {
      header("location: ../index.php");
      die;
   }

   // Captura as informações do pagamento com base na ID recebida:
   $curl = curl_init();
   curl_setopt_array($curl, [
      CURLOPT_URL            => 'https://api.mercadopago.com/v1/payments/' . $paymentId,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST  => 'GET',
      CURLOPT_HTTPHEADER     => [
          'accept: application/json',
          'content-type: application/json',
          'Authorization: Bearer ' . MERCADO_PAGO_CONFIG['access_token']
      ]
   ]);

   $response = curl_exec($curl);
   $response = json_decode($response, true);

   curl_close($curl);

   $externalReference = $response['external_reference'];
   $status            = $response['status'];                     // Status do pagamento ("approved", "pending", "recused").
   $valuePayment      = (float) $response['transaction_amount']; // Valor da doação.


   // Seleciona o registro de pagamento do banco de dados de acordo com o "ReferenceId" que foi recebido pela API do Mercado Pago.
   $sql  = "SELECT id, value FROM donations WHERE external_reference = :external_reference";
   $stmt = $pdo->prepare($sql);

   $stmt->bindValue(':external_reference', $externalReference);
   $stmt->execute();

   $paymentDatabase = $stmt->fetch(PDO::FETCH_ASSOC) ?? false;

  if (!$paymentDatabase['id'] OR $paymentDatabase['value'] != $valuePayment) {
      header("location: ../index.php");
      die;
  }

   // atualiza o status do pagamento para "approved" ou "recused".
   $sql  = "UPDATE donations SET status = :status, updated_at = :updated_at WHERE id = :id";
   $stmt = $pdo->prepare($sql);

   $stmt->bindValue(':status',     $status);
   $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
   $stmt->bindValue(':id',         $paymentDatabase['id']);
   
   $stmt->execute();

   header("location: ../index.php");