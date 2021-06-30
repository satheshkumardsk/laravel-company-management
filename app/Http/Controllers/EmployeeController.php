<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if(request()->ajax())
        {


            return datatables()->of(Employee::with('company')->latest()->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-sm btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $companies_data=Company::all();
        return view('employees', compact('companies_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'company_id'         =>  'required',
            'email'     =>  'required',
            'phone'         =>  'required',
            'designation'     =>  'required',
            'active_status'     =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'company_id'    =>  $request->company_id,
            'email'         =>  $request->email,
            'phone'         =>  $request->phone,
            'designation'   =>  $request->designation,
            'active_status' =>  $request->active_status
        );

        Employee::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Employee::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }


    public function update(Request $request,$id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_data(Request $request)
    {
            $rules = array(
                'first_name'    =>  'required',
                'last_name'     =>  'required',
                'company_id'         =>  'required',
                'email'     =>  'required',
                'phone'         =>  'required',
                'designation'     =>  'required',
                'active_status'     =>  'required',
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }


        $form_data = array(
            'first_name'    =>  $request->first_name,
            'last_name'     =>  $request->last_name,
            'company_id'    =>  $request->company_id,
            'email'         =>  $request->email,
            'phone'         =>  $request->phone,
            'designation'   =>  $request->designation,
            'active_status' =>  $request->active_status
        );
        Employee::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function destroy_data($id)
    {
        $data = Employee::findOrFail($id);
        $data->delete();
    }



}
