<?php

namespace App\Jobs;

use DiDom\Document;
use App\Domain;

class ParseHtmlJob extends Job
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
