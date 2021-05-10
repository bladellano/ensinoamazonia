
<?php

use Source\Controller\SiteController;
use Source\Controller\MailerController;

$app->post('/send-form-contact', MailerController::class . ':sendFormContact');

$app->get('/', SiteController::class . ':index');

$app->get('/sampler', SiteController::class . ':sampler');
$app->get('/albuns', SiteController::class . ':albums');
$app->get('/album/{id}', SiteController::class . ':showPhotos');

$app->get('/eventos', SiteController::class . ':events');//conteúdo dinâmico.
$app->get('/evento/{slug}', SiteController::class . ':showEvent');//conteúdo dinâmico.

$app->get('/noticias', SiteController::class . ':articles');//conteúdo dinâmico.
$app->get('/noticia/{slug}', SiteController::class . ':showArticle');//conteúdo dinâmico.

$app->get('/{slug}', SiteController::class . ':showPage');
/* Páginas avulsas */
// $app->get('/{slug}', SiteController::class . ':showPage');
/* Albuns */
// $app->get('/albuns', SiteController::class . ':albums');//conteúdo dinâmico.
// $app->get('/albuns/{id}', SiteController::class . ':showAlbum');//conteúdo dinâmico.
/* Eventos */
// $app->get('/eventos', SiteController::class . ':events');//conteúdo dinâmico.
/* Noticias */