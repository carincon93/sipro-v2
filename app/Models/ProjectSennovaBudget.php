<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSennovaBudget extends Model
{
    use HasFactory;

    protected $appends = ['average', 'totalByBudgetWithoutMarketResearch'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'call_budget_id',
        'description',
        'justification',
        'value',
        'qty_items'
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
     * Relationship with Project
     *
     * @return void
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relationship with CallBudget
     *
     * @return void
     */
    public function callBudget()
    {
        return $this->belongsTo(CallBudget::class);
    }

    /**
     * Relationship with ProjectBudgetBatch
     *
     * @return void
     */
    public function projectBudgetBatches()
    {
        return $this->hasMany(ProjectBudgetBatch::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterProjectSennovaBudget($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query
                ->join('call_budgets', 'project_sennova_budgets.call_budget_id', 'call_budgets.id')
                ->join('budgets_programmatic_lines', 'call_budgets.budget_programmatic_line_id', 'budgets_programmatic_lines.id')
                ->join('sennova_budgets', 'budgets_programmatic_lines.sennova_budget_id', 'sennova_budgets.id')
                ->join('first_budget_info', 'sennova_budgets.first_budget_info_id', 'first_budget_info.id')
                ->join('second_budget_info', 'sennova_budgets.second_budget_info_id', 'second_budget_info.id')
                ->join('third_budget_info', 'sennova_budgets.third_budget_info_id', 'third_budget_info.id')
                ->where('first_budget_info.name', 'ilike', '%'.$search.'%')
                ->orWhere('second_budget_info.name', 'ilike', '%'.$search.'%')
                ->orWhere('third_budget_info.name', 'ilike', '%'.$search.'%');
        });
    }

    /**
     * getDescriptionAttribute
     *
     * @param  mixed $value
     * @return void
     */
    public function getDescriptionAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * getAverageAttribute
     *
     * @return void
     */
    public function getAverageAttribute()
    {
        $average    = 0;

        if (is_iterable($this->projectBudgetBatches)) {
            foreach ($this->projectBudgetBatches as $projectBudgetBatch) {
                $average += $projectBudgetBatch->getAverageAttribute();
            }
        } else {
            $average += $this->projectBudgetBatches->getAverageAttribute();
        }
        return $average;
    }

    /**
     * getTotalByBudgetWithoutMarketResearchAttribute
     *
     * @return void
     */
    public function getTotalByBudgetWithoutMarketResearchAttribute()
    {
        $total = 0;

        $this->value > 0 && $this->callBudget->sennovaBudget->can_be_added ?
            $total = ($this->qty_items * $this->value)
            : $total = 0;

        return $total;
    }
}
