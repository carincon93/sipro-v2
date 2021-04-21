<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annexe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'programmatic_line_id',
        'name',
        'description'
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
     * Relationship with ProgrammaticLine
     *
     * @return void
     */
    public function programmaticLines()
    {
        return $this->belongsToMany(ProgrammaticLine::class, 'annexe_programmatic_line', 'annexe_id', 'programmatic_line_id');
    }

    /**
     * Relationship with ProjectAnnexe
     *
     * @return void
     */
    public function projectAnnexes()
    {
        return $this->hasMany(ProjectAnnexe::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterAnnexe($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
