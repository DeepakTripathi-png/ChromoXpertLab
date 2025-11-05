<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

use App\Models\Cims_master\Sub_category;

class BaseController extends Controller
{
    public function delete(Request $request){
        $data = DB::table($request->table)->where('id', $request->id)->update([
            'status' => 'delete',
            'modified_by' => Auth::guard('master_admins')->user()->id,
            'modified_ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        return response()->json(['message' => $request->flash, 'status' => 'true']);
    }

    public function status(Request $request){

        $status = DB::table($request->table)->where('id', $request->id)->value('status');
        
        if ($status == 'active') {
            $block_status = DB::table($request->table)->where('id', $request->id)->update([
                'status' => 'inactive',
                'modified_by' => Auth::guard('master_admins')->user()->id,
                'modified_ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            $user_status = "inactive";
        } 
        else 
        {
            $active_status = DB::table($request->table)->where('id', $request->id)->update([
                'status' => 'active',
                'modified_by' => Auth::guard('master_admins')->user()->id,
                'modified_ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            $user_status = "active";
        }
        return response()->json(['message' => $request->flash, 'user_status' => $user_status, 'status' => 'true']);
    }

    public function subCategoryList(Request $request){
        if(!empty($request->category_id)){
            $sub_categories = Sub_category::where('status', 'active')->where('category_id', $request->category_id)->orderBy('id', 'desc')->get();
            if(!empty($sub_categories)){
                $options = "";
                $options .= '<option value="">Sub Category</option>';
                foreach($sub_categories as $sub_category){
                    $options .= '<option value="'. $sub_category->id .'">'. $sub_category->sub_category .'</option>';
                }
            }
            return response()->json(['options' => $options, 'status' => 'true']);
        }
        return response()->json(['status' => 'empty']);
    }

}