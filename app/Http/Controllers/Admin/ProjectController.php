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

        $dt = new \DateTime('2021-05-21');
        $date = $dt->format('Y-d-m H:i:s.v');

        $dt2 = new \DateTime('2021-06-04');
        $date2 = $dt2->format('Y-d-m H:i:s.v');

        $dt3 = new \DateTime('2021-07-02');
        $date3 = $dt3->format('Y-d-m H:i:s.v');

        $data = AdminListing::create(Project::class)
            //->attachOrdering('id')
            ->attachPagination($request->currentPage)

            ->modifyQuery(function ($query) use ($request, $date, $date2, $date3) {
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
                //return 'No Funciona';
            })
            //->paginate(15)
            ->get(['SEOBId', 'SEOBEmpr', 'SEOBProy', 'SEOBAvanc', 'DptoId', 'CiuId']);

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
                    ->where('visits.project_id', '=', $projectid);
                //->orderBy('requirements.requirement_type_id');
            }
        );
        //return $project;

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.projects.show', compact('project', 'data', 'visitas', 'avances'));
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
}
