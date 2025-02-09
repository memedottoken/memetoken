<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeCandle extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'launchpad_id',
        'timestamp',
        'timeframe',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'trades_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'timestamp' => 'datetime',
        'open' => 'decimal:18',
        'high' => 'decimal:18',
        'low' => 'decimal:18',
        'close' => 'decimal:18',
        'volume' => 'decimal:18',
        'trades_count' => 'integer',
    ];

    /**
     * Get the launchpad that owns the candle.
     */
    public function launchpad(): BelongsTo
    {
        return $this->belongsTo(Launchpad::class);
    }

    /**
     * The available timeframes for candles.
     *
     * @var array<string, int>
     */
    public static $timeframes = [
        '1m' => 60,
        '5m' => 300,
        '15m' => 900,
        '1h' => 3600,
        '4h' => 14400,
        '1d' => 86400,
    ];

    /**
     * Scope a query to only include candles of a specific timeframe.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $timeframe
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTimeframe($query, string $timeframe)
    {
        return $query->where('timeframe', $timeframe);
    }

    /**
     * Scope a query to only include candles within a time range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|DateTime  $from
     * @param  string|DateTime  $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTimeBetween($query, $from, $to)
    {
        return $query->whereBetween('timestamp', [$from, $to]);
    }

    /**
     * Get the price change percentage from open to close.
     *
     * @return float
     */
    public function getPriceChangePercentAttribute(): float
    {
        if ($this->open == 0) return 0;
        return (($this->close - $this->open) / $this->open) * 100;
    }

    /**
     * Get whether the candle is bullish (close > open).
     *
     * @return bool
     */
    public function getIsBullishAttribute(): bool
    {
        return $this->close > $this->open;
    }

    /**
     * Get whether the candle is bearish (close < open).
     *
     * @return bool
     */
    public function getIsBearishAttribute(): bool
    {
        return $this->close < $this->open;
    }

    /**
     * Get the candle body size (absolute difference between open and close).
     *
     * @return float
     */
    public function getBodySizeAttribute(): float
    {
        return abs($this->close - $this->open);
    }

    /**
     * Get the candle upper shadow size (difference between high and max of open/close).
     *
     * @return float
     */
    public function getUpperShadowAttribute(): float
    {
        return $this->high - max($this->open, $this->close);
    }

    /**
     * Get the candle lower shadow size (difference between min of open/close and low).
     *
     * @return float
     */
    public function getLowerShadowAttribute(): float
    {
        return min($this->open, $this->close) - $this->low;
    }
}
