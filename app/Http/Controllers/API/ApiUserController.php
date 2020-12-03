<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
    * Set user admin
    *
    * @param int $id
    */ 
    public function setAdmin($id){
        $user = User::findOrFail($id);
        $user->admin = 1;
        $user->save();
    }

    /**
    * Unset user admin
    *
    * @param int $id
    */ 
    public function unsetAdmin($id){
        if(auth()->user()->id != $id){
            $user = User::findOrFail($id);
            $user->admin = 0;
            $user->save();
        }
        else{
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->id != $id){
            User::destroy($id);
        }
        else{
            abort(500);
        }
    }
}
