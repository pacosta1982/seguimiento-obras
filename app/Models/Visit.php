<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;

class Visit extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    protected $connection = 'pgsql';

    protected $fillable = [
        'project_id',
        'visit_number',
        'advance',
        'latitude',
        'longitude',
        'visit_date',

    ];


    protected $dates = [
        'visit_date',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            //->accepts('image/*')
            ->maxFilesize(2 * 2048 * 2048)
            ->maxNumberOfFiles(10);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        /*$this->addMediaConversion('detail_hd')
            ->width(1920)
            ->height(1080)
            ->performOnCollections('gallery');*/
        $this->autoRegisterThumb200();
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/visits/' . $this->getKey());
    }
}
