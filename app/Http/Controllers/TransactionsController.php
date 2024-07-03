<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

// Models
use App\Models\BcpNotification;
use App\Models\IbkNotification;
use App\Models\SystemData;

class TransactionsController extends Controller
{
    public function system(): Response
    {
        $defaultStartDate = Carbon::now()->startOfMonth()->toDateString();
        $defaultEndDate = Carbon::now()->endOfMonth()->toDateString();
        
        $only = Request::only(['search', 'validated', 'start_date', 'end_date', 'amount', 'amount_operator']);
        $filters = array_merge([
            'start_date' => $defaultStartDate,
            'end_date' => $defaultEndDate,
        ], Request::all(['search', 'validated', 'start_date', 'end_date', 'amount', 'amount_operator']));


        $systemData = SystemData::orderByDate()
            ->filter($only)
            ->paginate(10)
            ->withQueryString()
            ->through(fn($data) => [
                'id' => $data->id,
                'name' => $data->last_name . ' ' . $data->first_name,
                'operation_number' => $data->operation_number,
                'bank' => $data->bank,
                'account_number' => $data->account_number,
                'amount' => $data->amount,
                'payment_date' => $data->payment_date,
                'status' => $data->status,
                'validated' => $data->validated,
                'created_at' => $data->created_at->diffForHumans(),
            ]);
        return Inertia::render('Notifications/System', [
            'filters' => $filters,
            'systemData' => fn() => $systemData,
        ]);
    }


    public function bcp(): Response
    {
        $defaultStartDate = Carbon::now()->startOfMonth()->toDateString();
        $defaultEndDate = Carbon::now()->endOfMonth()->toDateString();
        
        $only = Request::only(['search', 'status', 'start_date', 'end_date', 'amount', 'amount_operator']);
        $filters = array_merge([
            'start_date' => $defaultStartDate,
            'end_date' => $defaultEndDate,
        ], Request::all(['search', 'status', 'start_date', 'end_date', 'amount', 'amount_operator']));

        $bcp = BcpNotification::orderByDate()
            ->filter($only)
            ->paginate(10)
            ->withQueryString()
            ->through(fn($data) => [
                'id' => $data->id,
                'beneficiary' => $data->beneficiary,
                'operation_number' => $data->operation_number,
                'account_destination' => $data->account_destination,
                'amount' => $data->amount,
                'date_time' => $data->date_time->format('d/m/Y H:i'),
                'status' => $data->status,
                'created_at' => $data->created_at->diffForHumans(),
            ]);

        return Inertia::render('Notifications/Bcp', [
            'filters' => $filters,
            'bcp' => fn() => $bcp,
        ]);
    }


    public function ibk(): Response
    {
        $defaultStartDate = Carbon::now()->startOfMonth()->toDateString();
        $defaultEndDate = Carbon::now()->endOfMonth()->toDateString();

        $only = Request::only(['search', 'status', 'start_date', 'end_date', 'amount', 'amount_operator']);
         $filters = array_merge([
            'start_date' => $defaultStartDate,
            'end_date' => $defaultEndDate,
        ], Request::all(['search', 'status', 'start_date', 'end_date', 'amount', 'amount_operator']));

        $ibk = IbkNotification::orderByDate()
            ->filter($only)
            ->paginate(10)
            ->withQueryString()
            ->through(fn($data) => [
                'id' => $data->id,
                'beneficiary' => $data->beneficiary,
                'number_application' => $data->number_application,
                'account_destination' => $data->account_destination,
                'amount' => $data->amount,
                'date_time' => $data->date_time->format('d/m/Y H:i'),
                'status' => $data->status,
                'created_at' => $data->created_at->diffForHumans(),
            ]);

        return Inertia::render('Notifications/Ibk', [
            'filters' => $filters,
            'ibk' => fn() => $ibk,
        ]);
    }

}
