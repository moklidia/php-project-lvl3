<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Http\Controllers\DomainController;
use Illuminate\Http\Request;
use App\Domain;

class DomainControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testDomainIndex()
    {
        $this->get('domains');
        $this->assertResponseStatus(200);
    }

    public function testDomainShow()
    {
        $domain = Domain::create(['name' => 'testdomain.com', 'state' => 'approved']);
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
