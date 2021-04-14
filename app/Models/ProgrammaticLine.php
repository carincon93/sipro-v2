<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammaticLine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'code',
        'project_category'
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
     * Relationship with ProjectType
     *
     * @return void
     */
    public function projectTypes()
    {
        return $this->hasMany(ProjectType::class);
    }

    /**
     * Relationship with BudgetProgrammaticLine
     *
     * @return void
     */
    public function budgetProgrammaticLines()
    {
        return $this->hasMany(BudgetProgrammaticLine::class);
    }

    /**
     * Relationship with SennovaRole
     *
     * @return void
     */
    public function sennovaRoles()
    {
        return $this->hasMany(SennovaRole::class);
    }

    /**
     * Relationship with Annexe
     *
     * @return void
     */
    public function annexes()
    {
        return $this->belongsToMany(Annexe::class, 'annexe_programmatic_line', 'programmatic_line_id', 'annexe_id');
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterProgrammaticLine($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
