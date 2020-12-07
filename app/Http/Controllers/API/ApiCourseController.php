<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->filter;
        $name = $request->name;
        $min = $request->min;
        $max = $request->max;

        if($filter){
            switch($filter){
                case 'name':
                    return Course::where('name', 'like', '%'.$name.'%')->get();
                break;
                case 'duration': case 'price':
                    if($min){
                        if($max){
                            return Course::whereBetween($filter, [$min,$max])->get();
                        }
                        return Course::where($filter, '>=', $min)->get();
                    }
                    elseif($max){
                        return Course::where($filter, '<=', $max)->get();
                    }
                break;
            }
        }
        return Course::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'id_category' => 'required',
        ]);
        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->price = intval($request->price);
        $course->duration = intval($request->duration);
        $course->id_category = intval($request->id_category);

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $course->image = $request->file('image')->store('images/courses');
        }
        $course->save();
        return $course;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Course::findOrFail($id);
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'id_category' => 'required',
        ]);
        $course = Course::findOrFail($id);
        $course->name = $request->name;
        $course->description = $request->description;
        $course->price = intval($request->price);
        $course->duration = intval($request->duration);
        $course->id_category = intval($request->id_category);
        
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $course->image = $request->file('image')->store('images');
        }
        $course->save();
        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pathImage = Course::findOrFail($id)->image;
        Storage::delete($pathImage);
        Course::destroy($id);
    }
}
