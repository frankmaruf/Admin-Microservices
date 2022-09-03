<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LinkProducts
 *
 * @property int $id
 * @property int $links_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts query()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts whereLinksId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkProducts whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LinkProducts extends Model
{
    protected $guarded = [''];
    use HasFactory;
}
