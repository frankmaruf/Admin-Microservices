<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $country
 * @property string $postal_code
 * @property string $payment_method
 * @property string $payment_status
 * @property string $payment_id
 * @property string $payment_amount
 * @property string $payment_currency
 * @property string $payment_description
 * @property string $payment_status_detail
 * @property string $payment_created_at
 * @property string $payment_updated_at
 * @property string $payment_transaction_id
 * @property string $payment_transaction_type
 * @property string $payment_transaction_status
 * @property string $payment_transaction_amount
 * @property string $payment_transaction_currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatusDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentTransactionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentTransactionCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $name
 * @property-read mixed $total_amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @property string $code
 * @property int $user_id
 * @property string $influencer_email
 * @property int $completed
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInfluencerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInfluencerId($value)
 * @property int $user_id
 * @property string $link
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @property-read mixed $admin_total
 * @property-read mixed $influencer_total
 */
class Order extends Model
{
    use HasFactory;
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function getAdminTotalAttribute(){
        return $this->orderItems->sum(function($item){
            return $item->admin_revenue;
        });
    }
    public function getInfluencerTotalAttribute(){
        usleep(30000);
        return $this->orderItems->sum(function($item){
            return $item->influencer_revenue;
        });
    }
    public function getNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
}
