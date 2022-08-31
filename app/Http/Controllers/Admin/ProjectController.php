<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Visit\BulkDestroyVisit;
use App\Http\Requests\Admin\Visit\DestroyVisit;
use App\Http\Requests\Admin\Projects\IndexProjects;
use App\Http\Requests\Admin\Visit\IndexVisit;
use App\Http\Requests\Admin\Visit\StoreVisit;
use App\Http\Requests\Admin\Visit\UpdateVisit;
use App\Models\Project;
use App\Models\Visit;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVisit $request
     * @return array|Factory|View
     */
    public function index(IndexProjects $request)
    {

        $data = AdminListing::create(Project::class)
            //->attachOrdering('id')
            ->attachPagination($request->currentPage)

            ->modifyQuery(function ($query) use ($request) {

                $query->where('SEOBVerObra', 'S');

                if ($request->search) {

                    $query->where(function ($query) use ($request) {
                        $query->where('SEOBProy', 'like', '%' . $request->search . '%')
                              ->orWhereHas('departamento', function ($query) use ($request) {
                                    $query->where('DptoNom', 'like', '%' . $request->search . '%');
                                })
                              ->orWhere('SEOBNCont', 'like', '%' . $request->search . '%')
                              ->orWhere('SEOBEmpr', 'like', '%' . $request->search . '%')
                              ->orWhere('SEOBId', 'like', '%' . $request->search . '%');
                    })->where(function ($query) {
                        $query->where('SEOBVerObra', 'S');
                    });


                }

            })
            //->orderBy('SEOBNCont')
            ->get(['SEOBId', 'SEOBEmpr', 'SEOBProy', 'SEOBAvanc', 'DptoId', 'CiuId', 'SEOBViv', 'SEOBEst','SEOBNCont']);

        //  return $request;

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('SEOBId')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.projects.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.visit.create');

        return view('admin.projects.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVisit $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVisit $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Visit
        $visit = Project::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/visits'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/visits');
    }

    /**
     * Display the specified resource.
     *
     * @param Visit $visit
     * @throws AuthorizationException
     * @return void
     */
    public function show(Project $project, IndexVisit $request)
    {
        $this->authorize('admin.visit.show', $project);
        $projectid = $project->SEOBId;
        /*$data = [];

        $response = Http::get("https://analisis.stp.gov.py/user/muvh/api/v2/sql?api_key=04fd4c0ac550ea7ddf750e8426c05e0f9f907784&q=select * from muvhssm.v_respuesta_relevamient_muvh where muvhssm.v_respuesta_relevamient_muvh.id_muvh_proyecto='" . $project->SEOBId . "' order by muvhssm.v_respuesta_relevamient_muvh.relevamiento ,muvhssm.v_respuesta_relevamient_muvh.pregunta_id");
        //return $response;

        foreach ($response['rows'] as $key => $value) {

            $data[$value['relevamiento']][$value['pregunta']] = $value['respuesta_respuesta'];
            $data[$value['relevamiento']]['latitud'] = $value['latitud'];
            $data[$value['relevamiento']]['longitud'] = $value['longitud'];
        }

        return $data;*/

        $visitas = $project->visits->pluck('visit_number');
        $avances = $project->visits->pluck('advance');
        //return $project->visits;
        //$visitas;
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
                    //->orderBy('visit_number');
            }
        );

        $latlong = $this->ToLL((int)$project->SEOBUtmY, (int)$project->SEOBUtmX, preg_replace("/[^0-9]/", '', $project->SEOBUtm1));
        //return $project;

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.projects.show', compact('project', 'data', 'visitas', 'avances', 'latlong'));
        // TODO your code goes here
    }

    public function createvisit(Project $project)
    {
        //$this->authorize('admin.visit.create');

        return view('admin.visit.create', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Visit $visit
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Project $visit)
    {
        $this->authorize('admin.visit.edit', $visit);


        return view('admin.visit.edit', [
            'visit' => $visit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVisit $request
     * @param Visit $visit
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateVisit $request, Project $visit)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Visit
        $visit->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/visits'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/visits');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVisit $request
     * @param Visit $visit
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVisit $request, Project $visit)
    {
        $visit->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyVisit $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyVisit $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Project::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

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
