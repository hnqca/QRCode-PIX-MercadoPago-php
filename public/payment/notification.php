<?php

  require_once __DIR__ . '/../../app/config.php';

  if(empty($_GET['id'])){
     header("location: ../index.php");
     exit;
  }
  
  $paymentId = $_GET['id'];

  // Captura as informações do pagamento com base na ID recebida.
  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.mercadopago.com/v1/payments/{$paymentId}?access_token=".MERCADO_PAGO_CONFIG['access_token'],
      CURLOPT_RETURNTRANSFER => true,
  ));
  $response = curl_exec($curl);
  curl_close($curl);


  $paymentInfoMercadoPago = json_decode($response, true);
  $referenceId            = $paymentInfoMercadoPago['external_reference'];

  if(!isset($referenceId)){
     header("location: ../index.php");
     exit;
  }

  // Seleciona o registro de pagamento do banco de dados de acordo com o "ReferenceId" que foi recebido pela API do Mercado Pago.
  $query = "SELECT id, value FROM donations WHERE id_reference = :external_reference AND status != 'approved'";
  $stmt  = $pdo->prepare($query);
  $stmt->bindValue(':external_reference', $referenceId);

  $stmt->execute();
  $paymentDatabase = $stmt->fetch(PDO::FETCH_ASSOC) ?? false;

  if(!$paymentDatabase['id']){
     header("location: ../index.php");
     exit;
  }


  $statusPayment = $paymentInfoMercadoPago['status'];   // Status do pagamento ("approved", "pending", "recused").
  $valuePayment  = $paymentInfoMercadoPago['transaction_amount']; // Valor da doação.

  
   /**
      * Verifica se de fato o pagamento foi aprovado e se o valor do pagamento corresponde ao valor que está salvo no banco de dados.
    */
    if($statusPayment === "approved" AND $valuePayment == $paymentDatabase['value']){
       
      // atualiza o status do pagamento para "approved".
      $sql = "UPDATE donations SET status = 'approved', updated_at = :updated_at WHERE id = :id LIMIT 1";
      $stmt = $pdo->prepare($sql);
     
      $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
      $stmt->bindValue(':id', $paymentDatabase['id'], PDO::PARAM_INT);

      $update = $stmt->execute() ? true : false;

      if(!$update){
         return responseToJson('error', "não foi possível atualizar o status do pagamento.");
      }

    }

    header("location: ../index.php");