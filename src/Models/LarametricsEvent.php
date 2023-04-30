<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Models;

use Aschmelyun\Larametrics\Collections\LarametricsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LarametricsEvent extends Model
{
    protected $guarded = [];

    protected $table = 'larametrics';

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @param  array<LarametricsEvent>  $models
     */
    public function newCollection(array $models = [])
    {
        return new LarametricsCollection($models);
    }

    public function user(): BelongsTo|Model|null
    {
        return $this->belongsTo(config('larametrics.user_model'));
    }
}
