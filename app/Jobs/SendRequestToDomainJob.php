<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;

class SendRequestToDomainJob extends Job
{
    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->path = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = app('GuzzleClient');
        
        $response = $client->request('GET', $this->path);
        $domainData = [
            'name' => $this->path,
            'statusCode' => $response->getStatusCode(),
            'contentLength' => isset($response->getHeader('Content-Length')[0]) ?
                               $response->getHeader('Content-Length')[0] : 'unknown',
            'body' => $response->getBody()->getContents()
        ];
        dispatch(new ParseHtmlJob($domainData));
    }
}
