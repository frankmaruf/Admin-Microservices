<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Links
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Links newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Links newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Links query()
 * @mixin \Eloquent
 */
class Links extends Model 
{
    protected $guarded = [];
    
    use HasFactory;
    public function products()
    {
    
        return $this->belongsToMany(Product::class, LinkProducts::class);
    }
}
