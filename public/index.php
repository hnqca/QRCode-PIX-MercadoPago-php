<?php
    require_once __DIR__ . '/../app/config.php';

    // Ranking
    $query = "SELECT value, nickname FROM donations WHERE status = 'approved' ORDER BY value DESC LIMIT 4";
    $stmt  = $pdo->prepare($query);
    $stmt->execute();
    $rankingDonations = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? null;

    // Donations
    $query = "SELECT value, nickname, message, updated_at FROM donations WHERE status = 'approved' ORDER BY updated_at DESC";
    $stmt  = $pdo->prepare($query);
    $stmt->execute();
    $recentDonations = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja um doador(a)!</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Hero -->
    <div class="px-4 py-5">
        <div class="d-block mx-auto mb-4 col-lg-2">

            <!-- Ranking -->
            <?php if($rankingDonations): ?>
            <div class="card" id="ranking-donations">
                    <div class="card-header text-center">Maiores Doadores 🏆</div>
                    <ul class="list-group list-group-flush">
                        <?php foreach($rankingDonations as $ranking): ?>
                        <li class="list-group-item"><?= $ranking['nickname']; ?>
                            <span class="value-donation">(R$ <?= number_format($ranking['value'], 2, ',', ' '); ?>)</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </ul>
            </div>
            <?php endif; ?>
            <!--/ Ranking -->

        </div>
        <div class="text-center">
            <h1 class="display-5 fw-bold text-body-emphasis font-circular-medium">Apoie-nos</h1>
                <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis expedita quasi, sint aperiam ducimus totam nihil aspernatur libero quos.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button data-toggle="modal" data-target="#modal-donation" class="btn btn-warning btn-lg rounded-4">Doar ❤️</button>
                </div>
            </div>
        </div>
    </div>
    <!--// Hero -->

    <!-- Doações Recentes --->
    <?php if($recentDonations): ?>
    <div class="d-flex justify-content-center bg-soft-yellow">
        <div class="mt-4 row col-lg-5 d-sm-inline-block col-11">
            <p class="text-muted font-circular-medium">DOAÇÕES RECENTES</p>
        
            <!-- Doação do Usuário -->
                <?php foreach($recentDonations as $donation): 
                    $dateDonation = (new DateTime($donation['updated_at']))->format("d/m/y");
                ?>
                <div class="mb-4 card p-4 rounded-4 user-donation-card">
                    <div>
                        <small class="dateDonation"><?= $dateDonation; ?></small>
                        <img class="user-avatar" src="assets/images/user-placeholder.png" />
                        
                        <span>
                            <a href="#" class="fw-bold text-decoration-none text-black">
                                <?= $donation['nickname']; ?>
                            </a> doou R$ <?= number_format($donation['value'], 2, ',', ' '); ?>.
                        </span>

                        <!-- comentário (opcional) -->
                        <?php if(!empty($donation['message'])): ?>
                        <div class="comment card py-2 p-3">
                            <?= $donation['message']; ?>
                        </div> 
                        <?php endif; ?>
                        <!--//-->
                    </div>
                </div>
                <?php endforeach; ?>
            <!--// Doação do Usuário -->

        </div>
    </div>
    <?php endif; ?>
    <!--// Doações Recentes --->

    <!-- Modal - Doação  -->
    <div class="modal fade" id="modal-donation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-3" id="modal-title">Seja um doador(a)! 🥰</h1>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body - Informações do Doador -->
            <div id="modal-body-payer" class="modal-body p-5 pt-0">
                <form id="form-donation">
                    
                    <div id="alert-donation" class="alert alert-danger text-center d-none" role="alert"></div>
                    
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="nickname" placeholder="Apelido" required autofocus>
                        <label for="nickname">Apelido</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea rows="2" class="form-control rounded-3" id="message" placeholder="Mensagem"></textarea>
                        <label for="message">Mensagem (opcional)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3" id="email" placeholder="name@example.com" required>
                        <label for="email">Email</label>
                        
                        <small class="mt-2">seu email não será compartilhado.</small>
                    </div>

                    <hr/>

                    <label for="value">Valor da doação</label>
                    <div class="input-group input-group-lg mt-1 mb-3">
                        <span class="input-group-text">R$</span>
                        <input type="text" class="form-control" id="value" placeholder="0,00" required>
                    </div>
                    
                    <button type="submit" class="w-100 border-none mb-2 btn btn-lg btn-warning text-white fw-bold rounded-3">Continuar</button>
                
                    <div class="text-center">
                        <p class="text-body-secondary small mt-2 mb-3">
                            <img src="assets/images/mp-logo.png" width="28" /> Pagamento via PIX com Mercado Pago.
                        </p>
                    </div>
                </form>
            </div>
            <!--// Body - Informações do Doador -->

            <!-- Body - Realização da doação via PIX -->
            <div id="modal-body-payment" class="modal-body text-center d-none">
                
                <div id="loading" class="text-center mb-4 mt-4">
                    <div class="spinner-border text-warning" style="width: 5rem; height: 5rem;" role="status"></div>
                </div>

                <div class="row d-none" id="payment-content">
                    <div class="col-md-12">
                        <img src="" id="image-qrcode-pix" style="width: 100%;" />
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" id="code-pix" rows="5" cols="80"></textarea>
                        <button class="w-90 mt-3 rounded-4 btn btn-warning text-white btn-clipboard btn-lg px-4 gap-3" id="copyButton">Copiar</button>
                    </div>
                </div>
            </div>
            <!--// Body - Realização da doação via PIX -->

            <!-- Body - Pagamento Aprovado -->
            <div id="modal-body-approved" class="modal-body text-center d-none">
                <p class="h5">Atualize a página para ver a sua doação =)</p>
            </div>
            <!--// Body - Pagamento Aprovado -->
        </div>
    </div>
</div>
<!--// Modal - Doação  -->


    <!-- Confetti Effect -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.0/dist/confetti.browser.min.js"></script>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Page JS -->
    <script src="assets/js/pages/page-index.js"></script>

</body>
</html>