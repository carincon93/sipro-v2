<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallBudget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'call_id',
        'budget_programmatic_line_id'
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
     * Relationship with BudgetProgrammaticLine
     *
     * @return void
     */
    public function budgetProgrammaticLine()
    {
        return $this->belongsTo(BudgetProgrammaticLine::class);
    }

    /**
     * Relationship with ProjectSennovaBudget
     *
     * @return void
     */
    public function projectSennovaBudgets()
    {
        return $this->hasMany(ProjectSennovaBudget::class);
    }


    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterCallBudget($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('replace', 'ilike', '%'.$search.'%');
        });
    }
}
