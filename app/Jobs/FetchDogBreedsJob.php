<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchDogBreedsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Nếu cần truyền tham số, khai báo tại đây
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // Gọi API
            $response = Http::get('https://dogapi.dog/api/v2/breeds');

            // Kiểm tra phản hồi
            if ($response->successful()) {
                return $response->json();
            } else {
                // Ghi log nếu gọi API không thành công
                \Log::error('Failed to fetch dog breeds: ' . $response->status());
            }
        } catch (\Exception $e) {
            // Bắt lỗi và ghi log
            \Log::error('Error in FetchDogBreedsJob: ' . $e->getMessage());
        }
    }
}
