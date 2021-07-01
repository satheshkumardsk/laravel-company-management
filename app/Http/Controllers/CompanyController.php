<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class CompanyController extends Controller
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


            return datatables()->of(Company::withCount('employees')->latest()->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-sm btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('companies');
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
            'company_name'    =>  'required|max:255',
            'company_email'     =>  'max:255',
            'company_logo'         =>  'image|max:2000|dimensions:min_width=100,min_height=100',
            'company_website'     =>  'max:255',
            //'active_status'     =>  'required',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $new_name ='';

if($request->file('company_logo')){
        $image = $request->file('company_logo');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images'), $new_name);
    }

        $form_data = array(
            'company_name'        =>  $request->company_name,
            'company_email'         =>  $request->company_email,
            'company_logo'             =>  $new_name,
            'company_website'         =>  $request->company_website,
            'active_status'         =>  $request->active_status ? $request->active_status : '1'
        );

        Company::create($form_data);

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
            $data = Company::findOrFail($id);
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
        $image_name = $request->hidden_image;
        $image = $request->file('company_logo');
        if($image != '')
        {
            $rules = array(
                'company_name'    =>  'required|max:255',
                'company_email'     =>  'max:255',
                'company_logo'         =>  'image|max:2000|dimensions:min_width=100,min_height=100',
                'company_website'     =>  'max:255',
                //'active_status'     =>  'required',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
        }
        else
        {
            $rules = array(
                'company_name'    =>  'required|max:255',
                'company_email'     =>  'max:255',
                'company_website'     =>  'max:255',
                //'active_status'     =>  'required',
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
        }

        $form_data = array(
            'company_name'        =>  $request->company_name,
            'company_email'         =>  $request->company_email,
            'company_logo'             =>  $image_name,
            'company_website'         =>  $request->company_website,
            'active_status'         =>  $request->active_status ? $request->active_status : '1'
        );
        Company::whereId($request->hidden_id)->update($form_data);

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
        $data = Company::findOrFail($id);
        $data->delete();
    }


}
