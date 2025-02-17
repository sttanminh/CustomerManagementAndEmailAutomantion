<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EmailLog extends Model
{
    use HasFactory; // ✅ Ensure SoftDeletes is used

    protected $fillable = [
        'order_id',
        'timestamp',
        'recipient',
        'attachment',
        'email_content',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
