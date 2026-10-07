<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KerjaPraktik;
use App\Models\TugasAkhir;
use App\Models\User;
use App\Models\SubmissionLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $kp_student = KerjaPraktik::distinct('user_id')->count();
        $ta_student = TugasAkhir::distinct('user_id')->count();

        $approved_kp = KerjaPraktik::where('status', 'disetujui')->count();
        $revisi_kp = KerjaPraktik::where('status', 'revisi')->count();
        $terkumpul_kp = KerjaPraktik::where('status', 'terkumpul')->count();

        $approved_ta = TugasAkhir::where('status', 'disetujui')->count();
        $revisi_ta = TugasAkhir::where('status', 'revisi')->count();
        $terkumpul_ta = TugasAkhir::where('status', 'terkumpul')->count();


        return view('admin.dashboard', [
            'kp_students' => $kp_student,
            'ta_students' => $ta_student,
            'approved_kp' => $approved_kp,
            'revisi_kp' => $revisi_kp,
            'terkumpul_kp' => $terkumpul_kp,
            'approved_ta' => $approved_ta,
            'revisi_ta' => $revisi_ta,
            'terkumpul_ta' => $terkumpul_ta
        ]);
    }

    // KERJA PRAKTIK
    public function indexKp(Request $request)
    {
        $search_nama = $request->input('search_nama');
        $search_judul = $request->input('search_judul');

        $query = KerjaPraktik::with('user')->latest('created_at');

        $query->when($search_nama, function($q, $search_nama){
            return $q->whereHas('user', function($subQ) use ($search_nama){
                $subQ->where('nama', 'like', "%{$search_nama}%");
            });
        });

        $query->when($search_judul, function($q, $search_judul){
            return $q->where('judul', 'like', "%{$search_judul}%");
        });

        $data_kp = $query->paginate(10)->withQueryString();

        return view('admin.data_kp', [
            'data_kp' => $data_kp,
            'search_nama' => $search_nama,
            'search_judul' => $search_judul
        ]);
    }

    public function reviewKp($id)
    {
        $kp = KerjaPraktik::with('user')->findOrFail($id);
        $logs = SubmissionLog::where('submission_type', 'KP')->where('submission_id', $id)->latest()->get();
        return view('admin.review_kp', [
            'kp' => $kp,
            'logs' => $logs
        ]);
    }

    public function updateStatusKp(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'status' => 'required|in:disetujui,revisi,terkumpul',
            'catatan_admin' => 'nullable|string'
        ]);

        $kp = KerjaPraktik::findOrFail($id);

        $kp->judul = $request->judul;
        $kp->status = $request->status;
        $kp->catatan_admin = $request->catatan_admin;
        $kp->save();

        $activity = 'Status Diubah';
        if ($request->status == 'disetujui'){
            $activity = 'Disetujui oleh Admin';
        } elseif ($request->status == 'revisi'){
            $activity = 'Meminta Revisi';
        }

        SubmissionLog::create([
            'submission_type' => 'KP',
            'submission_id' => $kp->id_kp,
            'user_id' => $kp->user_id,
            'actor' => 'Admin',
            'activity' => $activity,
            'notes' => $request->catatan_admin
        ]);


        $message = "";
        if ($request->status == 'disetujui'){
            $message = "Selamat! Kerja Praktik Anda dengan judul: '{$kp->judul}' telah disetujui";
        } elseif($request->status == 'revisi') {
            $message = "Kerja Praktik Anda dengan judul: '{$kp->judul}' perlu direvisi";
        }

        if ($message){
            Notification::create([
                'user_id' => $kp->user_id,
                'type' => 'kp',
                'submission_id' => $kp->id_kp,
                'message' => $message,
                'is_read' => false
            ]);
        }
        return redirect()->route('admin.kp.index')->with('success', 'Status data berhasil diperbarui');
    }

    public function destroyKp($id)
    {
        $kp = KerjaPraktik::findOrFail($id);

        Storage::disk('public')->delete($kp->abstrak_file);
        Storage::disk('public')->delete($kp->file_kp);

        SubmissionLog::where('submission_type', 'KP')->where('submission_id', $id)->delete();

        $kp->delete();
        return redirect()->route('admin.kp.index')->with('success', 'Data Kerja Praktik berhasil dihapus');
    }

    // TUGAS AKHIR
    public function indexTa(Request $request)
    {
        $search_nama = $request->input('search_nama');
        $search_judul = $request->input('search_judul');

        $query = TugasAkhir::with('user')->latest('created_at');

        $query->when($search_nama, function ($q, $search_nama) {
            return $q->whereHas('user', function ($subQ) use ($search_nama) {
                $subQ->where('nama', 'like', "%{$search_nama}%");
            });
        });

        $query->when($search_judul, function ($q, $search_judul) {
            return $q->where('judul', 'like', "%{$search_judul}%");
        });

        $data_ta = $query->paginate(10)->withQueryString();

        return view('admin.data_ta', [
            'data_ta' => $data_ta,
            'search_nama' => $search_nama,
            'search_judul' => $search_judul
        ]);
    }

    public function reviewTa($id)
    {
        $ta = TugasAkhir::with('user')->findOrFail($id);
        $logs = SubmissionLog::where('submission_type', 'TA')->where('submission_id', $id)->latest()->get();
        return view('admin.review_ta', [
            'ta' => $ta,
            'logs' => $logs
        ]);
    }

    public function updateStatusTa(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'status' => 'required|in:disetujui,revisi,terkumpul',
            'catatan_admin' => 'nullable|string',
        ]);

        $ta = TugasAkhir::findOrFail($id);

        $ta->judul = $request->judul;
        $ta->status = $request->status;
        $ta->catatan_admin = $request->catatan_admin;
        $ta->save();

        $activity = 'Status Diubah';
        if ($request->status == 'disetujui') {
            $activity = 'Disetujui oleh Admin';
        } elseif ($request->status == 'revisi') {
            $activity = 'Meminta Revisi';
        }
        
        SubmissionLog::create([
            'submission_type' => 'TA',
            'submission_id' => $ta->id_ta,
            'user_id' => $ta->user_id,
            'actor' => 'Admin',
            'activity' => $activity,
            'notes' => $request->catatan_admin
        ]);

        $message ="";
        if ($request->status == 'disetujui'){
            $message = "Selamat! Tugas Akhir Anda dengan judul: '{$ta->judul}' telah disetujui";
        } elseif ($request->status == 'revisi'){
            $message = "Tugas Akhir Anda dengan judul: '{$ta->judul}' perlu revisi";
        }

        if ($message) {
            Notification::create([
                'user_id' => $ta->user_id,
                'type' => 'ta',
                'submission_id' => $ta->id_ta,
                'message' => $message,
                'is_read' => false
            ]);
        }
        return redirect()->route('admin.ta.index')->with('success', 'Status data berhasil diperbarui');
    }

    public function destroyTa($id)
    {
        $ta = TugasAkhir::findOrFail($id);

        Storage::disk('public')->delete($ta->abstrak_file);
        Storage::disk('public')->delete($ta->file_ta);

        SubmissionLog::where('submission_type', 'TA')
                     ->where('submission_id', $id)
                     ->delete();
        
        $ta->delete();
        return redirect()->route('admin.ta.index')->with('success', 'Data Tugas Akhir berhasil dihapus');
    }


    public function getStudentDetails(Request $request)
    {
        $request->validate([
            'type' => 'required|in:kp,ta',
            'search' => 'nullable|string'
        ]);

        $type = $request->input('type');
        $search = $request->input('search');

        if($type == 'kp'){
            $baseQuery = KerjaPraktik::query()->with('user');
        } else {
            $baseQuery = TugasAkhir::query()->with('user');
        }

        if ($search){
            $baseQuery->whereHas('user', function ($subQ) use ($search){
                $subQ->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $thisSemesterQuery = clone $baseQuery;

        $now = now();
        $currentYear = $now->year;

        # SEMESTER ANTARA
        $antarStart = Carbon::create($currentYear, 1, 16)->startOfDay();
        $antarEnd = Carbon::create($currentYear, 4, 1)->endOfDay();

        # SEMESTER GENAP
        $genapStart= Carbon::create($currentYear, 4, 2)->startOfDay();
        $genapEnd= Carbon::create($currentYear, 8, 31)->endOfDay();

        # SEMESTER GASAL
        $gasalStart = Carbon::create($currentYear, 9, 1)->startOfDay();
        $gasalEnd = Carbon::create($currentYear + 1, 1, 15)->endOfDay();

        if ($now->between($antarStart, $antarEnd)){
            $semesterStartDate = $antarStart;
            $semesterEndDate = $antarEnd;
        }
        elseif($now->between($genapStart, $genapEnd)){
            $semesterStartDate = $genapStart;
            $semesterEndDate = $genapEnd;
        }
        elseif($now->between($gasalStart, $gasalEnd)){
            $semesterStartDate = $gasalStart;
            $semesterEndDate = $gasalEnd;
        }
        else{
            $semesterStartDate = Carbon::create($currentYear - 1, 9, 1)->startOfDay();
            $semesterEndDate = Carbon::create($currentYear, 1, 15)->endOfDay();
        }

        $thisSemesterData = $thisSemesterQuery->whereBetween('created_at', [$semesterStartDate, $semesterEndDate])->get();

        $allTimeData = $baseQuery->get();

        $studentThisSemester = $thisSemesterData->map(function ($submission){
            return [
                'nim' => $submission->user->nim,
                'nama' => $submission->user->nama,
                'status' => $submission->status
            ];
        });

        $studentAllTime = $allTimeData->map(function ($submission){
            return [
                'nim' => $submission->user->nim,
                'nama' => $submission->user->nama,
                'status' => $submission->status
            ];
        });

        return response()->json([
            'this_semester' => $studentThisSemester,
            'all_time' => $studentAllTime
        ]);
    }
}
