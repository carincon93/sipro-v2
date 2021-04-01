<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicCentre extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regional_id',
        'name',
        'code',
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
     * Relationship with Regional
     *
     * @return void
     */
    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    /**
     * Relationship with AcademicProgram
     *
     * @return void
     */
    public function academicPrograms()
    {
        return $this->hasMany(AcademicProgram::class);
    }

    /**
     * Relationship with ResearchGroup
     *
     * @return void
     */
    public function researchGroups()
    {
        return $this->hasMany(ResearchGroup::class);
    }

    /**
     * Relationship with User
     *
     * @return void
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterAcademicCentre($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
