<div align="center">
  <h1>
    <img width="110px" src="https://logospng.org/download/mercado-pago/logo-mercado-pago-icone-1024.png" />
    <img width="100px" src="https://devtools.com.br/img/pix/logo-pix-png-icone-520x520.png" />
    <br>QRCode Pix MercadoPago - PHP
  </h1>
    <p>Este é um projeto simples que utiliza a API do Mercado Pago para gerar pagamentos via PIX, incluindo QR Code e código "copia e cola". Além disso, a atualização do status do pagamento é realizada automaticamente no banco de dados MySQL.</p>
</div>

---
## Demonstração:

<div align="center">
    <img width="100%" src="_readme/demo.gif" />
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
    <p>Se o pagamento for aprovado enquanto o usuário ainda estiver no site, automaticamente uma mensagem será enviado a ele.</p>
    <img width="450" src="_readme/approved.jpg" /><br>
</div>

<hr>
<div align="center">
    <p>O site também apresenta os maiores doadores.</p>
    <img width="350" src="https://i.ibb.co/ck9S6wp/ranking-donation2.png" /><br>
</div>

<hr>

<div align="center">
    <p>Em  <a href="https://www.mercadopago.com.br/home">"Sua atividade"</a> do Mercado Pago, você verá a doação do usuário    apresentada de forma semelhante a isto:</p>
    <img src="_readme/app_mp.jpeg" /><br>
    <img width="700" src="_readme/app_mp2.jpeg" /><br>
</div>
    

---

## ⚙️ Configurações:

Para configurar a conexão com o banco de dados, acesse o arquivo "<b><a href="https://github.com/HenriqueCacerez/QRCode-PIX-MercadoPago-php/blob/main/app/credentials.php">app/credentials.php</a></b>". Adicione o seu <b>"ACCESS_TOKEN"</b> em ``MERCADO_PAGO_CONFIG`` para receber os valores das doações em sua conta. 

Além disso, é necessário definir a <b>"NOTIFICATION_URL"</b>, que é a URL onde o Mercado Pago enviará as notificações para alertar sobre o status do pagamento.


<p>É importante ressaltar que as notificações do Mercado Pago <b>não funcionam em ambientes locais</b>, portanto, será necessário testá-las em um site real que esteja online.</p>

<p>O site precisa ter o certificado SSL habilitado (HTTPS)</p>

---


## 🔑 Mercado Pago (ACCESS TOKEN)
<details>
  <summary><strong>Clique aqui</strong> para ver como obter o seu access token</summary>

  ### 1. Criando uma Aplicação:
  Acesse [https://www.mercadopago.com.br/developers/panel/app](https://www.mercadopago.com.br/developers/panel/app) e crie uma nova aplicação.

  <div align="center">
      <img src="_readme/mp/mp_step_01.png">
  </div>

  ### 2. Dados da Aplicação:
  Exemplo:

  <div align="center">
    <img src="_readme/mp/mp_step_02.png">
  </div>

  ### 3. Acessando sua Aplicação:
  Depois de ter criado a aplicação, retorne às [suas integrações](https://www.mercadopago.com.br/developers/panel/app) e acesse a aplicação que acabou de ser criada.

  <div align="center">
    <img src="_readme/mp/mp_step_03.png">
  </div>

   ### 4. Credenciais de Produção:

  <div align="center">
    <img src="_readme/mp/mp_step_04.png">
  </div>

  ### 5. Salve o seu Access Token:
  Copie o seu Access Token de produção e insira-o no arquivo [app/credentials.php](https://github.com/HenriqueCacerez/QRCode-PIX-MercadoPago-php/blob/main/app/credentials.php)

  <div align="center">
    <img src="_readme/mp/mp_step_05.png">
  </div>

</details>