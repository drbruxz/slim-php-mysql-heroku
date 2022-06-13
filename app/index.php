<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
require_once './middlewares/Logger.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Set basepath
// $app->setBasePath('/app');
// php -S localhost:666 -t app
// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('[/]', \UsuarioController::class . ':TraerTodos');
  $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
  $group->post('[/]', \UsuarioController::class . ':CargarUno');
})->add(\Logger::class . ':LogOperacion');

$app->group('/credenciales', function (RouteCollectorProxy $group) {
  $group->get('[/{usuario}]', \UsuarioController::class . ':TraerUno');
  $group->post('[/]',  \UsuarioController::class . ':TraerUnoPorBody');
})->add(\Logger::class . ':Bienvenida');

$app->get('[/]', function (Request $request, Response $response) {
  $response->getBody()->write("Slim Framework 4 PHP GERONIMO BORDONE");
  return $response;
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->post('[/]', \MesaController::class . ':CargarUno');
  $group->get('[/{codigoMesa}]', \MesaController::class . ':TraerUno');
  $group->put('[/{codigoMesa}]', \MesaController::class . ':ModificarUno');
  $group->delete('[/{codigoMesa}]', \MesaController::class . ':BorrarUno');
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->post('[/]', \PedidoController::class . ':CargarUno');
  $group->get('[/{codigoPedido}]', \PedidoController::class . ':TraerUno');
  $group->put('[/{codigoPedido}]', \PedidoController::class . ':ModificarUno');
  $group->delete('[/{codigoPedido}]', \PedidoController::class . ':BorrarUno');
});

$app->run();
