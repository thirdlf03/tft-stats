<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Result;
use Illuminate\Http\Request;

class BookmarkContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $bookmark)
    {
    $result_id = $request->input('result_id');
    $bookmark_id = $bookmark;


    $result = Bookmark::find($result_id);

    $result->bookmark_contents()->attach($bookmark_id);

        return redirect()->route('results.index')->with('showModal', true);
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
    public function destroy(Bookmark $bookmark, Result $result)
    {
        //  $->liked()->detach(auth()->id());
        //return back();
    }
}
