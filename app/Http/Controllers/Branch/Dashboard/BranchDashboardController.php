<?php

namespace App\Http\Controllers\Branch\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\Role_privilege;
use App\Models\Branch;

class BranchDashboardController extends Controller
{
    protected $branchId;
    protected $branchUserId;
    protected $type;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('branch')->check()) {
                abort(403, 'Unauthorized access');
            }

            $user = Auth::guard('branch')->user();

            if ($user->role_id == 7) {
                $branch = Branch::where('user_id', $user->id)->first();
                $this->branchId = $user->branch->id;
                $this->branchUserId = $user->id;
                $this->type = $branch->type;
            } else {
                $branch = Branch::where('user_id', $user->created_by)->first();
                if (!$branch) {
                    abort(403, 'Invalid branch access');
                }
                $this->branchId = $branch->id;
                $this->branchUserId = $user->created_by;
                $this->type = $branch->type;
            }

            return $next($request);
        });
    }

    public function index()
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();
        $type = $this->type;       

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'dashboard_view')){
             return view('Branch.Dashboard.index',compact('type')); 
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }
}