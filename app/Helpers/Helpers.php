<?php

namespace App\Helpers\Helpers;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use App\Models\Master\Visual_setting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Helper {
    public static function getCreatedByName($Master_admin){
        return Master_admin::where('status', 'active')->where('id', $Master_admin)->first()->user_name;
    }
    public static function getCreatedAtDateTime($date){
        return Carbon::createFromTimestamp(strtotime($date))->setTimezone('Asia/Kolkata')->format('d-m-Y h:i A');
    }
    public static function getCreatedAtDate($date){
        return Carbon::createFromTimestamp(strtotime($date))->setTimezone('Asia/Kolkata')->format('d-m-Y');
    }
    public static function getTimeFormat($time){
        return Carbon::createFromTimestamp(strtotime($time))->format('h:i A');
    }


    // public static function getRoleName(){
    //     return Role_privilege::where('status', 'active')->where('id', Auth::guard('master_admins')->user()->role_id)->first()->role_name;
    // }


    public static function getRoleName()
    {
        if (Auth::guard('master_admins')->check()) {
            $user = Auth::guard('master_admins')->user();
            return Role_privilege::where('status', 'active')->where('id', $user->role_id)->first()->role_name ?? 'Unknown Role';
        } elseif (Auth::guard('doctor')->check()) {
            $user = Auth::guard('doctor')->user();
            return Role_privilege::where('status', 'active')->where('id', $user->role_id)->first()->role_name ?? 'Doctor';
        } elseif (Auth::guard('branch')->check()) {
            $user = Auth::guard('branch')->user();
            return Role_privilege::where('status', 'active')->where('id', $user->role_id)->first()->role_name ?? 'Branch Manager';
        }
        return 'Guest';
    }


    public static function getVisualImages(){
        return Visual_setting::where('status', 'active')->first();
    }
}