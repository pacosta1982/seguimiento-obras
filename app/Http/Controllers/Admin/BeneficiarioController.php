<?php

namespace App\Http\Controllers;

use App\SHMCER;
use Illuminate\Http\Request;

class BeneficiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($cedula)
    {
        $estado = "";
        $parentesco = "";
        $certificado = "";
        $programa = "";
        $ciudad = "";
        $dpto = "";
        $mod = "";

        $certificados_vigencia = [
            1 => "Emitido Vigente",
            2 => "Vencido",
            3 => "Efectivizado",
            4 => "Entregado",
            5 => "Pendiente de Entrega",
            6 => "Rectificado",
            7 => "Anulado",
            8 => "Renuncia",
            9 => "Prorrogado",
            10 => "Sustituido",
            11 => "Duplicado",
            12 => "Ley 5829/17",
            99 => "Sin estado"
        ];

        $programas = [
            0 => "N/D",
            1 => "FONAVIS",
            2 => "VYA RENDA",
            3 => "CHE TAPYI",
            4 => "SEMBRANDO",
            5 => "EBY",
            6 => "AMA",
            7 => "SAN FRANCISCO",
            99 => "Sin Programa"
        ];

        $modalidad = [
            3 => "Conjunto Habitacional",
            0 => "Individual",
            1 => "Individual",
            99 => ""
        ];

        $benficiario = SHMCER::where('CerPosCod', $cedula)->first();
        if (empty($benficiario)) {
            $benficiario = SHMCER::where('CerCoCi', $cedula)->first();
            if (empty($benficiario)) {
                /*$cartera = PRMCLI::where('PerCod',$request->input('cedula'))
                ->where('PylCod','!=' ,'P.F.')
                ->get();*/
                $estado = false;
                return [
                    'error' => 'No existe Registro de Beneficiario ' . $cedula,
                ];

            } else {
                $parentesco = "conyuge";
            }
        } else {
            $parentesco = "titular";
        }

        if (!empty($benficiario)) {
            $estado = true;
            $certificado = $certificados_vigencia[$benficiario['CerEst'] ? $benficiario['CerEst'] : 99];
            $programa = $programas[$benficiario['CerProg'] ? $benficiario['CerProg'] : 0];
            $dpto = $benficiario['CerDptoId'] ? trim($benficiario->departamento->DptoNom) : "";
            $ciudad = $benficiario['CerCiuId'] ? trim($benficiario->distrito->CiuNom) : "";
            $mod = $modalidad[$benficiario['CerPrgCod'] ? $benficiario['CerPrgCod'] : 99];
        }



        return [
            'beneficiario' => $benficiario,
            'estado' => $estado,
            'titular' => $parentesco,
            'certificado' => $certificado,
            'programa' => $programa,
            'ciudad' => $ciudad,
            'departamento' => $dpto,
            'modalidad' => $mod
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SHMCER  $sHMCER
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('beneficiarios');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SHMCER  $sHMCER
     * @return \Illuminate\Http\Response
     */
    public function edit(SHMCER $sHMCER)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SHMCER  $sHMCER
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SHMCER $sHMCER)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SHMCER  $sHMCER
     * @return \Illuminate\Http\Response
     */
    public function destroy(SHMCER $sHMCER)
    {
        //
    }
}
