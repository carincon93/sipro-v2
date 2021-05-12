<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RDI extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'rdi';

    /**
     * appends
     *
     * @var array
     */
    protected $appends = ['execution_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_type_id',
        'research_line_id',
        'knowledge_subarea_discipline_id',
        'strategic_thematic_id',
        'knowledge_network_id',
        'economic_activity_id',
        'title',
        'start_date',
        'end_date',
        'video',
        'industry_4_justification',
        'orange_economy_justification',
        'people_disabilities_justification',
        'abstract',
        'project_background',
        'conceptual_framework',
        'project_methodology',
        'sustainability_proposal',
        'sampling',
        'sampling_activity',
        'sampling_objective',
        'bibliography',
        'students',
        'cities_impact',
        'academic_impact',
        'primary_objective',
        'problem_statement',
        'problem_justification',
        'related_with_technological_plan',
        'related_with_competitiveness_innovation',
        'related_with_sector_based_committee',
        'related_with_techno_academy'
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
        return $this->belongsTo(Project::class, 'id');
    }

    /**
     * Relationship with ResearchLine
     *
     * @return void
     */
    public function researchLine()
    {
        return $this->belongsTo(ResearchLine::class);
    }

    /**
     * Relationship with KnowledgeSubareaDiscipline
     *
     * @return void
     */
    public function knowledgeSubareaDiscipline()
    {
        return $this->belongsTo(KnowledgeSubareaDiscipline::class);
    }

    /**
     * Relationship with StrategicThematic
     *
     * @return void
     */
    public function strategicThematic()
    {
        return $this->belongsTo(StrategicThematic::class);
    }

    /**
     * Relationship with KnowledgeNetwork
     *
     * @return void
     */
    public function knowledgeNetwork()
    {
        return $this->belongsTo(KnowledgeNetwork::class);
    }

    /**
     * Relationship with EconomicActivity
     *
     * @return void
     */
    public function economicActivity()
    {
        return $this->belongsTo(EconomicActivity::class);
    }

    /**
     * Relationship with TechnologicalLine
     *
     * @return void
     */
    public function technologicalLines()
    {
        return $this->belongsToMany(TechnologicalLine::class, 'rdi_technological_lines', 'rdi_id', 'technological_line_id');
    }

    /**
     * Relationship with SectorBasedCommittee
     *
     * @return void
     */
    public function sectorBasedCommittees()
    {
        return $this->belongsToMany(SectorBasedCommittee::class, 'rdi_sector_based_committee', 'rdi_id', 'sector_based_committee_id');
    }

    /**
     * Relationship with TechnicalCommittee
     *
     * @return void
     */
    public function technicalCommittee()
    {
        return $this->belongsTo(TechnicalCommittee::class);
    }

    /**
     * Relationship with PartnerOrganization
     *
     * @return void
     */
    public function partnerOrganizations()
    {
        return $this->hasMany(PartnerOrganization::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterRDI($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'ilike', '%'.$search.'%');
        });
    }

    /**
     * getExecutionDateAttribute
     *
     * @return void
     */
    public function getExecutionDateAttribute()
    {
        $start_date = Carbon::parse($this->start_date, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        $end_date   = Carbon::parse($this->end_date, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        return "$start_date al $end_date";
    }
}
