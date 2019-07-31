<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;

class ParseHtmlJob extends Job
{
    protected $domainData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domainData)
    {
        $this->domainData = $domainData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $document = new Document($this->domainData['name'], true);
        $domain = Domain::create([
            'name' => $this->domainData['name'],
            'statusCode' => $this->domainData['statusCode'],
            'contentLength' => $this->domainData['contentLength'],
            'body' => $this->domainData['body'],
            'h1' => $document->has('h1') ? $document->first('h1')->text() : 'no h1',
            'keywords' => $document->has('meta[name=keywords]') ?
                          $document->find('meta[name=keywords]')[0]->attr('content') : 'no keywords',
            'description' => $document->has('meta[name=description]') ?
                             $document->find('meta[name=description]')[0]->attr('content') : 'no description'
                         ]);
    }
}
