<?php

namespace App\Models;

use App\Enums\SettingRpc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

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
            'rpc' => SettingRpc::class,
            'chat' => 'boolean',
            'featured' => 'boolean'
        ];
    }

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo',
        'name',
        'twitter',
        'youtube',
        'telegram_group',
        'telegram_channel',
        'discord',
        'documentation',
        'rpc',
        'ankr',
        'infura',
        'blast',
        'chat',
        'featured'
    ];

    /**
     * Get the uploads this model Owns.
     *
     */
    public function uploads(): MorphMany
    {
        return $this->morphMany(Upload::class, 'uploadable',);
    }
}
