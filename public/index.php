<?php
require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;

$response = new Response();

$app->get('/',function(){//usando a mágica do silex para returnar uma Responsse
    return '<h3>APIS e Silex</h3>
<p>Este projeto faz parte é o exercício do curso APIS e Silex da Code.education.</p>';

});

$app->get('/ola/{nome}',function($nome){
    return "<h3>Olá, {$nome}</h3>";
});

$app->run();