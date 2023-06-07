<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        if ($students) {
            return ApiFormatter::createApi(200, 'succes', $students);
        }else {
            return ApiFormatter::createApi(400, 'failed');
        }
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nis' => 'required',
                'nama' => 'required',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            $newName = '';
            if($request->file){
                $extension = $request->file('file')->getClientOriginalExtension();
                $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
                $request->file('file')->move(public_path('/storage'), $newName);
            }
    
            $request['image'] = $newName;
            $student = Student::create($request->all());

            // $student = Student::create([
            //     'nis' => $request->nis,
            //     'nama' => $request->nama,
            //     'rombel' => $request->rombel,
            //     'rayon' => $request->rayon,
            // ]);

            $getDateSaved = Student::where('id', $student->id)->first();

            if ($getDateSaved) {
                return ApiFormatter::createApi(200, 'succes', $getDateSaved);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }catch (Exception $error){
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $studentDetail = Student::where('id', $id)->first();

            if ($studentDetail) {
                return ApiFormatter::createApi(200, 'success', $studentDetail);
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nis' => 'required',
                'nama' => 'required',
                'rombel' => 'required',
                'rayon' => 'required',
                'image' => 'required',
            ]);

            $student = Student::findOrFail($id);

            $newName = '';
            if($request->file){
                $extension = $request->file('file')->getClientOriginalExtension();
                $newName = $request->title.'-'.now()->timestamp.'.'.$extension;
                $request->file('file')->move(public_path('/storage'), $newName);
            }   
    
            $request['image'] = $newName;
            $students = Student::update($request->all());
            // $student->update([
            //     'nis' => $request->nis,
            //     'nama' => $request->nama,
            //     'rombel' => $request->rombel,
            //     'rayon' => $request->rayon,
            // ]);

            $updatedStudent = Student::where('id', $student->id)->first();
            
            if ($updatedStudent) {
                return ApiFormatter::createApi(200, 'success', $updatedStudent);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $student = Student::findOrFail($id);
            $proses = $student->delete();

            if ($proses) {
                return ApiFormatter::createApi(200, 'success delete data');
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
}
