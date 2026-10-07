<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KerjaPraktik;
use App\Models\Notification;
use App\Models\SubmissionLog;
use App\Models\TugasAkhir;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\Clock\now;

class UserController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        $cekStatusTA = TugasAkhir::where('user_id', $user->user_id)
                                  ->where('status', 'disetujui')
                                  ->exists(); 

        $cekStatusKP = KerjaPraktik::where('user_id', $user->user_id)
                                    ->where('status', 'disetujui')
                                    ->exists();
        return view('user.home', [
            'user'=>$user,
            'cekStatusTA' => $cekStatusTA,
            'cekStatusKP' => $cekStatusKP
        ]);
    }


    // INI UNTUK TUGAS AKHIR
    public function createTa()
    {
        $cekStatusTA = TugasAkhir::where('user_id', Auth::id())->where('status', 'disetujui')->exists();

        if ($cekStatusTA){
            return redirect()->route('user.home')->with('error', 'Tugas Akhir Anda sudah disetujui');
        }

        $ta = new TugasAkhir();
        return view('user.form_ta', ['ta' => $ta]);
    }

    public function storeTa(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_ta' => 'required|string|max:100',
            'abstrak_file' => 'required|file|extensions:pdf,doc,docx|max:2048',
            'kata_kunci' => 'required|string|max:255',
            'latar_belakang' => 'required|string',
            'pembimbing' => 'required|string|max:255',
            'file_ta' => 'required|file|extensions:pdf,doc,docx|max:10240',
        ]);

        # DOWNLOAD FILE ABSTRAK TA DI GUEST
        $fileAbstrak = $request->file('abstrak_file');
        $realFileAbstrak = str_replace(' ', '_', $fileAbstrak->getClientOriginalName());
        $uniqueFileAbstrak = time().'_'.$realFileAbstrak; 
        $abstrak_path = $fileAbstrak->storeAs('abstrak_ta', $uniqueFileAbstrak, 'public');

        # FULL FILE TA
        $ta_path = $request->file('file_ta')->store('tugas_akhir', 'public');

        $newTa = TugasAkhir::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'jenis_ta' => $request->jenis_ta,
            'abstrak_file' => $abstrak_path,
            'kata_kunci' => $request->kata_kunci,
            'latar_belakang' => $request->latar_belakang,
            'pembimbing' => $request->pembimbing,
            'file_ta' => $ta_path,
            'status' => 'terkumpul'
        ]);

        SubmissionLog::create([
            'submission_type' => 'TA',
            'submission_id' => $newTa->id_ta,
            'user_id' => Auth::id(),
            'actor'=> Auth::user()->nama,
            'activity'=> 'Mengumpulkan Tugas Akhir'
        ]);

        return redirect()->route('user.home')->with('success', 'File Tugas Akhir berhasil dikumpulkan');
    }

    // HISTORY TA
    public function historyTa()
    {
        Notification::where('user_id', Auth::id())->where('type', 'ta')->where('is_read', false)->update(['is_read' => true]);

        $data_ta = TugasAkhir::where('user_id', Auth::id())->latest()->get();
        $data_logs = SubmissionLog::where('user_id', Auth::id())->where('submission_type', 'TA')->latest('created_at')->get();
        return view('user.history_ta', [
            'data_ta' => $data_ta,
            'data_logs' => $data_logs
        ]);
    }

    public function editTa($id)
    {
        $ta = TugasAkhir::findOrFail($id);
        if ($ta->user_id != Auth::id()){
            abort(403, 'Akses ditolak');
        }
        if ($ta->status == 'disetujui'){
            return redirect()->route('user.history.ta')->with('error', 'Data tidak bisa diedit');
        }
        return view('user.form_ta', ['ta' => $ta]);
    }

    public function updateTa(Request $request, $id)
    {
        $ta = TugasAkhir::findOrFail($id);
        if ($ta->user_id != Auth::id() || $ta->status == 'disetujui'){
            abort(403, 'Akses DItolak');
        }

        $request->validate([
            'judul'=> 'required|string|max:255',
            'jenis_ta'=> 'required|string|max:100',
            'abstrak_file'=> 'nullable|file|extensions:pdf,doc,docx|max:2048',
            'kata_kunci'=> 'required|string|max:255',
            'latar_belakang'=> 'required|string|',
            'pembimbing'=> 'required|string',
            'file_ta'=> 'nullable|file|extensions:pdf,doc,docx|max:10240'
        ]);

        $ta->update([
            'judul'=> $request->judul,
            'jenis_ta'=> $request->jenis_ta,
            'kata_kunci'=> $request->kata_kunci,
            'latar_belakang'=> $request->latar_belakang,
            'pembimbing'=> $request->pembimbing
        ]);

        if($request->hasFile('abstrak_file')){
            Storage::disk('public')->delete($ta->abstrak_file);
            $fileAbstrak = $request->file('abstrak_file');
            $realFileAbstrak = str_replace(' ', '_', $fileAbstrak->getClientOriginalName());
            $uniqueFileAbstrak = time().$realFileAbstrak; 
            $ta->abstrak_file = $fileAbstrak->storeAs('abstrak_ta', $uniqueFileAbstrak, 'public');
        }

        if($request->hasFile('file_ta')){
            Storage::disk('public')->delete($ta->file_ta);
            $fileTA = $request->file('file_ta');
            $realFile = str_replace(' ', '_', $fileTA->getClientOriginalName());
            $uniqueFileTA = time().$realFile;
            $ta->file_ta = $fileTA->storeAs('tugas_akhir', $uniqueFileTA, 'public');
        }
        $ta->save();

        SubmissionLog::create([
            'submission_type' => 'TA',
            'submission_id' => $ta->id_ta, 
            'user_id' => Auth::id(),
            'actor' => Auth::user()->nama,
            'activity' => 'Mengedit Data',
            'notes' => 'Melakukan Edit Data Pada: "' . $ta->judul . '"'
        ]);
        return redirect()->route('user.history.ta')->with('success', 'Data Tugas Akhir berhasil diperbarui');
    }

    public function revisiTa($id)
    {
        $ta = TugasAkhir::findOrFail($id);
        if($ta->user_id != Auth::id() || $ta->status != 'revisi'){
            return redirect()->route('user.history.ta')->with('error', 'Data ini tidak sedang dalam status revisi.');
        }
        return view('user.form_revisi_ta', ['ta' => $ta]);
    }

    public function updateRevisiTa(Request $request, $id)
    {
        $ta = TugasAkhir::findOrFail($id);
        if ($ta->user_id != Auth::id() || $ta->status != 'revisi'){
            abort(403, 'Akses DItolak');
        }

        $request->validate([
            'judul'=> 'required|string|max:255',
            'jenis_ta'=> 'required|string|max:100',
            'abstrak_file'=> 'nullable|file|extensions:pdf,doc,docx|max:2048',
            'kata_kunci'=> 'required|string|max:255',
            'latar_belakang'=> 'required|string|',
            'pembimbing'=> 'required|string',
            'file_ta'=> 'nullable|file|extensions:pdf,doc,docx|max:10240'
        ]);

        $ta->update([
            'judul'=> $request->judul,
            'jenis_ta'=> $request->jenis_ta,
            'kata_kunci'=> $request->kata_kunci,
            'latar_belakang'=> $request->latar_belakang,
            'pembimbing'=> $request->pembimbing
        ]);

        if($request->hasFile('abstrak_file')){
            Storage::disk('public')->delete($ta->abstrak_file);
            $fileAbstrak = $request->file('abstrak_file');
            $realFileAbstrak = str_replace(' ', '_', $fileAbstrak->getClientOriginalName());
            $uniqueFileAbstrak = time().'_'.$realFileAbstrak; 
            $ta->abstrak_file = $fileAbstrak->storeAs('abstrak_ta', $uniqueFileAbstrak, 'public');
        }

        if($request->hasFile('file_ta')){
            Storage::disk('public')->delete($ta->file_ta);
            $fileTA = $request->file('file_ta');
            $realFile = str_replace(' ', '_', $fileTA->getClientOriginalName());
            $uniqueFileTA = time().'_'.$realFile;
            $ta->file_ta = $fileTA->storeAs('tugas_akhir', $uniqueFileTA, 'public');
        }

        $ta->status = 'terkumpul';
        $ta->catatan_admin = null;
        $ta->save();

        $countRevisi = SubmissionLog::where('submission_type', 'TA')
                                        ->where('submission_id', $ta->id_ta)
                                        ->where('activity', 'like', 'Mengirimkan Revisi%')
                                        ->count();
        
        $newActivityName = 'Mengirimkan Revisi ' . ($countRevisi + 1);
        
        SubmissionLog::create([
            'submission_type' => 'TA',
            'submission_id'=>$ta->id_ta,
            'user_id'=>Auth::id(),
            'actor'=>Auth::user()->nama,
            'activity'=> $newActivityName,
            'notes' => 'Perbaikan telah dikirimkan'

        ]);
        return redirect()->route('user.history.ta')->with('success', 'Data Tugas Akhir berhasil diperbarui');
    }


    // HAPUS TA
    public function destroyTa($id)
    {
        $ta = TugasAkhir::findOrFail($id);
        if($ta->user_id != Auth::id() || $ta->status !='terkumpul'){
            return redirect()->route('user.history.ta')->with('error', 'File tidak bisa dihapus');
        }

        Storage::disk('public')->delete($ta->abstrak_file);
        Storage::disk('public')->delete($ta->file_ta);

        $ta->delete();
        SubmissionLog::create([
            'submission_type' => 'TA',
            'submission_id' => $ta->id_ta, 
            'user_id' => Auth::id(),
            'actor' => Auth::user()->nama,
            'activity' => 'Menghapus Data',
            'notes' => 'Menghapus Data Dengan Judul: "' . $ta->judul . '"'
        ]);
        return redirect()->route('user.history.ta')->with('success', 'Data berhasil dihapus');
    }





    // INI UNTUK KERJA PRAKTIK
    public function createKp()
    {
        $cekStatusKP = KerjaPraktik::where('user_id', Auth::id())->where('status', 'disetujui')->exists();
        if($cekStatusKP){
            return redirect()->route('user.home')->with('error', 'Kerja Praktik Anda sudah disetujui');
        }

        $kp = new KerjaPraktik();
        return view('user.form_kp', ['kp' => $kp]);
    }

    public function storeKp(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'abstrak_file' => 'required|file|extensions:pdf,doc,docx|max:2048', 
            'kata_kunci' => 'required|string|max:255',
            'latar_belakang' => 'required|string',
            'pembimbing' => 'required|string|max:255', 
            'file_kp' => 'required|file|extensions:pdf,doc,docx|max:10240', 
        ]);

        # DOWNLOAD FILE KP ABSTRAK DIGUEST
        $fileAbstrak = $request->file('abstrak_file');
        $realFileAbstrak = str_replace(' ', '_', $fileAbstrak->getClientOriginalName());
        $uniqueFileAbstrak = time().'_'.$realFileAbstrak; 
        $abstrak_path = $fileAbstrak->storeAs('abstrak_kp', $uniqueFileAbstrak, 'public');

        # FULL FILE KP
        $kp_path = $request->file('file_kp')->store('kerja_praktik', 'public');

        $newKp = KerjaPraktik::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'tgl_kumpul' => now(),
            'abstrak_file' => $abstrak_path,
            'kata_kunci' => $request->kata_kunci,
            'latar_belakang' => $request->latar_belakang,
            'pembimbing' => $request->pembimbing,
            'file_kp' => $kp_path,
            'status' => 'terkumpul'
        ]);

        SubmissionLog::create([
            'submission_type' => 'KP',
            'submission_id' => $newKp->id_kp,
            'user_id' => Auth::id(),
            'actor' => Auth::user()->nama,
            'activity' => 'Mengumpulkan Kerja Praktik'
        ]);

        return redirect()->route('user.home')->with('success', 'File Kerja Praktik berhasil dikumpulkan');
    }



    // HISTORY KP
    public function historyKp()
    {
        Notification::where('user_id', Auth::id())->where('type', 'kp')->where('is_read', false)->update(['is_read' => true]);

        $data_kp = KerjaPraktik::where('user_id', Auth::id())->latest('tgl_kumpul')->get();
        $data_logs = SubmissionLog::where('user_id', Auth::id())->where('submission_type', 'KP')->latest('created_at')->get();
        return view('user.history_kp', [
            'data_kp' => $data_kp,
            'data_logs' => $data_logs
        ]);
    }

    public function editKp($id)
    {
        $kp = KerjaPraktik::findOrFail($id);
        if ($kp->user_id != Auth::id()){
            abort(403, 'Akses Ditolak');
        }
        if ($kp->status == 'disetujui'){
            return redirect()->route('user.history.kp')->with('error', 'Data tidak bisa diedit');
        }
        return view('user.form_kp', ['kp' => $kp]);
    }

    public function updateKp(Request $request, $id)
    {
        $kp = KerjaPraktik::findOrFail($id);
        if($kp->user_id != Auth::id() || $kp->status=='disetujui'){
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'judul'=>'required|string|max:255',
            'tgl_mulai'=>'required|date',
            'tgl_selesai'=>'required|date|after_or_equal:tgl_mulai',
            'tgl_kumpul'=>'required|date',
            'pembimbing'=>'required|string|max:255',
            'abstrak_file'=>'nullable|file|extensions:pdf,doc,docx|max:2048',
            'kata_kunci'=>'required|string|max:100',
            'latar_belakang'=>'required|string',
            'file_kp'=>'nullable|file|extensions:pdf,doc,docx|max:10240'
        ]);

        $kp->update([
            'judul'=> $request->judul,
            'tgl_mulai'=> $request->tgl_mulai,
            'tgl_selesai'=> $request->tgl_selesai,
            'tgl_kumpul'=> $request->tgl_kumpul,
            'pembimbing'=> $request->pembimbing,
            'kata_kunci'=> $request->kata_kunci,
            'latar_belakang'=> $request->latar_belakang,
        ]);

        if($request->hasFile('abstrak_file')){
            Storage::disk('public')->delete($kp->abstrak_file);
            $fileAbstrak = $request->file('abstrak_file');
            $realFileAbstrak = str_replace(' ', '_', $fileAbstrak->getClientOriginalName());
            $uniqueFileAbstrak = time().'_'.$realFileAbstrak; 
            $kp->abstrak_file = $fileAbstrak->storeAs('abstrak_kp', $uniqueFileAbstrak, 'public');
        }

        if($request->hasFile('file_kp')){
            Storage::disk('public')->delete($kp->file_kp);
            $fileKP = $request->file('file_kp');
            $realFile = str_replace(' ', '_', $fileKP->getClientOriginalName());
            $uniqueFileKP = time().'_'.$realFile; 
            $kp->abstrak_file = $fileAbstrak->storeAs('kerja_praktik', $uniqueFileKP, 'public');
        }
        $kp->save();

        SubmissionLog::create([
            'submission_type' => 'KP',
            'submission_id' => $kp->id_kp,
            'user_id' => Auth::id(),
            'actor' => Auth::user()->nama,
            'activity' => 'Mengedit Data',
            'notes' => 'Melakukan Edit Pada: "' . $kp->judul . '"'
        ]);

        return redirect()->route('user.history.kp')->with('success', 'Data Kerja Praktik berhasil diperbarui');
    }


    public function revisiKp($id)
    {
        $kp = KerjaPraktik::findOrFail($id);
        if($kp->user_id != Auth::id() || $kp->status != 'revisi'){
            return redirect()->route('user.history.kp')->with('error', 'Data ini tidak sedang dalam status revisi.');
        }
        return view('user.form_revisi_kp', ['kp' => $kp]);
    }

    public function updateRevisiKp(Request $request, $id)
    {
        $kp = KerjaPraktik::findOrFail($id);
        if ($kp->user_id != Auth::id() || $kp->status != 'revisi'){
            abort(403, 'Akses DItolak');
        }

        $request->validate([
            'judul'=>'required|string|max:255',
            'tgl_mulai'=>'date',
            'tgl_selesai'=>'date|after_or_equal:tgl_mulai',
            'abstrak_file'=>'nullable|file|extensions:pdf,doc,docx|max:2048',
            'kata_kunci'=>'required|string|max:100',
            'latar_belakang'=>'required|string',
            'file_kp'=>'nullable|file|extensions:pdf,doc,docx|max:10240'
        ]);

        $kp->update([
            'judul'=> $request->judul,
            'tgl_mulai'=> $request->tgl_mulai,
            'tgl_selesai'=> $request->tgl_selesai,
            'kata_kunci'=> $request->kata_kunci,
            'latar_belakang'=> $request->latar_belakang,
        ]);

        if($request->hasFile('abstrak_file')){
            Storage::disk('public')->delete($kp->abstrak_file);
            $fileAbstrak = $request->file('abstrak_file');
            $realFileAbstrak = str_replace(' ', '_', $fileAbstrak->getClientOriginalName());
            $uniqueFileAbstrak = time().'_'.$realFileAbstrak; 
            $kp->abstrak_file = $fileAbstrak->storeAs('abstrak_kp', $uniqueFileAbstrak, 'public');
        }

        if($request->hasFile('file_kp')){
            Storage::disk('public')->delete($kp->abstrak_file);
            $fileKP = $request->file('file_kp');
            $realFile = str_replace(' ', '_', $fileKP->getClientOriginalName());
            $uniqueFileKP = time().'_'.$realFile; 
            $kp->abstrak_file = $fileAbstrak->storeAs('kerja_praktik', $uniqueFileKP, 'public');
        }
        // $kp->tgl_kumpul = now();
        $kp->status = 'terkumpul';
        $kp->catatan_admin = null;
        $kp->save();

        $countRevisi = SubmissionLog::where('submission_type', 'KP')
                                        ->where('submission_id', $kp->id_kp)
                                        ->where('activity', 'like', 'Mengirimkan Revisi%')
                                        ->count();
        $newActivityName = 'Mengirimkan Revisi ' . ($countRevisi + 1);
        SubmissionLog::create([
            'submission_type' => 'KP',
            'submission_id'=>$kp->id_kp,
            'user_id'=>Auth::id(),
            'actor'=>Auth::user()->nama,
            'activity'=> $newActivityName,
            'notes' => 'Perbaikan telah dikirimkan'

        ]);
        return redirect()->route('user.history.kp')->with('success', 'Data Tugas Akhir berhasil diperbarui');
    }

    // HAPUS KP
    public function destroyKp($id)
    {
        $kp = KerjaPraktik::findOrFail($id);
        if($kp->user_id != Auth::id() || $kp->status !='terkumpul'){
            return redirect()->route('user.history.ta')->with('error', 'File tidak bisa dihapus');
        }

        Storage::disk('public')->delete($kp->abstrak_file);
        Storage::disk('public')->delete($kp->file_kp);

        $kp->delete();
        SubmissionLog::create([
            'submission_type' => 'KP',
            'submission_id' => $kp->id_kp,
            'user_id' => Auth::id(),
            'actor' => Auth::user()->nama,
            'activity' => 'Menghapus Data',
            'notes' => 'Menghapus Data Dengan Judul: "' . $kp->judul . '"'
        ]);
        return redirect()->route('user.history.kp')->with('success', 'Data berhasil dihapus');
    }


    public function notifications()
    {
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)->latest()->get();

        Notification::where('user_id', $userId)->where('is_read', false)->update(['is_read' => true]);

        return view('user.notifications', ['notifications' => $notifications]);
    }


}
