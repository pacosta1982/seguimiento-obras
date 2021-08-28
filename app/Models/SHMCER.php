<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SHMCER extends Model
{
    //
    protected $table = 'SHMCER';

    protected $connection = 'sqlsrv';

    protected $primaryKey = 'CerNro';

    public $incrementing = false;

    public function distrito()
    {
        return $this->hasOne('App\Models\Distrito', 'CiuId', 'CerCiuId');
    }

    public function departamento()
    {
        return $this->hasOne('App\Models\Departamento', 'DptoId', 'CerDptoId');
    }
}
