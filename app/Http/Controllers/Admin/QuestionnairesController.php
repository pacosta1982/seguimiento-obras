<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Questionnaire\BulkDestroyQuestionnaire;
use App\Http\Requests\Admin\Questionnaire\DestroyQuestionnaire;
use App\Http\Requests\Admin\Questionnaire\IndexQuestionnaire;
use App\Http\Requests\Admin\Questionnaire\StoreQuestionnaire;
use App\Http\Requests\Admin\Questionnaire\UpdateQuestionnaire;
use App\Models\Questionnaire;
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

class QuestionnairesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexQuestionnaire $request
     * @return array|Factory|View
     */
    public function index(IndexQuestionnaire $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Questionnaire::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'description'],

            // set columns to searchIn
            ['id', 'name', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.questionnaire.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.questionnaire.create');

        return view('admin.questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestionnaire $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreQuestionnaire $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Questionnaire
        $questionnaire = Questionnaire::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/questionnaires'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/questionnaires');
    }

    /**
     * Display the specified resource.
     *
     * @param Questionnaire $questionnaire
     * @throws AuthorizationException
     * @return void
     */
    public function show(Questionnaire $questionnaire)
    {
        $this->authorize('admin.questionnaire.show', $questionnaire);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Questionnaire $questionnaire
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Questionnaire $questionnaire)
    {
        $this->authorize('admin.questionnaire.edit', $questionnaire);


        return view('admin.questionnaire.edit', [
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestionnaire $request
     * @param Questionnaire $questionnaire
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateQuestionnaire $request, Questionnaire $questionnaire)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Questionnaire
        $questionnaire->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/questionnaires'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/questionnaires');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyQuestionnaire $request
     * @param Questionnaire $questionnaire
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyQuestionnaire $request, Questionnaire $questionnaire)
    {
        $questionnaire->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyQuestionnaire $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyQuestionnaire $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Questionnaire::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
