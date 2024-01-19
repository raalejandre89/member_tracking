<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'city',
        'state',
        'country',
        'team_id',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'team_name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * @return mixed
     */
    public function getTeamNameAttribute()
    {
        return $this->team->name;
    }
}
