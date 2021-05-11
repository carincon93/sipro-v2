<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    use HasFactory;

    protected $table = 'regional';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'region_id',
        'regional_director_id'
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
     * Relationship with Region
     *
     * @return void
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Relationship with User
     *
     * @return void
     */
    public function regionalDirector()
    {
        return $this->belongsTo(User::class, 'regional_director_id');
    }

    /**
     * Relationship with AcademicCentre
     *
     * @return void
     */
    public function academicCentres()
    {
        return $this->hasMany(AcademicCentre::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterRegional($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }
}
