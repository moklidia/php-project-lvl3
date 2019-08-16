<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'state', 'statusCode', 'contentLength', 'body', 'h1', 'keywords', 'description'];
    public function construct($state = 'draft')
    {
        $this->state = $state;
    }
 
    public function approve()
    {
        return $this->state = 'approved';
    }

    public function reject()
    {
        return $this->state = 'rejected';
    }

    public function getState()
    {
        return $this->state;
    }
}
