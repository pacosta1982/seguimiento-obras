<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Visit\BulkDestroyVisit;
use App\Http\Requests\Admin\Visit\DestroyVisit;
use App\Http\Requests\Admin\Visit\IndexVisit;
use App\Http\Requests\Admin\Visit\StoreVisit;
use App\Http\Requests\Admin\Visit\UpdateVisit;
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
