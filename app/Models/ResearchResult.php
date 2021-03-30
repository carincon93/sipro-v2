<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'direct_effect_id',
        'specific_objective_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Relationship with SpecificObjective
     *
     * @return void
     */
    public function specificObjective()
    {
        return $this->belongsTo(SpecificObjective::class);
    }


    /**
     * Relationship with DirectEffect
     *
     * @return void
     */
    public function directEffect()
    {
        return $this->belongsTo(DirectEffect::class);
    }

    /**
     * Relationship with RDIOutput
     *
     * @return void
     */
    public function rdiOutputs()
    {
        return $this->hasMany(RDIOutput::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterResearchResult($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
