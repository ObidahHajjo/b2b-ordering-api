<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReductionGlobale extends Model
{
    protected $table = 'reductions_globale';

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
        'date_debut',
        'date_fin',
        'code',
    ];

    /**
     * Get global reduction casts.
     *
     * @return array<string, string> Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'date_debut' => 'datetime',
            'date_fin' => 'datetime',
        ];
    }

    /**
     * Get the parent reduction.
     *
     * @return BelongsTo<Reduction, ReductionGlobale> Reduction relation.
     */
    public function reduction(): BelongsTo
    {
        return $this->belongsTo(Reduction::class);
    }
}
