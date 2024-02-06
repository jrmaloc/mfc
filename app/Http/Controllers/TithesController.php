<?php

namespace App\Http\Controllers;

use App\Models\Tithe;
use App\Models\User;
use App\Notifications\TitheNotification;
use App\Services\PaymongoService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TithesController extends Controller
{

    function __construct(PaymongoService $paymongoService)
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
            $data = Tithe::get();

            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('household_servant', '{{$household_servant_name}}')

                // ->addColumn("actions", function ($tithe){
                //     return '<div class="dropdown">
                //     <a href="javascript:void(0);" id="'.$tithe->id.'" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>
                //     </div>';
                // })

                // ->rawColumns(['actions'])

                ->make(true);
        }

        $user = Auth::user();
        $userID = $user->id;

        return view('tithes.list-tithes', [
            'user' => $user,
            'id' => $userID,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $userID = $user->id;

        return view('tithes.create-tithes', [
            'user' => $user,
            'id' => $userID,
        ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */

    protected $paymongoService;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'email' => 'required|email',
            'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
            // 'amount' => 'required|numeric', // Ensures the field is required and numeric
            'amount' => 'nullable'
        ], [
            // 'amount.required' => 'Please specify an amount before continuing',
            // 'amount.regex' => 'Please input a proper amount',
            // 'amount.numeric' => 'Please input a proper amount',
            'required' => 'This field is required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect()->away('https://paymaya.me/GodesQDigital');

        // $amount = $request->input('amount');
        // $name = $request->input('name');
        // $email = $request->input('email');
        // $phone = $request->input('contact_number');

        // $data = [
        //     'data' => [
        //         'attributes' => [
        //             'line_items' => [
        //                 [
        //                     'currency' => 'PHP',
        //                     'amount' => $amount * 100,
        //                     'description' => 'Tithe',
        //                     'name' => 'Contribution',
        //                     'quantity' => 1
        //                 ]
        //             ],
        //             'payment_method_types' => [
        //                 'card',
        //                 'gcash',
        //                 'paymaya'
        //             ],
        //             'success_url' => 'http://127.0.0.1:8000/tithes/create',
        //             'cancel_url' => 'http://127.0.0.1:8000/tithes/create',
        //             'description' => 'Tithe'
        //         ]
        //     ]
        // ];

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
        //     'accept' => 'application/json'
        // ])
        //     ->post('https://api.paymongo.com/v1/checkout_sessions', $data);

        // if ($response->successful()) {
        //     $decodedResponse = $response->json();
        //     if (isset($decodedResponse['data'])) {
        //         $transactionId = $decodedResponse['data']['id']; // Get the transaction ID from Paymongo
        //         Session::put('session_id', $transactionId);

        //         // Store the transaction details in your database or any storage mechanism
        //         $transaction = Tithe::create([
        //             'name' => $name,
        //             'email' => $email,
        //             'contact_number' => $phone,
        //             'amount' => $amount,
        //             'transaction_number' => $transactionId,
        //             // Add more fields as needed
        //         ]);

        //         $admins = User::whereHas('roles', function ($query) {
        //             $query->whereIn('id', [1, 2, 3, 4, 5]); // Use whereIn for multiple IDs
        //         })->get();

        //         Notification::send($admins, new TitheNotification($transaction, 'New tithe has been recorded!'));

        //         return redirect()->to($decodedResponse['data']['attributes']['checkout_url']);
        //     }
        // }
        // dd($response->body());
    }

}
