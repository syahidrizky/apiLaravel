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
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            $student = Student::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

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
            return ApiFormatter::createApi(400, 'failed');
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
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            $student = Student::findOrFail($id);

            $student->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

            $updatedStudent = Student::where('id', $student->id)->first();
            
            if ($updatedStudent) {
                return ApiFormatter::createApi(200, 'success', $updatedStudent);
            }else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
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
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
}
