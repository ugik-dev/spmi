<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Supports\Disk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        //
    }

    public function showFile(Receipt $receipt)
    {
        // $this->authorize('view', $activityRecap); // Optional: check if user is authorized to view

        $path = $receipt->berkas;
        $filePath = Storage::disk(Disk::BerkasAttachment)->path($path);
        $fileMimeType = mime_content_type($filePath);

        return Response::file($filePath, [
            'Content-Type' => $fileMimeType,
        ]);
    }
}
