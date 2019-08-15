<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain;

class DomainControllerTest extends TestCase
{
    
    public function testRedirectAfterDomainPost()
    {
        $this->post('/domains', ['name' => 'https://www.google.com']);
        $this->assertResponseStatus(302);
    }

    public function testDomainIndex()
    {
        $this->get('domains');
        $this->assertResponseStatus(200);
    }

    public function testDomainStore()
    {
        $url = 'https://www.facebook.com';
        $this->post('/domains', ['name' => $url]);
        $this->SeeInDatabase('domains', ['name' => $url]);
    }
}
