<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReductionPersonnel extends Model
{
    protected $table = 'reductions_personnel';

    protected $primaryKey = 'reduction_id';

    public $incrementing = false;

    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reduction_id',
        'date_application',
    ];

    /**
     * Get personnel reduction casts.
     *
     * @return array<string, string> Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'date_application' => 'datetime',
        ];
    }

    /**
     * Get the parent reduction.
     *
     * @return BelongsTo<Reduction, ReductionPersonnel> Reduction relation.
     */
    public function reduction(): BelongsTo
    {
        return $this->belongsTo(Reduction::class);
    }
}
