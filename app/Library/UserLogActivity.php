<?php


namespace App\Library;
use Request;
use App\Models\LogActivity;

class UserLogActivity
{


    public static function createLogActivity($new_data,$old_data,$model,$action)
    {
			$log = [];
			$log['new_data'] = $new_data;
			$log['old_data'] = $old_data;
			$log['model'] = $model;
			$log['action'] = $action;
			$log['url'] = Request::fullUrl();
			$log['method'] = Request::method();
			$log['ip'] = Request::ip();
			$log['agent'] = Request::header('user-agent');
			$log['user_id']= '1';
			$log['user_id'] = auth()->guard('master_admins')->user()->id;
			LogActivity::create($log);
    }

}