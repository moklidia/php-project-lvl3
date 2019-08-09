<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;

class ParseHtmlJob extends Job
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
        $document = new Document($this->domainData['name'], true);
        $this->domainData['h1'] = $document->has('h1') ? $document->first('h1')->text() : 'no h1';
        $this->domainData['keywords'] = $document->has('meta[name=keywords]') ?
               $document->find('meta[name=keywords]')[0]->attr('content') : 'no keywords';
        $this->domainData['description'] = $document->has('meta[name=description]') ?
               $document->find('meta[name=description]')[0]->attr('content') : 'no description';

        dispatch(new CreateDomainJob($this->domainData, $this->state));
    }
}
