<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
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
        $url = 'https://www.facebook.com';
        $this->post('domains', ['name' => $url]);
        $this->SeeInDatabase('domains', ['name' => $url]);
        $this->assertResponseStatus(302);
    }
}
