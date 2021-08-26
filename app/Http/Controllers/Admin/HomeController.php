<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;
use App\Models\Call;
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
    public function index(Request $request)
    {


        $data = AdminListing::create(Project::class)
            ->attachPagination($request->currentPage)

            ->modifyQuery(function ($query) use ($request) {
                $query->where('SEOBAdmin', 8);
                $query->where('SEOBPlan', 14);
                $query->where('SEOBProgr', '!=', 16);
                if ($request->search) {

                    $query->where('SEOBProy', 'like', '%' . $request->search . '%');
                    $query->orWhere('SEOBEmpr', 'like', '%' . $request->search . '%');
                    $query->orWhere('SEOBId', 'like', '%' . $request->search . '%');
                }
            })
            ->get(['SEOBId', 'SEOBEmpr', 'SEOBProy', 'SEOBAvanc', 'DptoId', 'CiuId']);


        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('SEOBId')
                ];
            }
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

        return view('guest.projects.show', compact('project', 'data', 'visitas', 'avances'));
        // TODO your code goes here
    }

    public function showVisit(Visit $visit)
    {
        //$this->authorize('admin.visit.show', $visit);
        //return $visit->getMedia('gallery')->count();
        $datos = [];

        foreach ($visit->getMedia('gallery') as $key => $value) {
            array_push($datos, $value->getUrl());
        }

        //return $datos;
        // TODO your code goes here
        return view('guest.visits.show', compact('datos', 'visit'));
    }
}
