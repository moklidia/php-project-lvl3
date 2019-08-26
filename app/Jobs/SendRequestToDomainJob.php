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
        $response = $client->get($this->domain->name);
        if ($response->getStatusCode() === 404) {
            $this->domain->statusCode = $response->getStatusCode();
            $this->domain->reject();
            $this->domain->save();
        } else {
            $this->domain->statusCode = $response->getStatusCode();
            $this->domain->contentLength = isset($response->getHeader('Content-Length')[0]) ?
                                           $response->getHeader('Content-Length')[0] : 'unknown';
            $this->domain->body = $response->getBody()->getContents();
            return $this->parse();
        }
    }

    public function parse()
    {
        $document = new Document($this->domain['name'], true);
        $this->domain->h1 = $document->has('h1') ? $document->first('h1')->text() : 'no h1';
        $this->domain->keywords = $document->has('meta[name=keywords]') ?
                                  $document->find('meta[name=keywords]')[0]->attr('content') : 'no keywords';
        $this->domain->description = $document->has('meta[name=description]') ?
                                     $document->find('meta[name=description]')[0]->attr('content') : 'no description';
        
        $this->domain->approve();
        $this->domain->save();
    }
}
