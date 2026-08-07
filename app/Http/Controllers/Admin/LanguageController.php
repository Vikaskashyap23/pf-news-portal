<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Language;


class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::latest()->paginate(10);

        return view('admin.languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => [

                'required',
                 Rule::unique('languages','name'),
            ],

             'code' => [
                'required',
                Rule::unique('languages', 'code'),
             ],

        ]);

        Language::create([
            'name' => $request->name,
            'code' => $request->code,
            'status' => 1,
        ]);

        return redirect()
          ->route('languages.index')
          ->with('success' , 'Language Added Successfully');
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
        $language = \App\Models\Language::findOrFail($id);

        return view('admin.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        //  dd($request->all());

        $language = Language::findOrFail($id);
          
        $request->validate([
            'name' => 'required',
            'code' => [
                'required',
                Rule::unique('languages', 'code')->ignore($language->id),
            ],
        ]);


        $language->update([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);

        return redirect()
         ->route('languages.index')
         ->with('success', 'Language update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggleStatus($id)
    {

    $language = Language::findOrFail($id);

    $language->status = !$language->status;

    $language->save();

    return redirect()
    ->route('languages.index')
    ->with('success', 'Language Status Updated Successfully');
    
    }

}
