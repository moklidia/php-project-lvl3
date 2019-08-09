<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Http\Controllers\DomainController;
use App\Domain;

class GuzzleClientTest extends TestCase
{

    public function testDomainsClient()
    {
        $body = file_get_contents(__DIR__ . '/fixtures/test.html');
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => 15], $body)
        ]);
        $handler = HandlerStack::create($mock);
        $controller = new DomainController();
        $request = new Request();
        $request->merge(['name' => __DIR__ . '/fixtures/test.html']);
        $controller->store($request);
        $this->seeInDatabase('domains', [
            'name' => __DIR__ . '/fixtures/test.html',
            'contentLength' => "15",
            'body' => $body,
            'h1' => 'Heading',
            'description' => 'A simple html page to test app API'
        ]);
    }
}
