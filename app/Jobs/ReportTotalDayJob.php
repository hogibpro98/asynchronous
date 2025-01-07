<?php

namespace App\Jobs;

use App\Repositories\ReportTotal\ReportTotalDayRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ReportTotalDayJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $date;
    private $reportTotalDayRepository;
    private $isApiCall;

    /**
     * Create a new job instance.
     *
     * @param $date
     */
    public function __construct($date, $isApiCall = null)
    {
        $this->date = $date;
        $this->reportTotalDayRepository = new ReportTotalDayRepository();
        $this->isApiCall = $isApiCall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $conditon = $this->isApiCall;
            $time = $this->date;
            if ($conditon) {
                $cacheKey = '{' . \config('app.name') . '_' . 'report_total_day_' . "}." . $time;
                Cache::put($cacheKey,'proccessing', Config::get('permission.cache_ttl'));
                $isSuccess = $this->reportTotalDayRepository->store($this->date, $this->isApiCall);
                if ($isSuccess) {
                    Cache::put($cacheKey,'done', Config::get('permission.cache_ttl'));
                }
                if (!$isSuccess) {
                    Log::error('report total day : datas from table mms_days, mms_days is empty on '
                        . $this->date);
                }
            } else {
                $isSuccess = $this->reportTotalDayRepository->store($this->date, $this->isApiCall);
                if (!$isSuccess) {
                    Log::error('report total day : datas from table mms_days, mms_days is empty on '
                        . $this->date);
                }
            }

        } catch (\Exception $exception){
            Log::error($exception);
        }
    }
}
