<?php



class HomeTest extends TestCase
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
}