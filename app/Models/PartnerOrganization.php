<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerOrganization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner_organization_type',
        'name',
        'legal_status',
        'company_type',
        'nit',
        'agreement_description',
        'research_group',
        'gruplac_code',
        'gruplac_link',
        'knowledge_transfer_activities',
        'letter_of_intent',
        'intellectual_property'
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
    public function rdi()
    {
        return $this->belongsTo(RDI::class);
    }

    /**
     * Relationship with Activity
     *
     * @return void
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_partner_organization', 'partner_organization_id', 'activity_id');
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterPartnerOrganization($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }

    /**
     * getPartnerOrganizationTypeAttribute
     *
     * @param  mixed $value
     * @return void
     */
    public function getPartnerOrganizationTypeAttribute($value)
    {
        switch ($value) {
            case 1:
                $value = 'Empresa';
                break;
            case 2:
                $value = 'Universidad';
                break;
            case 3:
                $value = 'Entidades sin ánimo de lucro';
                break;
            case 4:
                $value = 'Centro de formación SENA';
                break;
            case 5:
                $value = 'Otra';
                break;
            default:
                break;
        }
        return $value;
    }

    /**
     * getLegalStatusAttribute
     *
     * @param  mixed $value
     * @return void
     */
    public function getLegalStatusAttribute($value)
    {
        switch ($value) {
            case 1:
                $value = 'Pública';
                break;
            case 2:
                $value = 'Privado';
                break;
            case 3:
                $value = 'Mixta';
                break;
            case 4:
                $value = 'ONG';
                break;
            default:
                break;
        }
        return $value;
    }

    /**
     * getCompanyTypeAttribute
     *
     * @param  mixed $value
     * @return void
     */
    public function getCompanyTypeAttribute($value)
    {
        switch ($value) {
            case 1:
                $value = 'Microempresa';
                break;
            case 2:
                $value = 'Pequeña';
                break;
            case 3:
                $value = 'Mediana';
                break;
            case 4:
                $value = 'Grande';
                break;
            default:
                break;
        }
        return $value;
    }
}
