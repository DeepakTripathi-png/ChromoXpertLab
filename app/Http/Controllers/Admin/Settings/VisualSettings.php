<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Visual_setting;
use App\Models\Master\Role_privilege;
use App\Traits\MediaTrait;
use Auth;

class VisualSettings extends Controller
{
    use MediaTrait;
    public function index(){
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'general_setting_view')){
            $visual_settings = Visual_setting::where('status', 'active')->first();
            return view('Admin.Settings.visual-setting', compact('visual_settings'));
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        } 
    }

    public function store(Request $request){
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        $request->validate([
            'logo_image_path' => 'max:2048',
            'mini_logo_image_path' => 'max:2048',         
            'logo_email_image_path' => 'max:2048',
            'favicon_image_path' => 'max:2048',
        ]);

        $input = [];
        if(!empty($request->file())){
            $input = array_merge($input, $this->uploadFiles($request->file(), 'images/visuals'));
        }

        if(!empty($request->id)){
            if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'visual_setting_edit')){
                $input['modified_by'] = auth()->guard('master_admins')->user()->id;
                $input['modified_ip_address'] = $request->ip();
                Visual_setting::where('id', $request->id)->update($input);
                return redirect('admin/visual-setting')->with('success', 'Visual Settings updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
            } 
        } else {
            if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'visual_setting_add')){
                $input['created_by'] = auth()->guard('master_admins')->user()->id;
                $input['created_ip_address'] = $request->ip();
                Visual_setting::create($input);
                return redirect('admin/visual-setting')->with('success', 'Visual Settings added successfully!');
            } else {
                return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
            } 
        }
    }
}
