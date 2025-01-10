<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function getUsersList()
    {
        $users = User::whereNotNull('email_verified_at')
            ->where('is_active', true)
            ->with('roles')
            ->orderBy('created_at','desc')
            ->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                return $row->user_first_name . ' ' . $row->user_last_name;
            })
            ->addColumn('status', function ($row) {
                $status = $row->is_active ? 'Active' : 'Inactive';
                $badgeClass = $row->is_active ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
            })
            ->addColumn('role', function ($row) {
                $roles = $row->roles->pluck('name')->implode(', ');
                return '<span class="badge badge-info">' . $roles . '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d M Y, h:i A');
            })
            ->addColumn('actions', function ($row) {
                $editUrl = route('users.edit', $row->id);
                $deleteUrl = route('users.destroy', $row->id);

                return '<a href="' . $editUrl . '" class="text-info" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                ' . (in_array('Super Admin', $row->roles->pluck('name')->toArray()) ? '' : '
                    <a href="javascript:void(0);" class="text-danger delete-btn" data-id="' . $row->id . '" title="Delete">
                        <i class="fas fa-trash"></i>
                    </a>
                ') . '
            ';
            })
            ->rawColumns(['actions', 'role', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::where('id', '!=', 1)->get();
        }
        return view('admin.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest/*Request*/ $request)
    {
        try {
            $input = $request->all();
            $input['email_verified_at'] = Carbon::now();
            $input['password'] = Hash::make($input['password']);
            if (in_array('2',$input['roles'])){
                $input['role_id'] = 2;
            }
            $input['roles'] = array_map('intval', $input['roles']);
            $user = User::create($input);
            $user->syncRoles($input['roles']);
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        }catch (\Throwable $th){
            dd($th->getMessage());
            return back()->with('error', /*'Something went wrong!'*/$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::where('id', '!=', 1)->get();
        }
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $input = $request->all();

            if ($request->filled('password')){
                $input['password'] = Hash::make($input['password']);
            }else{
                unset($input['password']);
            }

            if (in_array('2',$input['roles'])){
                $input['role_id'] = 2;
            }

            $input['roles'] = array_map('intval', $input['roles']);

            $user->update($input);
            $user->syncRoles($input['roles']);
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        }catch (\Throwable $th){
            dd($th->getMessage());
            return back()->with('error', /*'Something went wrong!'*/$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting user. ' . $e->getMessage()
            ], 500);
        }
    }
}
