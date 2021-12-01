<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Visit\BulkDestroyVisit;
use App\Http\Requests\Admin\Visit\DestroyVisit;
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

class VisitsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVisit $request
     * @return array|Factory|View
     */
    public function index(IndexVisit $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Visit::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'project_id', 'visit_number', 'advance', 'visit_date'],

            // set columns to searchIn
            ['id', 'visit_number', 'advance']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }


        /*$array = [
            {
      'labels' => ['January', 'February'],
      'datasets': [
        {
          "label" => '"Data One"',
          backgroundColor: '#f87979',
          data: [40, 20]
        }
      ]
    }
        ];*/
        $array =
            ['January', 'February', 'Marzo']
            /*"datasets" => [
                "label" => "Data One",
                "backgroundColor" => "#f87979",
                "data" => [40, 20]
            ]*/;

        //return $array;
        $options = array(
            "responsive" => true,
            "maintainAspectRatio" => false,


        );

        return view('admin.visit.index', compact('data', 'array', 'options'));
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

        return view('admin.visit.create');
    }

    public function sync(Project $project)
    {

        //return "hola";
        $data = [];

        $response = Http::get("https://analisis.stp.gov.py/user/muvh/api/v2/sql?api_key=04fd4c0ac550ea7ddf750e8426c05e0f9f907784&q=select * from muvhssm.v_respuesta_relevamient_muvh where muvhssm.v_respuesta_relevamient_muvh.id_muvh_proyecto='" . $project->SEOBId . "' order by muvhssm.v_respuesta_relevamient_muvh.relevamiento ,muvhssm.v_respuesta_relevamient_muvh.pregunta_id");
        //return $response;

        foreach ($response['rows'] as $key => $value) {

            $data[$value['relevamiento']][$value['pregunta_id']] = $value['respuesta_respuesta'];
            $data[$value['relevamiento']]['latitud'] = $value['latitud'];
            $data[$value['relevamiento']]['longitud'] = $value['longitud'];
        }

        $visitas =  Visit::where('project_id', $project->SEOBId)->orderBy('created_at')->get();

        //return $visitas;

        //return $data;
        return view('admin.visit.sync', compact('data', 'visitas', 'project'));
    }

    public function syncstore($project, $rel)
    {
        //return $rel;
        $data = [];
        $response = Http::get("https://analisis.stp.gov.py/user/muvh/api/v2/sql?api_key=04fd4c0ac550ea7ddf750e8426c05e0f9f907784&q=select * from muvhssm.v_respuesta_relevamient_muvh where muvhssm.v_respuesta_relevamient_muvh.relevamiento=" . $rel);
        //return $response;

        foreach ($response['rows'] as $key => $value) {

            $data[$value['relevamiento']][$value['pregunta_id']] = $value['respuesta_respuesta'];
            $data[$value['relevamiento']]['latitud'] = $value['latitud'];
            $data[$value['relevamiento']]['longitud'] = $value['longitud'];
        }
        //return $data;
        $sanitized['project_id'] = $project;
        $sanitized['visit_number'] = $data[$rel]['2720'];
        $sanitized['advance'] = $data[$rel]['2719'];
        $sanitized['visit_date'] = $data[$rel]['2718'];
        $sanitized['latitude'] = $data[$rel]['latitud'];
        $sanitized['longitude'] = $data[$rel]['longitud'];
        $sanitized['visit_id'] = $rel;
        //return $sanitized;
        $visit = Visit::create($sanitized);

        return redirect('admin/visits/' . $project . '/sync');
    }

    public function syncimage(Project $project, $rel)
    {
        //return "hola";

        $data = [];
        $response = Http::get("https://analisis.stp.gov.py/user/muvh/api/v2/sql?api_key=04fd4c0ac550ea7ddf750e8426c05e0f9f907784&q=select * from muvhssm.v_capturas_muvh where muvhssm.v_capturas_muvh.relevamientos_id=" . $rel);
        $imagenes = collect($response['rows']);

        //return $imagenes;

        $time = time();

        \Storage::disk('local')->makeDirectory($time,$mode=0775); // zip store here
        //$zip_file=storage_path('app/tobedownload/invoices.zip');


        $name = 'Test-'.time().'.zip';
        $zipper = new \Madnest\Madzipper\Madzipper;

        $data = [];
        foreach ($imagenes as $key => $value) {
            # code...
            //$url = $value['imagen'];
            $img = storage_path('app/'.$time.'/'.basename($value['imagen']));
            file_put_contents($img, file_get_contents($value['imagen']));


            //$data[$key] = basename($url);

        }

        foreach ($imagenes as $key => $value) {
            # code...
            //$files = storage_path('images/'.basename($value['imagen']));
            //$zipper->make(storage_path("app/tobedownload/".$name))->add($files);
        }

        $files = glob(storage_path('app/'.$time.'/*'));
        $zipper->make(storage_path("app/tobedownload/".$name))->add($files)->close();


        //return $data;
        //$zipper->zip(storage_path("app/tobedownload/".$name))->folder('IMAGENES')->add($data);
        //return $data;

        //$zipper->make(storage_path("app/tobedownload/".$name))->folder('')->add($data);

        //$zipper->close();

        return response()->download(storage_path("app/tobedownload/".$name));

        //return view('admin.visit.syncimage', compact('project', 'imagenes'));
    }

    public function download($name)
    {
        $filename = $name . '.jpg';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy('https://movil.stp.gov.py/staticFiles/' . $name . '.jpg', $tempImage);
        return response()->download($tempImage, $filename);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVisit $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreVisit $request)
    {
        //return $request;
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Visit
        $visit = Visit::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/projects/' . $sanitized['project_id'] . '/show'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/projects/' . $sanitized['project_id'] . '/show');
    }

    /**
     * Display the specified resource.
     *
     * @param Visit $visit
     * @throws AuthorizationException
     * @return void
     */
    public function show(Visit $visit)
    {
        $this->authorize('admin.visit.show', $visit);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Visit $visit
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Visit $visit)
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
    public function update(UpdateVisit $request, Visit $visit)
    {
        //return $request;
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Visit

        //return $sanitized;
        $visit->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/projects/' . $sanitized['project_id'] . '/show'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/projects/' . $sanitized['project_id'] . '/show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyVisit $request
     * @param Visit $visit
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyVisit $request, Visit $visit)
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
                    Visit::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
