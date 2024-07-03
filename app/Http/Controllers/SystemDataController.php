<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataLoadImport;
use Illuminate\Http\Request;
use App\Models\SystemData;
use Carbon\Carbon;
use Throwable;
use DB;

class SystemDataController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        try {
            Excel::import(new DataLoadImport, $request->file('file'));
            return redirect()->back()->with('success', 'File uploaded and processed successfully.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Error during file upload. ' . $e->getMessage());
        }
    }

    public function transactionsPerDay()
    {
        // Obtén las últimas 5 fechas únicas en las que se realizaron transacciones
        $lastFiveDays = SystemData::select(DB::raw('DATE(payment_date) as date'))
            ->distinct()
            ->orderBy('date', 'desc')
            ->limit(5)
            ->pluck('date');

        $transactions = SystemData::select(
            DB::raw('DATE(payment_date) as date'),
            'bank',
            'validated',
            DB::raw('count(*) as count')
        )
            ->whereIn(DB::raw('DATE(payment_date)'), $lastFiveDays)
            ->groupBy('date', 'bank', 'validated')
            ->get()
            ->groupBy('date')
            ->map(function ($items, $key) {
                $totalTransactions = $items->sum('count');
                $banks = $items->groupBy('bank')->map(function ($items) {
                    return $items->sum('count');
                });

                $validated = $items->where('validated', 1)->sum('count');
                $notValidated = $items->where('validated', 0)->sum('count');
                $formattedDate = Carbon::parse($key)->isoFormat('MMMM Do YYYY');

                return [
                    'payment_date' => $formattedDate,
                    'total' => $totalTransactions,
                    'banks' => $banks,
                    'validated' => $validated,
                    'not_validated' => $notValidated,
                ];
            });

        return response()->json($transactions);
    }

}
