<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DiDom\Document;
use DiDom\Query;
use GuzzleHttp;
use App\Domain;
use View;

class DomainController extends Controller
{
   private $client;

    public function __construct(GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }
    public function index()
    {
        $domains = Domain::paginate(10);
        return view('domains.index', [
            'domains' => $domains,
        ]);
    }

    public function show($id)
    {
        $domain = Domain::find($id);
        return view('domains.show', [
            'domain' => $domain
        ]);
    }

    public function store(Request $request)
    {
        $url = $request->input('name');
        $response = $this->client->request('GET', $url);
        $document = new Document($url, true);
        $domain = Domain::create([
            'name' => $url,
            'statusCode' => $response->getStatusCode(),
            'contentLength' => isset($response->getHeader('Content-Length')[0]) ? : 'unknown',
            'body' => $response->getBody()->getContents(),
            'h1' => $document->has('h1') ? $document->first('h1')->text() : 'no h1',
            'keywords' => $document->has('meta[name=keywords]') ?
                          $document->find('meta[name=keywords]')[0]->attr('content') : 'no keywords',
            'description' => $document->has('meta[name=description]') ?
                             $document->find('meta[name=description]')[0]->attr('content') : 'no description'
        ]);
        return redirect()->route('domain', ['id' => $domain->id]);
    }
}
