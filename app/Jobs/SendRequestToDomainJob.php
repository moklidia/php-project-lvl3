<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;
use GuzzleHttp\Client;

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
    public function handle(Client $client)
    {
        $response = $client->request('GET', $this->domain->name);
        if ($response->getStatusCode() === 404) {
            $this->domain->statusCode = $response->getStatusCode();
            $this->domain->reject();
            $this->domain->save();
        } else {
            $this->domain->statusCode = $response->getStatusCode();
            $this->domain->contentLength = isset($response->getHeader('Content-Length')[0]) ?
                                           $response->getHeader('Content-Length')[0] : 'unknown';
            $this->domain->body = $response->getBody()->getContents();
            $this->domain->save();
            dispatch(new ParseHtmlJob($this->domain));
        }
    }
}
