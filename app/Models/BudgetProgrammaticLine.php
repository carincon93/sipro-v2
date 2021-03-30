<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetProgrammaticLine extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'budgets_programmatic_lines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'programmatic_line_id',
        'sennova_budget_id'
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
    public function programmaticLine()
    {
        return $this->belongsTo(ProgrammaticLine::class);
    }

    /**
     * Relationship with SennovaBudget
     *
     * @return void
     */
    public function sennovaBudget()
    {
        return $this->belongsTo(SennovaBudget::class);
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
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterBudgetProgrammaticLine($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('replace', 'ilike', '%'.$search.'%');
        });
    }
}
