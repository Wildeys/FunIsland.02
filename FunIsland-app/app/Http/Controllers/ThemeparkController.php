<?php

namespace App\Http\Controllers;

use App\Models\themepark;
use Illuminate\Http\Request;

class ThemeparkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themeparks = themepark::all();
        return view('themeparks.index', compact('themeparks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('themeparks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $themepark = themepark::create($request->all());
        return redirect()->route('themeparks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(themepark $themepark)
    {
        return view('themeparks.show', compact('themepark'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(themepark $themepark)
    {
        return view('themeparks.edit', compact('themepark'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, themepark $themepark)
    {
        $themepark->update($request->all());
        return redirect()->route('themeparks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(themepark $themepark)
    {
        $themepark->delete();
        return redirect()->route('themeparks.index');
    }
}
