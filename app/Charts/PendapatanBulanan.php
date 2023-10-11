<?php

namespace App\Charts;

use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LineChart;

class PendapatanBulanan
{
    protected $chart;

    public function __construct(LineChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $chartType = request()->get('chartType', 'bar'); // Change the default chart type to 'bar'

        // Initialize the array with default values for all 12 months
        $dataTotalPendapatan = array_fill(0, 12, 0);

        for ($i = 1; $i <= 12; $i++) {
            $totalPendapatan = Order::where('payment_status', 2)
                ->whereYear('updated_at', $tahun)
                ->whereMonth('updated_at', $i)
                ->sum('grand_total');

            $dataTotalPendapatan[$i - 1] = $totalPendapatan;
        }

        // Create the chart based on the selected chart type
        switch ($chartType) {
            case 'line':
                $chart = $this->chart->lineChart();
                break;
            case 'area':
                $chart = $this->chart->areaChart();
                break;
            case 'bar':
            default:
                $chart = $this->chart->barChart();
                break; // Set the default chart type to 'bar'
        }

        $chart->setTitle('Revenue Data')
            ->setSubtitle('Revenue Data Per Month.')
            ->addData('Total Income', $dataTotalPendapatan)
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        return $chart;
    }
}