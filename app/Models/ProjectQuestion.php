<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectQuestion extends Model
{
    protected $table = 'project_question';

    protected $fillable = [
        'questionnaire_id',
        'project_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/project-questions/'.$this->getKey());
    }
}
