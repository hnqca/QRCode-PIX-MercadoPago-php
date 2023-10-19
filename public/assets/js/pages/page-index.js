const form = {
    donation: $('#form-donation')
}

const modalBody = {
    payer:    $("#modal-body-payer"),     // informações do doador
    payment:  $('#modal-body-payment'),  // informações para o doador realizar o pagamento.
    approved: $('#modal-body-approved') // pagamento aprovado.
}

form.donation.on('submit', async function (e) {

    e.preventDefault();

    const data = {
        nickname:   $(this).find('#nickname').val(),
        email:      $(this).find('#email').val(),
        message:    $(this).find('#message').val(),
        valueToPay: $(this).find('#value').val()
    }

    modalBody.payer.addClass('d-none');
    modalBody.payment.removeClass('d-none');

    const response = await sendFormDataToGeneratePixPayment(data);
    let status     = response.status || "error";

    if (status !== "success") {
        $('#alert-donation').text(response.message || "erro desconhecido" );
        $('#alert-donation').removeClass("d-none");

        modalBody.payer.removeClass('d-none');
        modalBody.payment.addClass('d-none');
        return;
    }

    showInformationToPay(response.data);

});

const sendFormDataToGeneratePixPayment = async (data) => {
    
    const response = await fetch(`payment/create.php`, {
        method:    "POST",
        body:      JSON.stringify({data: data}),
        headers: { 
            'Content-Type': 'application/json'
        }
    });

    return response.json() || null;
}


const showInformationToPay = (information) => {

    const codePix           = information.code;
    const QRCodePixBase64   = information.qr_code_base64;
    const externalReference = information.external_reference;

    $("#code-pix").val(codePix);
    $("#image-qrcode-pix").attr('src', 'data:image/jpeg;base64,' + QRCodePixBase64);

    $('#loading').addClass('d-none');
    $("#payment-content").removeClass('d-none');

    $("#copyButton").click(function() {
        var copyText = $("#code-pix");
        copyText.select();
        document.execCommand("copy");
        $('#copyButton').text("Copiado! :)");
    });

    showApprovedPaymentStatus( externalReference );
}

const showApprovedPaymentStatus = ( externalReference ) => {
    const eventSource = new EventSource(`payment/sse-status-payment.php?external_reference=${externalReference}`);

    eventSource.addEventListener('statusPayment', e => {

        let statusPayment = e.data;
        
        if (statusPayment) {
            eventSource.close();
            startConfettiEffect();

            $('#modal-title').text('pagamento aprovado com sucesso! 🥳');
            modalBody.payment.addClass('d-none');
            modalBody.approved.removeClass('d-none');
        } 
    });
}

const startConfettiEffect = () => {

    var end    = Date.now() + (5 * 1000);
    var colors = ['#f05467', '#ffae62'];
    
    (function frame() {
      confetti({
        particleCount: 2,
        angle: 60,
        spread: 55,
        origin: { x: 0 },
        colors: colors
      });
      confetti({
        particleCount: 2,
        angle: 120,
        spread: 55,
        origin: { x: 1 },
        colors: colors
      });
    
      if (Date.now() < end) {
        requestAnimationFrame(frame);
      }
    }());
}