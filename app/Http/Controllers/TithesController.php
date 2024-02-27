<?php

namespace App\Http\Controllers;

use App\Models\Tithe;
use App\Services\PaymongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TithesController extends Controller
{

    public function __construct(PaymongoService $paymongoService)
    {
        $this->middleware('permission:view-tithes', ['only' => ['index']]);
        $this->middleware('permission:create-tithes', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-tithes', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-tithes', ['only' => ['destroy']]);
        $this->paymongoService = $paymongoService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tithe::with('users')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('tithes.list-tithes');
    }

    public function view(Request $request)
    {
        if($request->ajax()) {
            return redirect()->route('tithes.list');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tithes.create-tithes');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'email' => 'required|email',
            'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
            // 'amount' => 'required|numeric', // Ensures the field is required and numeric
            'amount' => 'nullable',
        ], [
            // 'amount.required' => 'Please specify an amount before continuing',
            // 'amount.regex' => 'Please input a proper amount',
            // 'amount.numeric' => 'Please input a proper amount',
            'required' => 'This field is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // return redirect()->away('https://paymaya.me/GodesQDigital');
    }

}
