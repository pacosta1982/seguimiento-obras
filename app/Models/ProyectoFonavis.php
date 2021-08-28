<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoFonavis extends Model
{
    protected $table = 'SEGPROY';

    protected $primaryKey = 'SegPtoNro';

    protected $connection = 'sqlsrv';

    public $incrementing = false;
    //protected $with = ['postulantes'];

    /*public function postulantes()
    {
        //return $this->hasMany(Subsidio::class, 'project_id');
        //return $this->hasMany('Trip', ['id', 'route_name', 'source_file'], ['route_id', 'route_name', 'source_file']);
        //return $this->hasMany(Subsidio::class, ['CerNucCod', 'SPNucCod'], ['GerNuCod', 'SPGNuCod']);
        return $this
            ->hasMany(Subsidio::class, 'CerNucCod', 'SPNucCod')
            ->hasMany(Subsidio::class, 'GerNuCod', 'SPGNuCod');
    }*/
}
