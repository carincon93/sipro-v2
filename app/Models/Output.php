<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    /**
     * appends
     *
     * @var array
     */
    protected $appends = ['start_year', 'start_month', 'start_day', 'end_year', 'end_month', 'end_day'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_result_id',
        'name',
        'start_date',
        'end_date'
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
     * Relationship with ProjectResult
     *
     * @return void
     */
    public function projectResult()
    {
        return $this->belongsTo(ProjectResult::class);
    }

    /**
     * Relationship with RDIOutput
     *
     * @return void
     */
    public function rdiOutput()
    {
        return $this->hasOne(RDIOutput::class);
    }

        /**
     * Relationship with Activity
     *
     * @return void
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_output', 'output_id', 'activity_id');
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterOutput($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'ilike', '%'.$search.'%');
        });
    }

    public function getStartYearAttribute()
    {
        return date('Y', strtotime($this->start_date));
    }

    public function getStartMonthAttribute()
    {
        return date('m', strtotime($this->start_date));
    }

    public function getStartDayAttribute()
    {
        return date('d', strtotime($this->start_date));
    }

    public function getEndYearAttribute()
    {
        return date('Y', strtotime($this->end_date));
    }

    public function getEndMonthAttribute()
    {
        return date('m', strtotime($this->end_date));
    }

    public function getEndDayAttribute()
    {
        return date('d', strtotime($this->end_date));
    }
}
