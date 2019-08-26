<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Domain;

class DomainControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp():void
    {
        parent::setUp();
        $path = __DIR__ . '/fixtures/test.html';
        $body = file_get_contents($path);
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => 15], $body)
        ]);
        $handler = HandlerStack::create($mock);
        $this->app->bind('GuzzleHttp\Client', function ($app) use ($handler) {
            return new Client(['handler' => $handler]);
        });
    }

    public function testDomainIndex()
    {
        $this->get('domains');
        $this->assertResponseStatus(200);
    }

    public function testDomainShow()
    {
        $domain = factory('App\Domain')->make();
        $domain->approve();
        $domain->save();
        $this->get('/domains/' . $domain->id);
        $this->assertResponseStatus(200);
    }

    public function testDomainStore()
    {
        $path = __DIR__ . '/fixtures/test.html';
        $this->post('domains', ['name' => $path]);
        $this->seeInDatabase('domains', [
            'name' => $path,
            'contentLength' => "15",
            'h1' => 'Heading',
            'description' => 'A simple html page to test app API'
        ]);
        $this->assertResponseStatus(302);
    }
}
