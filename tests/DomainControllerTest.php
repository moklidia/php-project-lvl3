<?php

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
}
