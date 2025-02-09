<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Holder extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'holders';

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
    protected function casts() {
		 return [
			'prebond' => 'boolean'
		];
	}

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'launchpad_id',
		'user_id',
		'address',
		'qty',
		'prebond'
   ];

    
    /**

    * Get the launchpad this model Belongs To.
    *
    */
    public function launchpad():BelongsTo
	{
		return $this->belongsTo(Launchpad::class,'trade_id','id');
	}
	
    /**

    * Get the user this model Belongs To.
    *
    */
    public function user():BelongsTo
	{
		return $this->belongsTo(User::class,'user_id','id');
	}

}
