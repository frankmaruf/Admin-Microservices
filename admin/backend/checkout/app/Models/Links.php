<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Links
 *
 * @property int $id
 * @property string $link
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Links newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Links newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Links query()
 * @method static \Illuminate\Database\Eloquent\Builder|Links whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Links whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Links whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Links whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Links whereUserId($value)
 * @mixin \Eloquent
 */
class Links extends Model 
{
    protected $guarded = [''];
    
    use HasFactory;
    public function products()
    {
    
        return $this->belongsToMany(Product::class, LinkProducts::class);
    }
}
