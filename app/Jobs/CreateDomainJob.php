<?php

namespace App\Jobs;

class CreateDomainJob extends Job
{
    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $domain = \App\Domain::create([
            'name' => $this->data['name'],
            'statusCode' => $this->data['statusCode'],
            'contentLength' => $this->data['contentLength'],
            'body' => $this->data['body'],
            'h1' => $this->data['h1'],
            'keywords' => $this->data['keywords'],
            'description' => $this->data['description']
        ]);
        return $domain;
    }
}
