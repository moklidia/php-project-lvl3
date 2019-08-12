<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;

class SendRequestToDomainJob extends Job
{
    private $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = app('GuzzleClient');
        $response = $client->request('GET', $this->domain->name);
        $this->domain->statusCode = $response->getStatusCode();
        $this->domain->contentLength = isset($response->getHeader('Content-Length')[0]) ?
                                 $response->getHeader('Content-Length')[0] : 'unknown';
        $this->domain->body = $response->getBody()->getContents();
 
        $this->domain->request();
        
        dispatch(new ParseHtmlJob($this->domain));
    }
}
