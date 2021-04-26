<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $appends = ['code', 'totalProjectBudget'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_type_id',
        'is_finished'
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
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    /**
     * Relationship with RDI
     *
     * @return void
     */
    public function rdi()
    {
        return $this->hasOne(RDI::class, 'id');
    }

    /**
     * Relationship with DirectCause
     *
     * @return void
     */
    public function directCauses()
    {
        return $this->hasMany(DirectCause::class);
    }

    /**
     * Relationship with DirectEffect
     *
     * @return void
     */
    public function directEffects()
    {
        return $this->hasMany(DirectEffect::class);
    }

    /**
     * Relationship with ProjectSennovaRole
     *
     * @return void
     */
    public function sennovaRoles()
    {
        return $this->hasMany(ProjectSennovaRole::class);
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
     * Relationship with ProjectAnnexe
     *
     * @return void
     */
    public function projectAnnexes()
    {
        return $this->hasMany(ProjectAnnexe::class);
    }

    /**
     * Relationship with RiskAnalysis
     *
     * @return void
     */
    public function riskAnalysis()
    {
        return $this->hasMany(RiskAnalysis::class);
    }

    /**
     * Relationship with Project (participants)
     *
     * @return void
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'project_participants', 'project_id', 'user_id')
            ->withPivot([
                'user_id',
                'is_author',
                'qty_months',
                'qty_hours'
            ]);
    }

    /**
     * Get code e.g. SGPS-8000-2021
     *
     * @return void
     */
    public function getCodeAttribute()
    {
        return 'SGPS-' . ($this->id + 8000) .'-' . date('Y', strtotime($this->rdi->end_date));
    }

    public function getTotalProjectBudgetAttribute()
    {
        $total = 0;

        foreach($this->projectSennovaBudgets as $projectSennovaBudget) {
            if ($projectSennovaBudget->callBudget->sennovaBudget->can_be_added) {
                $total += $projectSennovaBudget->getTotalByBudgetWithoutMarketResearchAttribute() + $projectSennovaBudget->getAverageAttribute();
            }
        }

        return $total;
    }
}
