<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mysugar;
 

class MysugarController extends Controller
{
    protected $mysugar;
    public function __construct(){
        $this->mysugar = new Mysugar();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->mysugar->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->mysugar->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mysugar = $this->mysugar->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mysugar = $this-> mysugar->find($id);
        $mysugar->update($request->all());
        return  $mysugar;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mysugar = $this->mysugar->find($id);
        return  $mysugar->delete();
    }
}
