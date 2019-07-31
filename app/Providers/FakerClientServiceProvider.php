<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class FakerClientServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $body = file_get_contents('/Users/admin/hexlet/php/page-analyzer/tests/fixtures/test.html');
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => 15], $body)
        ]);
        $handler = HandlerStack::create($mock);
        $this->app->bind('GuzzleClient', function ($app) use ($handler) {
            return new Client(['handler' => $handler]);
        });
    }
}
