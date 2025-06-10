<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StorageCleanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $public_paths = [
            'imgs',
            'projects',
        ];
        
        foreach($public_paths as $path) {
            Storage::disk('public')->deleteDirectory($path);
        }
    }
}
