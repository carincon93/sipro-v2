<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSennovaBudget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'call_budget_id',
        'description',
        'justification'
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
        return $this->callBudget->sennovaBudget->required_batch ? $this->hasMany(ProjectBudgetBatch::class) : $this->hasOne(ProjectBudgetBatch::class);
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
}
