<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;

class ParseHtmlJob extends Job
{
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domainData)
    {
        $this->data = $domainData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $document = new Document($this->data['name'], true);
        $this->data['h1'] = $document->has('h1') ? $document->first('h1')->text() : 'no h1';
        $this->data['keywords'] = $document->has('meta[name=keywords]') ?
               $document->find('meta[name=keywords]')[0]->attr('content') : 'no keywords';
        $this->data['description'] = $document->has('meta[name=description]') ?
               $document->find('meta[name=description]')[0]->attr('content') : 'no description';

        dispatch(new CreateDomainJob($this->data));
    }
}
