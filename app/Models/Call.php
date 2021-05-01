<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Call extends Model
{
    use HasFactory;

    public $appends = ['year', 'startDateForHumans', 'endDateForHumans'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'start_date',
        'end_date',
        'active',
        'project_start_date',
        'project_end_date',
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
     * Relationship with RDI
     *
     * @return void
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Relationship with CallBudget
     *
     * @return void
     */
    public function callBudgets()
    {
        return $this->hasMany(CallBudget::class);
    }

    /**
     * Relationship with CallSennovaRole
     *
     * @return void
     */
    public function callSennovaRoles()
    {
        return $this->hasMany(CallSennovaRole::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterCall($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('start_date', 'ilike', '%'.$search.'%');
        });
    }

    /**
     * getYearAttribute
     *
     * @return void
     */
    public function getYearAttribute()
    {
        return date('Y', strtotime($this->end_date));
    }

    /**
     * getStartDateForHumansAttribute
     *
     * @return void
     */
    public function getStartDateForHumansAttribute()
    {
        return Carbon::parse($this->start_date, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
    }

    /**
     * getEndDateForHumansAttribute
     *
     * @return void
     */
    public function getEndDateForHumansAttribute()
    {
        return Carbon::parse($this->end_date, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
    }
}
