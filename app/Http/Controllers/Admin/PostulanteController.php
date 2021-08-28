<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SIG005L1;
use App\Models\SIG005;
use App\Models\SIG006;
use Illuminate\Http\Request;

class PostulanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('guest.applicants.index');
    }

    public function show($cedula)
    {
        //return 'oiko';

        $estado = "";
        $parentesco = "";
        $certificado = "";
        $programa = "";

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

        $datasat = [];

        $postulante = SIG005L1::where('ExpDPerCod', $cedula)->first();
        if (empty($postulante)) {
            return [
                'error' => 'No existe Registro de Postulante ' . $cedula,
            ];
        } else {
            $cabecera = SIG005::where('NroExp', $postulante->ExpDNro)->first();
            //$historial = SIG006::where('NroExp',$request->input('NroExp')/*$idexp 1803411*/);

            $historial = SIG006::where('NroExp', $postulante->ExpDNro)->orderBy('DENroLin', 'asc')->get();
            $date = new \DateTime($historial->first()->DEFecDis);
            foreach ($historial as $key => $sat) {
                $now = new \DateTime($sat->DEFecDis);
                $datasat[] = [
                    'dias' => $date->diff($now)->format("%a") != 0 ? $date->diff($now)->format("%a") : "-",
                    'nro' => trim($sat->DENroLin),
                    'fecha' => date('d/m/Y', strtotime($sat->DEFecDis)),
                    'origen' => trim($sat->DEUnOrHa ? $sat->deporigen->DepenDes : ""),
                    'destino' => trim($sat->DEUnOrHa ? $sat->depdestino->DepenDes : ""),
                    'estado' => trim($sat->DEExpEst),
                    'fecha_rec' => $sat->DEExpEst == 'P' ? 'N/A' : date('d/m/Y', strtotime($sat->DEFecRcp)),
                    'recepcionado' => trim($sat->DERcpNam),
                    'observacion' => trim($sat->DEExpAcc),
                ];
            }
            $proyecto = SIG005::where('NroExp', $postulante->NroExp)->first();
            $proyecto_historial = SIG006::where('NroExp', $postulante->NroExp)->orderBy('DENroLin', 'asc')->get();
        }

        $tipo = $cabecera->TexCod ? $cabecera->tiposol->TexDes : "N/A";
        $date = new \DateTime($historial->first()->DEFecDis);
        $total = $date->diff(new \DateTime())->format("%a");


        return [
            'postulante' => $postulante,
            'cabecera' => $cabecera,
            'historial' => $datasat,
            'proyecto' => $proyecto,
            'tipo_sol' => trim($tipo),
            'proyecto_historial' => $proyecto_historial,
            'total' => $total
            /*'estado' => $estado,
            'titular' => $parentesco,
            'certificado' => $certificado,
            'programa' => $programa*/
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
