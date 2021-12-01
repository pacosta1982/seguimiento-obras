<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\Subsidio;
use App\Models\City;
use App\Models\Project;
use App\Models\Visit;
use App\Http\Requests\Admin\Visit\IndexVisit;
use App\Models\MediaDocument;
use App\Models\EducationLevel;
use App\Models\DocumentType;
use App\Models\ApplicantDocument;
use App\Models\ApplicantStatus;
use App\Models\ContactMethod;
use App\Models\ApplicantContactMethod;
use App\Http\Requests\StoreApplicantUser;
use App\Http\Requests\StoreApplicantUserDocument;
use App\Http\Requests\StoreApplicantUserConyuge;
use App\Http\Requests\UpdateApplicantUserConyuge;
use App\Http\Requests\UpdateApplicantUser;
use Illuminate\Support\Facades\Storage;

use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;


use Brackets\AdminListing\Facades\AdminListing;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $dt = new \DateTime('2021-05-21');
        $date = $dt->format('Y-d-m H:i:s.v');
        $datos =  Project::where('SEOBAdmin', 8)
            /*->where('SEOBPlan', 14)
            ->where('SEOBProgr', 4)
            ->where('SEOBNCont', '02/2021')
            ->where('SEOBAdjFec', $date)*/
            ->where('SEOBVerObra', 'S')
            ->select('DptoNom', 'SEOBViv', 'SEGOBRA.DptoId', 'SEOBEst', 'SEOBEst', 'ObraEstDesc', 'SEOBFisAva')
            ->join('BAMDPT', 'SEGOBRA.DptoId', '=', 'BAMDPT.DptoId')
            ->join('OBRASESTADOS', 'SEGOBRA.SEOBEst', '=', 'OBRASESTADOS.ObraEstCod')
            ->get();

        $estados = $datos->groupBy('ObraEstDesc')->map(function ($datos) {
            return $datos->count();
        });

        //return $estados;

        $departamentos = $datos->groupBy('DptoNom')->map(function ($datos) {
            return $datos->sum('SEOBViv');
        });

        //Etiqueta Estados
        $labels_estados = array_keys($estados->toArray());
        $labels_estados_fixed = array_map('trim', $labels_estados);
        //return $labels_estados_fixed;

        //Etiquetas DEpartamentos
        $labels_dptos = array_keys($departamentos->toArray());
        $labels_fixed = array_map('trim', $labels_dptos);

        //Avances
        $avance = [];
        $a1 = $a2 = $a3 = $a4 = $a5 = $datos;

        $avance = [
            '0% - 20%' => $a1->where('SEOBFisAva', '<=', 21)->count(),
            '21% - 40%' => $a2->where('SEOBFisAva', '>', 21)->where('SEOBFisAva', '<=', 40)->count(),
            '41% - 60%' => $a3->where('SEOBFisAva', '>', 41)->where('SEOBFisAva', '<=', 60)->count(),
            '61% - 80%' => $a4->where('SEOBFisAva', '>', 61)->where('SEOBFisAva', '<=', 80)->count(),
            '81% - 100%' => $a5->where('SEOBFisAva', '>', 81)->where('SEOBFisAva', '<=', 100)->count(),
        ];

        //return $avance;

        return view('home', compact('estados', 'departamentos', 'labels_fixed', 'labels_estados_fixed', 'avance'));
    }


    public function index(Request $request)
    {

        //return 'hola';
        $dt = new \DateTime('2021-05-21');
        $date = $dt->format('Y-d-m H:i:s.v');
        $data = AdminListing::create(Project::class)
            ->attachPagination($request->currentPage)

            ->modifyQuery(function ($query) use ($request, $date) {
                /*$query->where('SEOBAdmin', 8);
                $query->where('SEOBPlan', 14);
                $query->where('SEOBProgr', 4);
                $query->where('SEOBNCont', '02/2021');
                $query->whereIn('SEOBAdjFec', [$date, $date2, $date3]);*/
                $query->where('SEOBVerObra', 'S');

                if ($request->search) {
                    //return 'funciona';

                    $query->where('SEOBProy', 'like', '%' . $request->search . '%');
                    //$query->orWhere('SEOBEmpr', 'like', '%' . $request->search . '%');
                    //$query->orWhere('SEOBId', 'like', '%' . $request->search . '%');
                    //$query->orWhere('SEOBId', $request->search);
                    //$query->paginate(15);
                }
            })
            ->get(['SEOBId', 'SEOBEmpr', 'SEOBProy', 'SEOBAvanc', 'DptoId', 'CiuId', 'SEOBViv', 'SEOBEst']);


        if ($request->ajax()) {
            /*if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('SEOBId')
                ];
            }*/
            return ['data' => $data];
        }

        return view('guest.projects.index', ['data' => $data]);
    }

    public function show(Project $project, IndexVisit $request)
    {
        //$this->authorize('admin.visit.show', $project);
        $projectid = $project->SEOBId;


        $visitas = $project->visits->pluck('visit_number');
        $avances = $project->visits->pluck('advance');
        $data = AdminListing::create(Visit::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'project_id', 'visit_number', 'advance', 'visit_date'],

            // set columns to searchIn
            ['id', 'visit_number', 'advance'],
            function ($query) use ($projectid) {
                $query
                    ->where('visits.project_id', '=', $projectid)
                    ->orderByRaw('CAST(visit_number AS INTEGER)');
                //->orderBy('requirements.requirement_type_id');
            }
        );
        //return $project;
        //return trim($project->fonavisproy->SPNucCod);
        $postulantes = Subsidio::where('CerNucCod', $project->fonavisproy->SPNucCod)
            ->where('CerGnuCod', $project->fonavisproy->SPGnuCod)
            //->orderBy('CerposNom')
            ->get();
        $latlong = $this->ToLL((int)$project->SEOBUtmY, (int)$project->SEOBUtmX, preg_replace("/[^0-9]/", '', $project->SEOBUtm1));

        //return $latlong;

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('guest.projects.show', compact('project', 'data', 'visitas', 'avances', 'postulantes', 'latlong'));
        // TODO your code goes here
    }

    public function showVisit(Visit $visit)
    {
        //$this->authorize('admin.visit.show', $visit);
        //return $visit->getMedia('gallery')->count();
        $datos = [];
        $project = Project::find($visit->project_id);
        foreach ($visit->getMedia('gallery') as $key => $value) {
            array_push($datos, $value->getUrl());
        }

        //return $project;
        // TODO your code goes here
        return view('guest.visits.show', compact('datos', 'visit', 'project'));
    }




    //Funcion de Calculo UTM A LAT LONG

    public function ToLL($north, $east, $utmZone)
    {
        // This is the lambda knot value in the reference
        $LngOrigin = Deg2Rad($utmZone * 6 - 183);

        // The following set of class constants define characteristics of the
        // ellipsoid, as defined my the WGS84 datum.  These values need to be
        // changed if a different dataum is used.

        $FalseNorth = 10000000;   // South or North?
        //if (lat < 0.) FalseNorth = 10000000.  // South or North?
        //else          FalseNorth = 0.

        $Ecc = 0.081819190842622;       // Eccentricity
        $EccSq = $Ecc * $Ecc;
        $Ecc2Sq = $EccSq / (1. - $EccSq);
        $Ecc2 = sqrt($Ecc2Sq);      // Secondary eccentricity
        $E1 = (1 - sqrt(1 - $EccSq)) / (1 + sqrt(1 - $EccSq));
        $E12 = $E1 * $E1;
        $E13 = $E12 * $E1;
        $E14 = $E13 * $E1;

        $SemiMajor = 6378137.0;         // Ellipsoidal semi-major axis (Meters)
        $FalseEast = 500000.0;          // UTM East bias (Meters)
        $ScaleFactor = 0.9996;          // Scale at natural origin

        // Calculate the Cassini projection parameters

        $M1 = ($north - $FalseNorth) / $ScaleFactor;
        $Mu1 = $M1 / ($SemiMajor * (1 - $EccSq / 4.0 - 3.0 * $EccSq * $EccSq / 64.0 - 5.0 * $EccSq * $EccSq * $EccSq / 256.0));

        $Phi1 = $Mu1 + (3.0 * $E1 / 2.0 - 27.0 * $E13 / 32.0) * sin(2.0 * $Mu1);
        + (21.0 * $E12 / 16.0 - 55.0 * $E14 / 32.0)           * sin(4.0 * $Mu1);
        + (151.0 * $E13 / 96.0)                          * sin(6.0 * $Mu1);
        + (1097.0 * $E14 / 512.0)                        * sin(8.0 * $Mu1);

        $sin2phi1 = sin($Phi1) * sin($Phi1);
        $Rho1 = ($SemiMajor * (1.0 - $EccSq)) / pow(1.0 - $EccSq * $sin2phi1, 1.5);
        $Nu1 = $SemiMajor / sqrt(1.0 - $EccSq * $sin2phi1);

        // Compute parameters as defined in the POSC specification.  T, C and D

        $T1 = tan($Phi1) * tan($Phi1);
        $T12 = $T1 * $T1;
        $C1 = $Ecc2Sq * cos($Phi1) * cos($Phi1);
        $C12 = $C1 * $C1;
        $D  = ($east - $FalseEast) / ($ScaleFactor * $Nu1);
        $D2 = $D * $D;
        $D3 = $D2 * $D;
        $D4 = $D3 * $D;
        $D5 = $D4 * $D;
        $D6 = $D5 * $D;

        // Compute the Latitude and Longitude and convert to degrees
        $lat = $Phi1 - $Nu1 * tan($Phi1) / $Rho1 * ($D2 / 2.0 - (5.0 + 3.0 * $T1 + 10.0 * $C1 - 4.0 * $C12 - 9.0 * $Ecc2Sq) * $D4 / 24.0 + (61.0 + 90.0 * $T1 + 298.0 * $C1 + 45.0 * $T12 - 252.0 * $Ecc2Sq - 3.0 * $C12) * $D6 / 720.0);

        $lat = Rad2Deg($lat);

        $lon = $LngOrigin + ($D - (1.0 + 2.0 * $T1 + $C1) * $D3 / 6.0 + (5.0 - 2.0 * $C1 + 28.0 * $T1 - 3.0 * $C12 + 8.0 * $Ecc2Sq + 24.0 * $T12) * $D5 / 120.0) / cos($Phi1);

        $lon = Rad2Deg($lon);

        // Create a object to store the calculated Latitude and Longitude values
        $PC_LatLon['lat'] = $lat;
        $PC_LatLon['lon'] = $lon;

        // Returns a PC_LatLon object
        return $PC_LatLon;
        //return "['latitude' => ".$lat.", 'longitude' => ".$lon."], ";
    }
}
