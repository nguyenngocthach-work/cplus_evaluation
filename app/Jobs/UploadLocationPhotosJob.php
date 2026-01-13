<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PhotosLocation;

class UploadLocationPhotosJob 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $industryId;
    protected array $photoPaths;
    /**
     * Create a new job instance.
     */
    public function __construct($industryId, $photoPaths)
    {
        //
        $this->industryId = $industryId;
        $this->photoPaths = $photoPaths;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        try{
            foreach ($this->photoPaths as $tmpPath) {

                $extension = pathinfo($tmpPath, PATHINFO_EXTENSION);

                $filename = 'industry_' .
                    $this->industryId . '_' .
                    Str::uuid() . '.' . $extension;

                $finalPath = 'locations/' . $this->industryId . '/' . $filename;

                // Move file
                Storage::disk('public')->move($tmpPath, $finalPath);

                PhotosLocation::create([
                    'industry_id' => $this->industryId,
                    'img_url' => $finalPath,
                ]);
            }
        } catch (\Exception $e){
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
        }
    }

    public function failed(\Throwable $e)
    {
        Log::error('UploadLocationPhotosJob failed', [
            'industry_id' => $this->industryId,
            'error' => $e->getMessage(),
        ]);
        foreach ($this->photoPaths as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}