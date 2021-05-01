<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalCommittee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
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
     * Relationship with FirstRelatedModelcl
     *
     * @return void
     */
    public function firstRelatedModel()
    {
        return $this->belongsTo(FirstRelatedModel::class);
    }

    /**
     * Relationship with SecondRelatedModel
     *
     * @return void
     */
    public function secondRelatedModel()
    {
        return $this->hasOne(SecondRelatedModel::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterTechnicalCommittee($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
