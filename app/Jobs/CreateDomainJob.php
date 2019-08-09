<?php

namespace App\Jobs;

class CreateDomainJob extends Job
{
    private $domainData;
    private $state;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domainData, $state)
    {
        $this->domainData = $domainData;
        $this->state = $state;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $domain = \App\Domain::create([
            'name' => $this->domainData['name'],
            'statusCode' => $this->domainData['statusCode'],
            'contentLength' => $this->domainData['contentLength'],
            'body' => $this->domainData['body'],
            'h1' => $this->domainData['h1'],
            'keywords' => $this->domainData['keywords'],
            'description' => $this->domainData['description']
        ]);
        $this->state->approve();
    }
}
