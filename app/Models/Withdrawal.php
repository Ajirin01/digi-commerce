<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'amount', 'status', 'earnings_to_transfer'];

    public function seller() {
        return $this->belongsTo(Seller::class);
    }
}
