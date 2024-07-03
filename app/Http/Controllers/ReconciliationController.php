<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BcpNotification;
use App\Models\IbkNotification;
use App\Models\Reconciliation;
use App\Models\SystemData;

use Inertia\Inertia;
use Inertia\Response;

class ReconciliationController extends Controller
{

    public function index(): Response
    {
        $reconciledTransactions = $this->reconcileTransactions();

        return Inertia::render('Notifications/Reconciliation', [
            'reconciledTransactions' => fn() => $reconciledTransactions,
        ]);
    }

    protected function reconcileTransactions()
    {
        $systemData = SystemData::all();
        $bcpNotifications = BcpNotification::all();
        $ibkNotifications = IbkNotification::all();

        $reconciledTransactions = [];

        foreach ($systemData as $systemEntry) {
            $reconciledEntry = [
                'system_data' => [
                    'name' => $systemEntry->last_name . ', ' . $systemEntry->first_name,
                    'operation_number' => $systemEntry->operation_number,
                    'bank' => $systemEntry->bank,
                    'amount' => $systemEntry->amount,
                    'payment_date' => $systemEntry->payment_date,
                    'status' => $systemEntry->status,
                    'account' => $systemEntry->account,
                    'created_at' => $systemEntry->created_at->diffForHumans(),
                ],
                'matched_bcp' => [],
                'matched_ibk' => [],
            ];

            $matchedBcp = $bcpNotifications->filter(function ($bcp) use ($systemEntry) {
                $fullName = $systemEntry->last_name . ' ' . $systemEntry->first_name;
                return $bcp->beneficiary === $fullName &&
                    $bcp->amount == $systemEntry->amount &&
                    $bcp->date_time->format('Y-m-d') === $systemEntry->payment_date->format('Y-m-d') &&
                    $bcp->account === $systemEntry->account;
            });

            if ($matchedBcp->isNotEmpty()) {
                $reconciledEntry['matched_bcp'] = $matchedBcp->all();
                foreach ($matchedBcp as $bcp) {
                    $bcp->status = true;
                    $bcp->save();
                }
                $systemEntry->validated = true;
                $systemEntry->save();
            }

            $matchedIbk = $ibkNotifications->filter(function ($ibk) use ($systemEntry) {
                $fullName = $systemEntry->last_name . ' ' . $systemEntry->first_name;
                return $ibk->beneficiary === $fullName &&
                    $ibk->amount == $systemEntry->amount &&
                    $ibk->date_time->format('Y-m-d') === $systemEntry->payment_date->format('Y-m-d') &&
                    $ibk->account === $systemEntry->account;
            });

            if ($matchedIbk->isNotEmpty()) {
                $reconciledEntry['matched_ibk'] = $matchedIbk->all();
                foreach ($matchedIbk as $ibk) {
                    $ibk->status = true;
                    $ibk->save();
                }
                $systemEntry->validated = true;
                $systemEntry->save();
            }

            if (!empty($reconciledEntry['matched_bcp']) || !empty($reconciledEntry['matched_ibk'])) {
                Reconciliation::create([
                    'system_data_id' => $systemEntry->id,
                    'bcp_notification_id' => $matchedBcp->isNotEmpty() ? $matchedBcp->first()->id : null,
                    'ibk_notification_id' => $matchedIbk->isNotEmpty() ? $matchedIbk->first()->id : null,
                ]);

                $reconciledTransactions[] = $reconciledEntry;
            }
        }

        return $reconciledTransactions;
    }

}
