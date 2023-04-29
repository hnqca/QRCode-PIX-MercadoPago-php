<?php
    
    // define o timezone
    date_default_timezone_set('America/Sao_Paulo'); 

    // credenciais de acessos
    require_once __DIR__ . '/credentials.php';

    // conexão com o banco de dados
    require_once __DIR__ . '/database/connection.php';

    // functions úteis que poderão ser reutilizadas em outras páginas.
    require_once __DIR__ . '/functions.php';