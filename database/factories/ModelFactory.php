<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SEGOBRA::class, static function (Faker\Generator $faker) {
    return [
        'SEOBId' => $faker->randomNumber(5),
        'SEOBEmpr' => $faker->sentence,
        'SEOBViv' => $faker->randomNumber(5),
        'SEOBNCont' => $faker->sentence,
        'SEOBProgr' => $faker->sentence,
        'SEOBProy' => $faker->sentence,
        'SEOBFisc' => $faker->sentence,
        'SEOBSuper' => $faker->sentence,
        'SEOBFecCo' => $faker->dateTime,
        'SEOBFecAn' => $faker->dateTime,
        'SEOBMonCo' => $faker->randomNumber(5),
        'SEOBMonAn' => $faker->randomNumber(5),
        'SEOBAvanc' => $faker->sentence,
        'SEOBPlaEO' => $faker->dateTime,
        'SEOBVigeC' => $faker->sentence,
        'SEOBVigeS' => $faker->dateTime,
        'SEOBConCod' => $faker->randomNumber(5),
        'SEOBEst' => $faker->sentence,
        'SEOBAEjer' => $faker->sentence,
        'SEOBObj' => $faker->sentence,
        'SEOBObm' => $faker->randomNumber(5),
        'SEOBSein' => $faker->dateTime,
        'SEOBSefi' => $faker->sentence,
        'SEOBDetS' => $faker->randomNumber(5),
        'SEOBLote' => $faker->sentence,
        'SEOBActI' => $faker->dateTime,
        'SEOBRePr' => $faker->dateTime,
        'SEOBReDe' => $faker->dateTime,
        'SEOBUtm1' => $faker->sentence,
        'SEOBUtmX' => $faker->sentence,
        'SEOBUtmY' => $faker->sentence,
        'SEOBConstr' => $faker->sentence,
        'SEOBResNom' => $faker->sentence,
        'SEOBResTel' => $faker->sentence,
        'SEOBResCel' => $faker->sentence,
        'SEOBFisTel' => $faker->sentence,
        'SEOBFisCel' => $faker->sentence,
        'SEOBMonPro' => $faker->randomNumber(5),
        'SEOBApoBen' => $faker->randomNumber(5),
        'SEOBDevRep' => $faker->randomNumber(5),
        'SEOBNivel' => $faker->sentence,
        'DptoId' => $faker->sentence,
        'CiuId' => $faker->sentence,
        'SEOBCodSAT' => $faker->sentence,
        'SEOBFF' => $faker->sentence,
        'SEOBOF' => $faker->sentence,
        'SEOBFisAva' => $faker->randomNumber(5),
        'SEOBFisFec' => $faker->dateTime,
        'SEOBSupAva' => $faker->randomNumber(5),
        'SEOBSupFec' => $faker->dateTime,
        'SEOBSeVCum' => $faker->dateTime,
        'SEOBSeVAnt' => $faker->dateTime,
        'SEOBSeVAcc' => $faker->dateTime,
        'SEOBSeVTer' => $faker->dateTime,
        'SEOBSeVRie' => $faker->dateTime,
        'SEOBAdePEO' => $faker->dateTime,
        'SEOBAdPEOV' => $faker->dateTime,
        'SEOBLocal' => $faker->sentence,
        'SEOBAdmin' => $faker->sentence,
        'SEOBPlan' => $faker->sentence,
        'SEOBJefCel' => $faker->sentence,
        'SEOBJefTel' => $faker->sentence,
        'SEOBJefObr' => $faker->sentence,
        'SEOBSupCel' => $faker->sentence,
        'SEOBSupTel' => $faker->sentence,
        'SEOBPtoNro' => $faker->randomNumber(5),
        'SEOBSeV2De' => $faker->dateTime,
        'SEOBSeVTerr' => $faker->dateTime,
        'SEOBIdDNCP' => $faker->randomNumber(5),
        'SEOBCtaCte' => $faker->sentence,
        'SEOBPadron' => $faker->sentence,
        'SEOBFinca' => $faker->sentence,
        'SEOBVivEnt' => $faker->randomNumber(5),
        'SEOBRDef' => $faker->sentence,
        'SEOBRProv' => $faker->sentence,
        'SEOBAcIn' => $faker->sentence,
        'SEOBAnt' => $faker->sentence,
        'SEOBCont' => $faker->sentence,
        'SEOBVivInR' => $faker->randomNumber(5),
        'SEOBVivEje' => $faker->randomNumber(5),
        'SEOBVivCul' => $faker->randomNumber(5),
        'SEOBSaldo' => $faker->randomNumber(5),
        'SEOBAntTerr' => $faker->randomNumber(5),
        'SEOBVivEntFec' => $faker->dateTime,
        'SEOBAdjFec' => $faker->dateTime,
        'SEOBAdjRes' => $faker->randomNumber(5),
        'SEOBPylCod' => $faker->sentence,
        'SEOBResFecResc' => $faker->dateTime,
        'SEOBResNroResc' => $faker->randomNumber(5),
        'SEOBDocConvenio' => $faker->sentence,
        'SEOBDocResResc' => $faker->sentence,
        'SEOBDocResAdj' => $faker->sentence,
        'SEOBDocContrato' => $faker->sentence,
        'SEOBDocActIni' => $faker->sentence,
        'SEOBDocRecProv' => $faker->sentence,
        'SEOBDocRecDef' => $faker->sentence,
        'EmpSatCod' => $faker->sentence,
        'SupervCod' => $faker->sentence,
        'FiscalCod' => $faker->sentence,
        'SEOBFisDiasUltInf' => $faker->randomNumber(5),
        'SEOBModFch' => $faker->dateTime,
        'SEOBModUsu' => $faker->sentence,
        'SEOBAltaFch' => $faker->dateTime,
        'SEOBAltaUsu' => $faker->sentence,
        'SEOBPreDpto' => $faker->sentence,
        'SEOBPrePry' => $faker->sentence,
        'SEOBPreSub' => $faker->sentence,
        'SEOBPrePrg' => $faker->sentence,
        'SEOBPreTip' => $faker->sentence,
        'SEOBAtrasos' => $faker->randomNumber(5),
        'SEOBSTPMH' => $faker->sentence,
        'SEOBIdFase1' => $faker->randomNumber(5),
        'SEOBEtapa' => $faker->sentence,
        'SEOBEvTe' => $faker->sentence,
        'SEOBInfS' => $faker->sentence,
        'SEOBVTA' => $faker->sentence,
        'SEOBTerr' => $faker->sentence,
        'SEOBNroExpS' => $faker->sentence,
        'SEOBNroExp' => $faker->randomNumber(5),
        'SEOBVivPara' => $faker->randomNumber(5),
        'SEOBVivResc' => $faker->randomNumber(5),
        'SEOBVivAnul' => $faker->randomNumber(5),
        'SEOBPuOr' => $faker->sentence,
        'SEOBCanMujer' => $faker->randomNumber(5),
        'SEOBCanHombre' => $faker->randomNumber(5),
        'SEOBCanHijas' => $faker->randomNumber(5),
        'SEOBCanHijos' => $faker->randomNumber(5),
        'SEOBCanTercEdad' => $faker->randomNumber(5),
        'SEOBCanPadreSol' => $faker->randomNumber(5),
        'SEOBCanMadreSol' => $faker->randomNumber(5),
        'SEOBCanPCD' => $faker->randomNumber(5),
        'SEOBCanPO' => $faker->randomNumber(5),
        'SEOBVivEnProy' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Visit::class, static function (Faker\Generator $faker) {
    return [
        'project_id' => $faker->randomNumber(5),
        'visit_number' => $faker->sentence,
        'advance' => $faker->sentence,
        'visit_date' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Questionnaire::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Question::class, static function (Faker\Generator $faker) {
    return [
        'questionnaire_id' => $faker->sentence,
        'name' => $faker->text(),
        'description' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Question::class, static function (Faker\Generator $faker) {
    return [
        'questionnaire_id' => $faker->sentence,
        'name' => $faker->firstName,
        'description' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ProjectQuestion::class, static function (Faker\Generator $faker) {
    return [
        'questionnaire_id' => $faker->sentence,
        'project_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
