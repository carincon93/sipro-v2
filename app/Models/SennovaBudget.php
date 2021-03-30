<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SennovaBudget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_budget_info_id',
        'second_budget_info_id',
        'third_budget_info_id'
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
     * Relationship with FirstBudgeInfo
     *
     * @return void
     */
    public function firstBudgeInfo()
    {
        return $this->belongsTo(FirstBudgeInfo::class);
    }

    /**
     * Relationship with SecondBudgetInfo
     *
     * @return void
     */
    public function secondBudgetInfo()
    {
        return $this->belongsTo(SecondBudgetInfo::class);
    }

    /**
     * Relationship with ThirdBudgetInfo
     *
     * @return void
     */
    public function thirdBudgetInfo()
    {
        return $this->belongsTo(ThirdBudgetInfo::class);
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
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterSennovaBudget($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('replace', 'ilike', '%'.$search.'%');
        });
    }
}
