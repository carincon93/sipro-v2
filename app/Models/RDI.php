<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'ciiu_code_id',
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
        'states',
        'states_impact'
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
     * Relationship with CIIUCode
     *
     * @return void
     */
    public function ciiuCode()
    {
        return $this->belongsTo(CIIUCode::class);
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
}
