<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemData extends Model
{
    use HasFactory;

    protected $table = 'system_data';

    protected $fillable = [
        'cod_transaction',
        'request_date',
        'payment_date',
        'user',
        'cash_station',
        'first_name',
        'last_name',
        'bank',
        'account_number',
        'cci',
        'payment_bank',
        'amount',
        'commission',
        'operation_number',
        'status',
        'rejection_reason',
        'payer',
        'reason',
        'receipt',
        'type',
        'approved_by',
        'validated',
        'observations',
    ];

    protected $dates = [
        'request_date',
        'payment_date',
    ];

    public function reconciliations()
    {
        return $this->hasMany(Reconciliation::class);
    }

    public function scopeOrderByDate($query)
    {
        $query->orderBy('payment_date', 'desc');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('bank', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        })->when($filters['validated'] ?? null, function ($query, $validated) {
            $query->where('validated', $validated);
        })->when($filters['start_date'] ?? null, function ($query, $startDate) use ($filters) {
            if (!empty($filters['end_date'])) {
                $query->whereBetween('payment_date', [$startDate, $filters['end_date']]);
            } else {
                $query->whereDate('payment_date', $startDate);
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
