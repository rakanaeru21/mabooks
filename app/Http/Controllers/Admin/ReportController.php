<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->buildReportData($request);

        return view('admin.reports.index', $data);
    }

    public function download(Request $request)
    {
        $data = $this->buildReportData($request);

        $fileLabel = strtolower(str_replace([' ', '/', '\\', ':'], '-', $data['rangeLabel']));
        $pdf = Pdf::loadView('admin.reports.pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->download("laporan-{$fileLabel}.pdf");
    }

    private function buildReportData(Request $request): array
    {
        $now = Carbon::now();
        $mode = $request->input('mode');
        $month = (int) $request->input('month', $now->month);
        $year = (int) $request->input('year', $now->year);
        $startInput = $request->input('start_date');
        $endInput = $request->input('end_date');

        if ($month < 1 || $month > 12) {
            $month = $now->month;
        }

        $query = Order::with('user', 'items');
        $periodStart = null;
        $periodEnd = null;
        $rangeLabel = '';

        if ($mode === 'range' || $startInput || $endInput) {
            $periodStart = $startInput ? Carbon::parse($startInput)->startOfDay() : null;
            $periodEnd = $endInput ? Carbon::parse($endInput)->endOfDay() : null;

            if ($periodStart && $periodEnd && $periodStart->greaterThan($periodEnd)) {
                [$periodStart, $periodEnd] = [$periodEnd, $periodStart];
                [$startInput, $endInput] = [$endInput, $startInput];
            }

            if ($periodStart && $periodEnd) {
                $query->whereBetween('created_at', [$periodStart, $periodEnd]);
                $rangeLabel = $periodStart->format('d M Y') . ' - ' . $periodEnd->format('d M Y');
            } elseif ($periodStart) {
                $query->where('created_at', '>=', $periodStart);
                $rangeLabel = 'Mulai ' . $periodStart->format('d M Y');
            } elseif ($periodEnd) {
                $query->where('created_at', '<=', $periodEnd);
                $rangeLabel = 'Sampai ' . $periodEnd->format('d M Y');
            } else {
                $rangeLabel = $now->format('F Y');
            }
        } else {
            $periodStart = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $periodEnd = $periodStart->copy()->endOfMonth();
            $query->whereBetween('created_at', [$periodStart, $periodEnd]);
            $rangeLabel = $periodStart->format('F Y');
        }

        $orders = $query->latest()->get();
        $totalOrders = $orders->count();
        $totalItems = $orders->sum(function ($order) {
            return $order->items->sum('jumlah');
        });
        $totalRevenue = $orders->sum('total_harga');

        $filters = [
            'mode' => $mode,
            'month' => $month,
            'year' => $year,
            'start_date' => $startInput,
            'end_date' => $endInput,
        ];

        $downloadQuery = array_filter($filters, fn ($value) => $value !== null && $value !== '');

        return [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'totalItems' => $totalItems,
            'totalRevenue' => $totalRevenue,
            'rangeLabel' => $rangeLabel,
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
            'filters' => $filters,
            'downloadQuery' => $downloadQuery,
        ];
    }
}
