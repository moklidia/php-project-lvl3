<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;

class SendRequestToDomainJob extends Job
{
    private $path;
    private $state;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $state)
    {
        $this->path = $url;
        $this->state = $state;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->state->process();
        $client = app('GuzzleClient');
        $response = $client->request('GET', $this->path);
        $domainData = [
            'name' => $this->path,
            'statusCode' => $response->getStatusCode(),
            'contentLength' => isset($response->getHeader('Content-Length')[0]) ?
                               $response->getHeader('Content-Length')[0] : 'unknown',
            'body' => $response->getBody()->getContents()
        ];
        dispatch(new ParseHtmlJob($domainData, $this->state));
    }
}
