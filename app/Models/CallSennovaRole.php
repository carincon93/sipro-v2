<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallSennovaRole extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'call_id',
        'sennova_role_id',
        'salary'
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
     * Relationship with SennovaRole
     *
     * @return void
     */
    public function sennovaRole()
    {
        return $this->belongsTo(SennovaRole::class);
    }

    /**
     * Relationship with ProjectSennovaRole
     *
     * @return void
     */
    public function projects()
    {
        return $this->hasMany(ProjectSennovaRole::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterCallSennovaRole($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('salary', 'ilike', '%'.$search.'%');
        });
    }
}
