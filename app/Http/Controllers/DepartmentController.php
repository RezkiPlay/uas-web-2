<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('department.index', [
            'title' => 'Departemen',
            'departments' => Department::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create', [
            'title' => 'Tambah Departemen',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ], [
            'name.required' => 'Nama departemen wajib diisi',
            'name.max' => 'Nama departemen tidak boleh melebihi 255 karakter',
        ]);

        DB::beginTransaction();
        try {
            Department::create($validate);
            DB::commit();
            return to_route('department.index')->withSuccess('Departemen berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('department.create')->withError('Gagal menambahkan departemen: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('department.edit', [
            'title' => 'Edit Departemen',
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ], [
            'name.required' => 'Nama departemen wajib diisi',
            'name.max' => 'Nama departemen tidak boleh melebihi 255 karakter',
        ]);

        DB::beginTransaction();
        try {
            $department->update($validate);
            DB::commit();
            return to_route('department.index')->withSuccess('Departemen berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('department.edit', $department)->withError('Gagal mengubah departemen: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        DB::beginTransaction();
        try {
            // Check if department is associated with any job postings (when it exists)
            // For now, since job postings table is not created yet, we can check later.
            // Or just do a simple delete
            $department->delete();
            DB::commit();
            return to_route('department.index')->withSuccess('Departemen berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('department.index')->withError('Gagal menghapus departemen: ' . $e->getMessage());
        }
    }
}
