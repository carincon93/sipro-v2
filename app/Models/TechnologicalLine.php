<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnologicalLine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'techno_academy_id',
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
     * Relationship with TechnoAcademy
     *
     * @return void
     */
    public function technoAcademy()
    {
        return $this->belongsTo(TechnoAcademy::class);
    }

    /**
     * Relationship with RDI
     *
     * @return void
     */
    public function rdi()
    {
        return $this->belongsToMany(RDI::class, 'rdi_technological_lines', 'technological_line_id', 'rdi_id');
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterTechnologicalLine($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
