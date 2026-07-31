<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
// use App\Http\Requests\StoreWebsiteRequest;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "website controller working";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('websites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        

        Website::create([
            'name' => $request-> name,
            'slug' =>  $request-> slug,
            'logo' => null,
            'favicon' => null,
            'language' => $request->language,
            'theme'  => $request->theme,
            'domain' => $request->domain,
            'status' =>  true,

        ]);

        return "Website saved Succesfullly";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
