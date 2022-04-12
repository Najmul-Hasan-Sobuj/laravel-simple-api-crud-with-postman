<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Student::get();
        return response()->json([
            'status' => 1,
            'message' => 'all Students Data',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'roll'    => 'required',
            'email'   => 'required',
            'batch'   => 'required',
            'section' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->messages(),
            ]);
        } else {
            $students = new Student();
            $students->roll    = $request->roll;
            $students->email   = $request->email;
            $students->batch   = $request->batch;
            $students->section = $request->section;
            $students->save();

            return response()->json([
                'status' => 1,
                'message' => 'Student was successfully'
            ]);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Student::where('id', $id)->exists()) {
            $data_get = Student::where('id', $id)->get();
            return response()->json([
                'status' => 1,
                'message' => 'data get successfully',
                'data' => $data_get,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'data not get',
            ]);
        }
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
        if (Student::where('id', $id)->exists()) {
            $student          = Student::find($id);
            $student->roll    = !empty($request->roll) ? $request->roll  : $student->roll;
            $student->email   = !empty($request->email) ? $request->email : $student->email;
            $student->batch   = !empty($request->batch) ? $request->batch : $student->batch;
            $student->section = !empty($request->section) ? $request->section : $student->section;
            $student->save();
            return response()->json([
                'status' => 1,
                'message' => 'data update successfully',
            ]);
        } else {
            return response()->json([
                'status' => 1,
                'message' => 'data update unsuccessfully',
            ]);
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
        if (Student::where('id', $id)->exists()) {
            Student::find($id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'data delete successfully'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'data not delete. try again'
            ]);
        }
    }
}
