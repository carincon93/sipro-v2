<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RDI extends Model
{
    use HasFactory;

    protected $table = 'rdi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'call_id'
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
     * Relationship with Call
     *
     * @return void
     */
    public function call()
    {
        return $this->belongsTo(Call::class);
    }

    /**
     * Relationship with Project
     *
     * @return void
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'id');
    }

    /**
     * Relationship with PartnerOrganization
     *
     * @return void
     */
    public function partnerOrganizations()
    {
        return $this->hasMany(PartnerOrganization::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterRDI($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'ilike', '%'.$search.'%');
        });
    }
}
