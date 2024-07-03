<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IbkNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'ordering_company',
        'beneficiary',
        'account_charge',
        'account_destination',
        'payment_status',
        'number_application',
        'amount',
        'date_time',
        'observations',
        'status'
    ];

    protected $casts = [
        'amount' => 'float',
        'date_time' => 'datetime',
        'status' => 'boolean'
    ];

    public function reconciliations()
    {
        return $this->hasMany(Reconciliation::class);
    }

    public static function topDepositors()
    {
        return self::select('beneficiary', 
            DB::raw('SUM(amount) as total_amount'))
                ->groupBy('beneficiary')
                ->orderByDesc('total_amount')
                ->limit(10)
                ->get();
    }

    // Total de transacciones por fecha con sus montos
    public static function transactionsByDate()
    {
        return self::select(
            DB::raw('DATE(date_time) as date'),
            DB::raw('COUNT(*) as total_transactions'),
            DB::raw('SUM(amount) as total_amount')
        )
            ->groupBy(DB::raw('DATE(date_time)'))
            ->orderBy('date')
            ->get();
    }

    public function scopeOrderByDate($query)
    {
        $query->orderBy('date_time', 'desc');
    }


    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('beneficiary', 'like', '%' . $search . '%');
            });
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })->when($filters['start_date'] ?? null, function ($query, $startDate) use ($filters) {
            if (!empty($filters['end_date'])) {
                $query->whereBetween('date_time', [$startDate, $filters['end_date']]);
            } else {
                $query->whereDate('date_time', $startDate);
            }
        })->when($filters['amount'] ?? null, function ($query, $amount) use ($filters) {
            if (!empty($filters['amount_operator'])) {
                switch ($filters['amount_operator']) {
                    case 'equal':
                        $query->where('amount', $amount);
                        break;
                    case 'greater':
                        $query->where('amount', '>', $amount);
                        break;
                    case 'less':
                        $query->where('amount', '<', $amount);
                        break;
                }
            }
        });
    }
}
