<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reconciliation extends Model
{
    use HasFactory;

    protected $fillable = ['system_data_id', 'bcp_notification_id', 'ibk_notification_id'];

    public function systemData()
    {
        return $this->belongsTo(SystemData::class);
    }

    public function bcpNotification()
    {
        return $this->belongsTo(BcpNotification::class);
    }

    public function ibkNotification()
    {
        return $this->belongsTo(IbkNotification::class);
    }
}
