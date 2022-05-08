<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Links
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Links newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Links newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Links query()
 * @mixin \Eloquent
 */
class Links extends Model
{
    protected $guarded = ['id'];
    
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        
        // return $this->belongsToMany(Product::class, LinkProducts::class, 'link_id', 'product_id');
        return $this->belongsToMany(Product::class, LinkProducts::class);
        // return $this->belongsToMany(Product::class, 'lik_products');
    }
}
