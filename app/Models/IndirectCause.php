<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndirectCause extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cause_direct_id'
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
     * Relationship with CauseDirect
     *
     * @return void
     */
    public function causeDirect()
    {
        return $this->belongsTo(CauseDirect::class);
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
    public function scopeFilterIndirectCause($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('description', 'ilike', '%'.$search.'%');
        });
    }
}
