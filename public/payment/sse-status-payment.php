<?php
    require_once __DIR__ . '/../../app/config.php';

    if (!isset($_GET['external_reference'])){
        die;
    }

    ob_start();

    header("Content-Type: text/event-stream");
    header('Cache-Control: no-cache');

    $externalReference = htmlspecialchars(strip_tags($_GET['external_reference']));

    while (true) {

        $sql  = "SELECT id FROM donations WHERE external_reference = :external_reference AND status = 'approved'";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':external_reference', $externalReference);
        $stmt->execute();

        $isPaymentApproved = $stmt->fetch(PDO::FETCH_ASSOC) ?? false;
        $isPaymentApproved = isset($isPaymentApproved['id']);

        echo "event: statusPayment\n";
        echo "data: " . $isPaymentApproved;
        echo "\n\n";

        ob_end_flush();
        flush();

        sleep(5); // Espera por 5 segundos antes de verificar o status novamente
    }