<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Cocur\BackgroundProcess\BackgroundProcess;

use Notion2json\Notion2json;

class templateController{
    protected $c;
    public function __construct(ContainerInterface $container){
        $this->c = $container;
    }
    public function index(Request $request, Response $response){
        $pageUrl = json_decode($request->getBody())->pageUrl;
        $pageid = Notion2json::id($pageUrl);
        touch($pageid);
        $response->getBody()->write(json_encode(array(
            "pageData"=>"http://localhost:8080/".$pageid
        )));
        $response->withHeader("Content-type","application/json");
        $process = new BackgroundProcess(sprintf('php ../packages/convert.php %s %s',$pageUrl,$pageid));
        $process->run();
        return $response;
    }
}