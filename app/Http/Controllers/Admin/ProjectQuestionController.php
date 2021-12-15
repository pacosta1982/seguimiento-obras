<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectQuestion\BulkDestroyProjectQuestion;
use App\Http\Requests\Admin\ProjectQuestion\DestroyProjectQuestion;
use App\Http\Requests\Admin\ProjectQuestion\IndexProjectQuestion;
use App\Http\Requests\Admin\ProjectQuestion\StoreProjectQuestion;
use App\Http\Requests\Admin\ProjectQuestion\UpdateProjectQuestion;
use App\Models\ProjectQuestion;
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

class ProjectQuestionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexProjectQuestion $request
     * @return array|Factory|View
     */
    public function index(IndexProjectQuestion $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ProjectQuestion::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'questionnaire_id', 'project_id'],

            // set columns to searchIn
            ['id', 'project_id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.project-question.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.project-question.create');

        return view('admin.project-question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectQuestion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProjectQuestion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ProjectQuestion
        $projectQuestion = ProjectQuestion::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/project-questions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/project-questions');
    }

    /**
     * Display the specified resource.
     *
     * @param ProjectQuestion $projectQuestion
     * @throws AuthorizationException
     * @return void
     */
    public function show(ProjectQuestion $projectQuestion)
    {
        $this->authorize('admin.project-question.show', $projectQuestion);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProjectQuestion $projectQuestion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ProjectQuestion $projectQuestion)
    {
        $this->authorize('admin.project-question.edit', $projectQuestion);


        return view('admin.project-question.edit', [
            'projectQuestion' => $projectQuestion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectQuestion $request
     * @param ProjectQuestion $projectQuestion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateProjectQuestion $request, ProjectQuestion $projectQuestion)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ProjectQuestion
        $projectQuestion->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/project-questions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/project-questions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyProjectQuestion $request
     * @param ProjectQuestion $projectQuestion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyProjectQuestion $request, ProjectQuestion $projectQuestion)
    {
        $projectQuestion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyProjectQuestion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyProjectQuestion $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ProjectQuestion::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
