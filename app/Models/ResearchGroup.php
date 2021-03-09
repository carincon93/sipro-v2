<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'academic_centre_id',
        'name',
        'acronym',
        'email',
        'enlace_gruplac',
        'minciencias_code',
        'minciencias_category',
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
     * Relationship with AcademicCentre
     *
     * @return void
     */
    public function academicCentre()
    {
        return $this->belongsTo(AcademicCentre::class);
    }

    /**
     * Relationship with ResearchLine
     *
     * @return void
     */
    public function researchLines()
    {
        return $this->hasMany(ResearchLine::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterResearchGroup($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
