<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Nạp tiền vào hệ thống';
        $params = Transaction::join('users', 'transaction.user_id', '=', 'users.id')
                              ->select('transaction.*', 'users.name as userName')
                              ->orderBy('transaction.created_at', 'desc')
                              ->get();
    
        return view('backend.payment.index', compact('params', 'title'));
    }
    
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $userId = $request->input('userId');
        $coin = $request->input('coin');
        $bank = $request->input('bank');
        $code = $request->input('code'); 
        $status = $request->input('status');

        $user = User::find($userId);
        if($user){
            $user->coin += $coin;
            $user->save();
            try{
                DB::table('transaction')->insert([
                    'user_id'=>$userId,
                    'coin' => $coin,
                    'bank' => $bank,
                    'code' => $code,
                    'status' => $status,
                    'created_at'=> now()
                ]);
                $history = new History();
                $history->id_client = $userId;
                $history->coin = $coin;
                $history->type = $bank;
                $history->save();
                return response()->json(['message'=>'Success'],200);
            }catch(\Exception $e){
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
            }
        }else{
            return response()->json(['message' => 'Error'], 500);
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $transaction = Transaction::where('userId',$id)->get();
        if($transaction->isEmpty()){
            return response()->json(['message'=>'Not Found'],404);
        }else{
            return response()->json($transaction,200);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
