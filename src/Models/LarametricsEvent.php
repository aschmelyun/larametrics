<?php declare(strict_types=1);

namespace Aschmelyun\Larametrics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LarametricsEvent extends Model
{
    protected $guarded = [];

    protected $table = 'larametrics';

    protected $casts = [
        'data' => 'array',
    ];

    public function user(): BelongsTo|Model|null
    {
        return $this->belongsTo(config('larametrics.user_model'));
    }
}
