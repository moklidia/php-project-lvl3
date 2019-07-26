<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Domain;
use View;

class DomainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

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
        $domain = Domain::create([
            'name' => $request->input('name')
        ]);
        $id = $domain->id;
        return redirect()->route('domain', ['id' => $id]);
    }
}
