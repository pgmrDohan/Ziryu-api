<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use Notion2json\Notion2json;

class templateController{
    protected $c;
    public function __construct(ContainerInterface $container){
        $this->c = $container;
    }
    public function index(Request $request, Response $response){
        $response->getBody()->write(json_encode(Notion2json::convert(
            "https://dohan-disk.notion.site/Dohan-Kwon-34f1bf3d841c4a70ba7c8bcbf941c443")));
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
    }
}