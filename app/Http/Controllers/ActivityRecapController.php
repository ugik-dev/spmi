<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRecap;
use App\Models\Dipa;
use App\Supports\Disk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ActivityRecapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (empty(Auth::user()->employee->work_unit_id)) {
            return view('errors.405', ['pageTitle' => "Error", 'message' => "Unit Kerja anda belum diatur, harap hubungi admin!!"]);
        }
        $title = 'Rekap Kegiatan dan Upload Data Dukung';
        $timelines = [];
        // Load ActivityRecap data with each Activity
        $activities = Activity::with('activityRecap')->sortedByCode()->get();
        $dipas = Dipa::where('work_unit_id', Auth::user()->employee->work_unit_id)->get();
        $btnRekap = true;
        return view('app.budget-implementation-list', compact('title', 'timelines', 'dipas', 'btnRekap'));

        // return view('app.activity-recap', compact('title', 'activities'));
    }


    public function open(Dipa $dipa)
    {
        $title = 'Rekap Kegiatan dan Upload Data Dukung';
        // Load ActivityRecap data with each Activity
        $activities = Activity::with('activityRecap')->sortedByCode()->where('dipa_id', $dipa->id)->get();


        return view('app.activity-recap', compact('title', 'activities'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file_upload' => 'required|file|max:20480', // Max file size: 10 MB
                'activityId' => 'required|numeric', // Max file size: 10 MB
            ]);
            $activityID = $request->activityId;
            $activitiy = Activity::findOrFail($request->activityId);
            if (!in_array($activitiy->dipa->status, ['draft', 'reject-ppk', 'reject-spi', 'reject-ppk'])) {
                return response()->json(['error' => true,  'message' => 'Masa Upload Berkas sudah habis'], 400);
            }
            if ($activitiy->dipa->user_id != Auth::user()->id) {
                return response()->json(['error' => true,  'message' => 'Anda tidak memiliki izin untuk mengunggah file untuk tanda terima ini.'], 400);
            }
            if ($request->file('file_upload')->isValid()) {

                $activityRecap = ActivityRecap::firstOrNew(['activity_id' => $activityID]);

                $file = $request->file('file_upload');

                if ($file) {
                    $existingFiles = collect(Storage::disk(Disk::ActivityRecapAttachment)->files());

                    $existingFile = $existingFiles->first(function ($filename) use ($file) {
                        return basename($filename) == $file->getClientOriginalName() &&
                            Storage::disk(Disk::ActivityRecapAttachment)->size($filename) == $file->getSize();
                    });

                    if (!$existingFile) {
                        if ($activityRecap->attachment_path) {
                            Storage::disk(Disk::ActivityRecapAttachment)->delete($activityRecap->attachment_path);
                        }

                        $filePath = $file->store('/', Disk::ActivityRecapAttachment);
                        $activityRecap->attachment_path = $filePath;
                    }
                }

                $activityRecap->save();


                // $fileName = time() . '_' . $file->getClientOriginalName();
                // $file->storeAs('public/berkas_receipt/', $fileName);
                // $receipt->berkas = $fileName;
                // $receipt->save();
                // $log = new ReceiptLog;
                // $log->receipt_id = $receipt->id;
                // $log->user_id = $receipt->user_entry;
                // $log->activity = 'upload-berkas';
                // $log->description = 'Melakukan upload berkas';
                // $log->save();

                return response()->json(['error' => false], 200);
            }

            return response()->json(['error' => true,  'message' => 'File upload failed'], 400);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeOld(Request $request)
    {
        $activityIDs = $request->input('activityIDs', []);
        $descriptions = $request->input('descriptions', []);
        $files = $request->file('files', []);

        foreach ($activityIDs as $index => $activityID) {
            $description = $descriptions[$index] ?? '';
            $file = $files[$index] ?? null;

            $activityRecap = ActivityRecap::firstOrNew(['activity_id' => $activityID]);

            $activityRecap->description = $description;

            if ($file) {
                $existingFiles = collect(Storage::disk(Disk::ActivityRecapAttachment)->files());

                $existingFile = $existingFiles->first(function ($filename) use ($file) {
                    return basename($filename) == $file->getClientOriginalName() &&
                        Storage::disk(Disk::ActivityRecapAttachment)->size($filename) == $file->getSize();
                });

                if (!$existingFile) {
                    if ($activityRecap->attachment_path) {
                        Storage::disk(Disk::ActivityRecapAttachment)->delete($activityRecap->attachment_path);
                    }

                    $filePath = $file->store('/', Disk::ActivityRecapAttachment);
                    $activityRecap->attachment_path = $filePath;
                }
            }

            $activityRecap->save();
        }

        return response()->json(['message' => 'Activity recaps processed successfully.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityRecap $activityRecap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityRecap $activityRecap)
    {
        //
    }

    public function showFile(ActivityRecap $activityRecap)
    {
        // $this->authorize('view', $activityRecap); // Optional: check if user is authorized to view

        $path = $activityRecap->attachment_path;
        $filePath = Storage::disk(Disk::ActivityRecapAttachment)->path($path);
        $fileMimeType = mime_content_type($filePath);

        return Response::file($filePath, [
            'Content-Type' => $fileMimeType,
        ]);
    }

    // In your ActivityRecapController
    public function updateStatus(Request $request)
    {
        $activityId = $request->input('activity_id');
        $newStatus = $request->input('is_valid');

        $activityRecap = ActivityRecap::firstOrNew(['activity_id' => $activityId]);
        if ($activityRecap) {
            $activityRecap->is_valid = $newStatus;
            $activityRecap->save();

            return response()->json(['message' => 'Status berhasil diupdate']);
        }

        return response()->json(['message' => 'Activity Recap not found'], 404);
    }
}
