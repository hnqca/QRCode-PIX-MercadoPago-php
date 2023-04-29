
<div align="center">
  <h1>
    <img width="110px" src="https://logospng.org/download/mercado-pago/logo-mercado-pago-icone-1024.png" />
    <img width="100px" src="https://devtools.com.br/img/pix/logo-pix-png-icone-520x520.png" />
    <br>QRCode Pix MercadoPago - PHP
  </h1>
    <p>Este é um projeto simples que utiliza a API do Mercado Pago para gerar pagamentos via PIX, incluindo QR Code e código "copia e cola". Além disso, a atualização do status do pagamento é realizada automaticamente no banco de dados MySQL.</p>
</div>

---
## Sobre

O objetivo deste projeto é permitir doações para uma pessoa ou projeto, sem a necessidade de autenticação. O visitante pode contribuir com qualquer valor, bastando preencher alguns dados, como seu apelido, e-mail e mensagem a ser compartilhada com quem acessar o site.

<div align="center">
    <img width="500" src="https://i.ibb.co/S5fsNHz/form-payer.png" />
</div>

<hr>

<div align="center">
  <p>
    Após a aprovação do pagamento, a doação do usuário será exibida na tela inicial do site, contendo o apelido, o valor doado, a data da doação e uma mensagem (se houver). Semelhante ao <b>Buy me a coffee</b> e <b>Twitch</b>. 
  </p>
    <img width="450" src="https://i.ibb.co/TL4zYFG/card-donation.png" /><br>
</div>

<hr>
<div align="center">
    <p>O site também apresenta os maiores doadores.</p>
    <img width="350" src="https://i.ibb.co/ck9S6wp/ranking-donation2.png" /><br>
</div>


---

## ⚙️ Configurações:

Para configurar a conexão com o banco de dados, acesse o arquivo "<b><a href="https://github.com/HenriqueCacerez/QRCode-PIX-MercadoPago-php/blob/main/app/credentials.php">app/credentials.php</a></b>". Adicione o seu <b>"ACCESS_TOKEN"</b> em ``MERCADO_PAGO_CONFIG`` para receber os valores das doações em sua conta. 

Além disso, é necessário definir a <b>"NOTIFICATION_URL"</b>, que é a URL onde o Mercado Pago enviará as requisições HTTP para alertar sobre o status do pagamento.