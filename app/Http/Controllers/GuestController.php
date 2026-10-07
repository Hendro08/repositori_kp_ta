<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KerjaPraktik; 
use App\Models\TugasAkhir;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kp_query = KerjaPraktik::with('user')->where('status', 'disetujui');
        $kp_query->when($search, function ($query, $searchTerm) {
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('judul', 'like', "%{$searchTerm}%")->orWhereHas('user', function ($userQuery) use ($searchTerm){
                    $userQuery->where('nama', 'like', "%{$searchTerm}%")->orWhere('nim', 'like', "%{$searchTerm}%");
                });
            });
        });

        $data_kp = $kp_query->orderBy('tgl_kumpul', 'desc')->get();

        $ta_query = TugasAkhir::with('user')->where('status', 'disetujui');
        $ta_query->when($search, function ($query, $searchTerm) {
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('judul', 'like', "%{$searchTerm}%")->orWhereHas('user', function ($userQuery) use ($searchTerm){
                    $userQuery->where('nama', 'like', "%{$searchTerm}%")->orWhere('nim', 'like', "%{$searchTerm}%");
                });
            });
        });
        $data_ta = $ta_query->orderBy('created_at', 'desc')->get();

        return view('guest.index', [
            'data_kp' => $data_kp,
            'data_ta' => $data_ta
        ]);                            
    }
}
