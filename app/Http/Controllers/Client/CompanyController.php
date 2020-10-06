<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
  private $mainDir = 'client.company.';
  private $mainRoute = 'client.company.';

  public function validator(Request $request)
  {
    return $request->validate([
      'name' => ['required', 'max:255'],
      'city' => ['required', 'max:255'],
      'found_date' => ['required', 'date'],
      'description' => ['required'],
      'company_field' => ['required', 'max:50'],
      'phone' => ['required', 'max:31'],
    ]);
  }

  public function __construct()
  {
    $this->middleware('auth')->except(['show']);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $companies = Auth::user()->companies;
    return view($this->mainDir . 'index', compact('companies'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view($this->mainDir . 'create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $this->validator($request);

    Auth::user()->companies->create($data);

    return redirect(route($this->mainRoute . 'index'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Company $company)
  {
    return view($this->mainDir . 'show', compact('company'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Company $company)
  {
    return view($this->mainDir . 'edit', compact('company'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Company $company)
  {
    $data = $this->validator($request);

    $company->update($data);

    return redirect(route($this->mainRoute . 'show', $company->id));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Company $company)
  {
    $company->delete();

    return redirect($this->mainDir . 'index');
  }
}
