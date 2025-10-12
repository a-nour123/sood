<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupOldFiles extends Command
{
    protected $signature = 'cleanup:old-files';
    protected $description = 'Delete files older than 15 days from specified directories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $directories = [
            'exports/assets',
            'exports/vulns',
        ];

        foreach ($directories as $directory) {
            $files = Storage::allFiles($directory);
            $this->info("Checking directory: $directory");

            foreach ($files as $file) {
                $lastModified = Storage::lastModified($file);
                $lastModifiedDate = Carbon::createFromTimestamp($lastModified);
                $now = Carbon::now();

                if ($now->diffInDays($lastModifiedDate) > 15) {
                    Storage::delete($file);
                    $this->info("Deleted: $file");
                }
            }
        }
    }
}