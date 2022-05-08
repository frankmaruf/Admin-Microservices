<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\LinkProducts
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts query()
 * @mixin \Eloquent
 */
class LinkProducts extends Model
{
    protected $guarded = ['id'];
    // protected $fillable = ['link_id', 'product_id'];
    use HasFactory;
}
