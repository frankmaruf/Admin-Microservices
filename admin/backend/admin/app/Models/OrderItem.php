<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $name
 * @property int $quantity
 * @property string $revenue
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Order $order
 * @property-read \App\Models\Product|null $product_title
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product_title()
    {
        return $this->belongsTo(Product::class, 'name');
    }
}
