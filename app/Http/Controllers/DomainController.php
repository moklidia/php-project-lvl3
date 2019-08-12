<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Bus\Dispatcher;
use \App\Jobs\SendRequestToDomainJob;
use App\DomainState;
use App\Domain;
use View;

class DomainController extends Controller
{

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
        $domain = Domain::create([
            'name' => $url,
            'state' => 'draft'
        ]);
        dispatch(new SendRequestToDomainJob($domain));
        sleep(5);
        dd($domain->getState());
        if ($domain->getState() === 'approved') {
            return redirect()->route('domain', ['id' => $domain->id]);
        }
        return redirect()->route('home');
    }
}
