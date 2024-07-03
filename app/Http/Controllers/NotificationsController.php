<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

// Models
use App\Models\BcpNotification;
use App\Models\IbkNotification;

class NotificationsController extends Controller
{


    public function index(): Response
    {
        $bcpTopDepositors = BcpNotification::topDepositors();
        $ibkTopDepositors = IbkNotification::topDepositors();
        $bcpTransactionsByDate = BcpNotification::transactionsByDate();
        $ibkTransactionsByDate = IbkNotification::transactionsByDate();

        return Inertia::render('Notifications/Index', [
            'bcp' => [
                'topDepositors' => $bcpTopDepositors,
                'transactionsByDate' => $bcpTransactionsByDate,
            ],
            'ibk' => [
                'topDepositors' => $ibkTopDepositors,
                'transactionsByDate' => $ibkTransactionsByDate,
            ]
        ]);
    }
}
