<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    protected function showDemo()
    {
        return view('demo.index');
    }

    public function update(UpdateRequest $request)
    {
        $time = $request['time_reboot'];
        $cacheKey = '{' . \config('app.name') . '_' . 'report_total_day_' . "}." . $time;
        $isProccess = Cache::get($cacheKey);
        $isExist = Cache::has($cacheKey);
        if (!$isExist) {
            ReportTotalDayJob::dispatch($time, true);
            return ResponseUtils::successResponse(['status' => 'proccessing']);
        }
        if ($isProccess === 'proccessing') {
            return ResponseUtils::successResponse(['status' => 'proccessing']);
        }
        if ($isProccess === 'done') {
            Cache::forget($cacheKey);
            return $this->listing($request);
        }
    }
}
