<?php

namespace App\Http\Controllers\Admin;

use App\Models\SIG005L1;
use App\Models\SIG005;
use App\Models\SIG006;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Visit;
use Brackets\AdminListing\Facades\AdminListing;


class ExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view('guest.files.index');
    }

    public function show($numero)
    {

        $cabecera = SIG005::where('NroExp', $numero)->first();
        //$historial = SIG006::where('NroExp', $numero)->orderBy('DENroLin', 'asc')->get();

        if (empty($cabecera)) {
            return [
                'error' => 'No existe Registro de Expediente ' . $numero,
            ];
        } else {

            $historial = SIG006::where('NroExp', $numero)->orderBy('DENroLin', 'asc')->get();
            $date = new \DateTime($historial->first()->DEFecDis);

            $datasat = [];
            foreach ($historial as $key => $sat) {

                $now = new \DateTime($sat->DEFecDis);

                $datasat[] = [
                    'dias' => $date->diff($now)->format("%a") != 0 ? $date->diff($now)->format("%a") : "-",
                    'nro' => trim($sat->DENroLin),
                    'fecha' => date('d/m/Y', strtotime($sat->DEFecDis)),
                    'origen' => trim($sat->DEUnOrHa ? $sat->deporigen->DepenDes : ""),
                    'destino' => trim($sat->DEUnOrHa ? $sat->depdestino->DepenDes : ""),
                    'estado' => trim($sat->DEExpEst),
                    'fecha_rec' => $sat->DEExpEst == 'P' ? '' : date('d/m/Y', strtotime($sat->DEFecRcp)),
                    'recepcionado' => trim($sat->DERcpNam),
                    'observacion' => trim($sat->DEExpAcc),
                ];
            }
            $tipo = $cabecera->TexCod ? $cabecera->tiposol->TexDes : "N/A";
            $date = new \DateTime($historial->first()->DEFecDis);
            $total = $date->diff(new \DateTime())->format("%a");
        }

        return [
            'cabecera' => $cabecera,
            'historial' => $datasat,
            'tipo_sol' => trim($tipo),
            'total' => $total
        ];
        /*$estado = "";
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

        $postulante = SIG005L1::where('ExpDPerCod', $cedula)->first();
        if (empty($postulante)) {
                return [
                    'error' => 'No existe Registro de Postulante',
                ];
        } else {
            $cabecera = SIG005::where('NroExp',$postulante->ExpDNro)->get();
            $historial = SIG006:: where('NroExp', $postulante->ExpDNro)->orderBy('DENroLin', 'asc')->get();
            $proyecto = SIG005::where('NroExp',$postulante->NroExp)->get();
            $proyecto_historial = SIG006:: where('NroExp', $postulante->NroExp)->orderBy('DENroLin', 'asc')->get();
        }





        return [
            'postulante' => $postulante,
            'cabecera' => $cabecera,
            'historial' => $historial,
            'proyecto' => $proyecto,
            'proyecto_historial' => $proyecto_historial

        ];*/
    }
}
