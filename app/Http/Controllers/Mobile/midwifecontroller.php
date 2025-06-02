<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Midwive;
use Illuminate\Http\Request;

class MidwifeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $midwives = Midwive::select([
                'midwife_id',
                'name', 
                'email',
                'phone_number',
                'status',
                'profile_picture',
                'start_time',
                'end_time'
            ])->where('status', 'active')
              ->where('role', 'midwife')
              ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data bidan berhasil diambil',
                'data' => $midwives
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data bidan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $midwife = Midwive::select([
                'midwife_id',
                'name', 
                'email',
                'phone_number',
                'status',
                'profile_picture',
                'start_time',
                'end_time'
            ])->where('midwife_id', $id)
              ->where('role', 'midwife')
              ->first();

            if (!$midwife) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data bidan tidak ditemukan'
                ], 404);
            }   

            return response()->json([
                'success' => true,
                'message' => 'Data bidan berhasil diambil',
                'data' => $midwife
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data bidan',
                'error' => $e->getMessage()
            ], 500);
}
}
}
