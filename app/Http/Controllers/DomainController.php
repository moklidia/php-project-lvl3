<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Bus\Dispatcher;
use \App\Jobs\SendRequestToDomainJob;
use DiDom\Document;
use GuzzleHttp\Client as GuzzleClient;
use App\Domain;
use View;

class DomainController extends Controller
{
    // protected $domains;

    // public function __construct(Domain $domains)
    // {
    //     $this->domains = $domains;
    // }
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
        dispatch(new SendRequestToDomainJob($url));
        // return redirect()->route('domain', ['id' => $domain->id]);
        return redirect()->route('domains');
    }
}
