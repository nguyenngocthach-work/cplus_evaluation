<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadClientLogoJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clientId;
    protected $tmpPath;

    public function __construct($clientId, $tmpPath)
    {
        $this->clientId = $clientId;
        $this->tmpPath = $tmpPath;
    }

    public function handle()
    {
        try{
            if (!Storage::disk('public')->exists($this->tmpPath)) {
                return;
            }

            $client = Client::find($this->clientId);
            if (!$client) {
                return;
            }

            // create new path
            $ext = pathinfo($this->tmpPath, PATHINFO_EXTENSION);
            $filename = 'logo_' . Str::uuid() . '.' . $ext;
            $dir = 'clients/' . $this->clientId;
            $finalPath = $dir . '/' . $filename;

            Storage::disk('public')->makeDirectory($dir);
            Storage::disk('public')->move($this->tmpPath, $finalPath);

            $client->update([
                'logo_img' => $finalPath
            ]);
        } catch(\Exception $e){
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
        }
    }
}
