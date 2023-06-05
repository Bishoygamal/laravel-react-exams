<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Account;
use Validator;

class AccountController extends BaseController
{
    //
    public function AddNewAccount(Request $request){
        $validator = Validator::make($request->all(),[
            'account_name'=>'required',
            'account_type'=>'required',
            'account_limit'=>'required',

        ]);

        if($validator->fails()){
            return $this->sendError('Validator Error',$validator->errors());
        }
        $input = $request->all();
        $account=account::create($input);
        return $this->sendResponse($account,'account added Successfullly');
    }

    public function GetAllAccounts(){
        $accounts = Account::get();
        return  $accounts;
    }

}
