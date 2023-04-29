<?php
    require_once __DIR__ . '/../app/config.php';

    // Raking TOP Donations //
    $query = "SELECT value, nickname FROM donations WHERE status = 'approved' ORDER BY value DESC LIMIT 4";
    $stmt  = $pdo->prepare($query);
    $stmt->execute();
    $rankingDonations = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? null;

    // Recent Donations //
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
    <!-- Boostrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="facebook" viewBox="0 0 16 16">
            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
        </symbol>
        <symbol id="instagram" viewBox="0 0 16 16">
            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
        </symbol>
        <symbol id="twitter" viewBox="0 0 16 16">
            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
        </symbol>
    </svg>

    <!-- Hero -->
    <div class="px-4 py-5">
        <div class="d-block mx-auto mb-4 col-lg-2">
            <!-- TOP Ranking Doadores -->
            <?php if($rankingDonations): ?>
            <div class="card" id="ranking-donations">
                    <div class="card-header text-center">Maiores Doadores 🏆</div>
                    <ul class="list-group list-group-flush">
                        <?php foreach($rankingDonations as $rowRakingDonation): ?>
                        <li class="list-group-item"><?= $rowRakingDonation['nickname']; ?>
                            <span class="value-donation">(R$ <?= formatFloatToDecimal($rowRakingDonation['value']); ?>)</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </ul>
            </div>
            <?php endif; ?>
            <!--// TOP Ranking Doadores -->
        </div>
        <div class="text-center">
            <h1 class="display-5 fw-bold text-body-emphasis font-circular-medium">Apoie-nos</h1>
                <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis expedita quasi, sint aperiam ducimus totam nihil aspernatur libero quos.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" data-toggle="modal" data-target="#modalPayer" class="rounded-4 btn btn-lg px-4 gap-3 bg-yellow font-helvetica">Doar ❤️</button>
                </div>
            </div>
        </div>
    </div>
    <!--// Hero -->

    <!-- Recent Donations --->
    <?php if($recentDonations): ?>
    <div class="d-flex justify-content-center bg-soft-yellow">
        <div class="mt-4 row col-lg-5 d-sm-inline-block col-11">
            <p class="text-muted font-circular-medium">DOAÇÕES RECENTES</p>
        
            <!-- User Donation Card -->
                <?php foreach($recentDonations as $rowRecentDonation): 
                    $dateDonation = (new DateTime($rowRecentDonation['updated_at']))->format("d/m/y");
                ?>
                <div class="mb-4 card p-4 rounded-4 user-donation-card">
                    <div>
                        <small class="dateDonation"><?= $dateDonation; ?></small>
                        <img class="user-avatar" src="assets/images/user-placeholder.png" />
                        
                        <span>
                            <a href="#" class="fw-bold text-decoration-none text-black">
                                <?= $rowRecentDonation['nickname']; ?>
                            </a> doou R$ <?= formatFloatToDecimal($rowRecentDonation['value']); ?>.
                        </span>

                        <!-- comment (opcional) -->
                        <?php if(!empty($rowRecentDonation['message'])): ?>
                        <div class="comment card py-2 p-3">
                            <?= $rowRecentDonation['message']; ?>
                        </div> 
                        <?php endif; ?>
                        <!--//-->
                    </div>
                </div>
                <?php endforeach; ?>
            <!--// User Donation Card  -->

        </div>
    </div>
    <?php endif; ?>
    <!--// Recent Donations --->

    <!-- Footer --->
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-4 my-0 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2023 Company, Inc</span>
            </div>
            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
            </ul>
        </footer>
    </div>
    <!--// Footer --->

    <!-- Modal - Capture Informations Payer -->
    <div class="modal fade" id="modalPayer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-3">Seja um doador(a)! 🥰</h1>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
        
                <!-- Body - Payer Information -->
                <div id="modal-body-payer" class="modal-body p-5 pt-0">
                    <form id="form-payer-information" method="POST">

                        <!-- alert -->
                        <div id="alert-form-payer" class="alert alert-danger text-center d-none" role="alert"></div>
                        <!--/ /alert -->
                        
                        <!-- nickname -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="input-nickname" placeholder="Apelido" required>
                            <label for="floatingInput">Apelido</label>
                        </div>

                        <!-- message -->
                        <div class="form-floating mb-3">
                            <textarea rows="2" type="text" class="h-100 form-control rounded-3" id="textarea-message" placeholder="Mensagem"></textarea>
                            <label for="floatingInput">Mensagem (opcional)</label>
                        </div>

                        <!-- email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="input-email" placeholder="name@example.com" required>
                            <label for="floatingInput">Email</label>
                            <p class="mt-2 small">seu email não será compartilhado.</p>
                        </div>

                        <hr/>

                        <!-- value donation -->
                        <label>Valor da doação</label>
                        <div class="input-group input-group-lg mt-1 mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-lg">R$</span>
                            <input type="text" class="form-control" id="input-valuePayer" placeholder="0,00" required>
                        </div>
                        
                        <!-- submit -->
                        <button type="submit" class="w-100 border-none mb-2 btn btn-lg btn-warning text-white fw-bold rounded-3">Continuar</button>
                    
                        <div class="text-center">
                            <p class="text-body-secondary small mt-2 mb-3">
                                <img src="assets/images/mp-logo.png" width="28" /> Pagamento via PIX com Mercado Pago.
                            </p>
                        </div>

                    </form>
                </div>
                <!--// Body - Payer Information -->

                <!-- Body - Payment Pix -->
                <div id="modal-body-payment" class="modal-body text-center d-none" style="margin-top: -30px;">
                    <img id="load" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif?20151024034921" style="max-width: 100%;" />
                    <div class="row d-none" id="dix-pix">
                        <div class="col-md-12">
                            <img src="" id="img-pix" width="400" style="max-width: 100%;">
                        </div>
                        <div class="col-md-12">
                            <textarea name="code-pix" class="form-control" id="code-pix" rows="5" cols="80"></textarea>
                            <button class="w-90 mt-3 rounded-4 btn btn-warning text-white btn-clipboard btn-lg px-4 gap-3" id="copyButton">Copiar</button>
                        </div>
                    </div>
                </div>
                <!--// Body - Payment Pix -->

            </div>
        </div>
    </div>
    <!--// Modal - Capture Informations Payer -->



    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Page JS -->
    <script src="assets/js/pages/page-index.js"></script>

</body>
</html>