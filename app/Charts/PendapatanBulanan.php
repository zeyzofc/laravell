<?php

namespace App\Charts;

use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class PendapatanBulanan
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $tahun = date('Y');
        $bulan = date('m');

        // Initialize the array with default values for all 12 months
        $dataTotalPendapatan = array_fill(0, 12, 0);

        for ($i = 1; $i <= 12; $i++) {
            $totalPendapatan = Order::where('payment_status', 2)
                ->whereYear('updated_at', $tahun)
                ->whereMonth('updated_at', $i)
                ->sum('grand_total');

            $dataTotalPendapatan[$i - 1] = $totalPendapatan;
        }

        return $this->chart->lineChart()
            ->setTitle('Revenue Data')
            ->setSubtitle('Revenue Data Per Month.')
            ->addData('Total Income', $dataTotalPendapatan)
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
    }
}