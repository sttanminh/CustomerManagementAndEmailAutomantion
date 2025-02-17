<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id', 'products', 'total', 'status', 'schedule_interval', 'start_day', 'time', 'date_of_month'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity') // ✅ Ensure quantity is included
                    ->withTimestamps();
    }


}
