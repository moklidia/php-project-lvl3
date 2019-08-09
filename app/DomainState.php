<?php

namespace App;

class DomainState 
{
	private $state;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function __construct($state = 'draft')
    {
    	$this->state = $state;
    }
    public function reject()
    {
    	$this->state = 'rejected';
    }
    public function approve()
    {
    	return $this->state = 'approved';
    }
    public function process()
    {
    	return $this->state = 'processing';
    }
    public function getState()
    {
    	return $this->state;
    }
}