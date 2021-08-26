<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/*use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;*/

class Project extends Model /*implements HasMedia*/
{
    /*use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;*/

    protected $table = 'SEGOBRA';
    protected $primaryKey = 'SEOBId';
    public $timestamps = false;
    protected $connection = 'sqlsrv';
    public $incrementing = false;

    protected $fillable = [
        'SEOBEmpr',
        'SEOBProy',
        'SEOBAvanc',
        //'visit_date',

    ];


    protected $dates = [
        //'visit_date',
        //'created_at',
        //'updated_at',

    ];

    protected $appends = ['resource_url', 'is_admin'];
    protected $with = ['visits', 'advance', 'departamento', 'distrito'];

    public function visits()
    {
        return $this->hasMany(Visit::class, 'project_id')->orderBy('id');
    }

    public function advance()
    {
        return $this->hasOne(Visit::class, 'project_id')->latest('id');
    }

    public function distrito()
    {
        return $this->hasOne(Distrito::class, 'CiuId', 'CiuId');
    }

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'DptoId', 'DptoId');
    }



    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/projects/' . $this->getKey());
    }

    public function getIsAdminAttribute()
    {
        return url('projects/' . $this->getKey());
    }
}
