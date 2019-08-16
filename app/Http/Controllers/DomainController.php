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
        $errors = [];
        if ($domain->getState() === 'rejected') {
            $errors['message'] = "The page you requested wasn't found";
        }
        return view('domains.show', ['domain' => $domain, 'errors' => $errors]);
    }

    public function store(Request $request)
    {
        $url = $request->input('name');
        $domain = Domain::create([
            'name' => $url,
            'state' => 'draft'
        ]);
        dispatch(new SendRequestToDomainJob($domain));
        return redirect()->route('domain', ['id' => $domain->id]);
    }
}
