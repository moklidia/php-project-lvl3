<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class ExampleTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testHomePage() 
	{
		$this->get('/');

		$this->assertResponseOk();
	}

	public function testDomainStore() 
	{
		$this->post('/domains', ['name' => 'https://www.google.com']);
		$this->seeInDatabase('domains', ['name' => 'https://www.google.com']);
		$this->assertResponseStatus(302);
	}

	public function testDomainIndex()
	{

		$this->get('domains');
		$this->assertResponseStatus(200);
	}

}
