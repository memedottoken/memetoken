<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poolstat extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'poolstats';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be cast to native types.
     *
     * @var string
     */
    protected function casts()
    {
        return [
            'timestamp' => 'datetime'
        ];
    }

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'launchpad_id',
        'token0_price',
        'token1_price',
        'tvl_usd',
        'volume_24h',
        'fee_tier',
        'transactions_24h',
        'total_transactions',
        'liquidity',
        'price_change_1h',
        'price_change_24h',
        'price_change_7d',
        'min_price_24h',
        'max_price_24h',
        'timestamp'
    ];


    /**

     * Get the launchpad this model Belongs To.
     *
     */
    public function launchpad(): BelongsTo
    {
        return $this->belongsTo(Launchpad::class, 'launchpad_id', 'id');
    }

    /**
     * Scope a query to only include latest stats per launchpad.
     */
    public function scopeLatest($query)
    {
        return $query->whereIn('id', function ($subquery) {
            $subquery->selectRaw('MAX(id)')
                ->from('pool_stats')
                ->groupBy('launchpad_id');
        });
    }

    /**
     * Scope a query to get stats within a time range.
     */
    public function scopeTimeBetween($query, $start, $end)
    {
        return $query->whereBetween('timestamp', [$start, $end]);
    }

    /**
     * Get formatted volume for display
     */
    public function getFormattedVolumeAttribute(): string
    {
        return '$' . number_format($this->volume_24h, 2);
    }

    /**
     * Get formatted TVL for display
     */
    public function getFormattedTvlAttribute(): string
    {
        return '$' . number_format($this->tvl_usd, 2);
    }

    /**
     * Get formatted price changes with + or - prefix
     */
    public function getFormattedPriceChange24hAttribute(): string
    {
        $prefix = $this->price_change_24h >= 0 ? '+' : '';
        return $prefix . number_format($this->price_change_24h, 2) . '%';
    }
}
