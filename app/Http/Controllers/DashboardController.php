<?php

namespace App\Http\Controllers;

use App\Exports\TerminalReceivedDataExport;
use App\Models\Terminal;
use App\Models\TerminalDataReceive;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*if($request->has('download')){
            return Excel::download(new TerminalReceivedDataExport($request), "terminal_received_data_" . date('d_m_Y_H_i_s') . ".xlsx");
        }*/
        return view('admin.dashboard');
    }

    public function datatable(Request $request)
    {
        $Query = TerminalDataReceive::latest()->take(5000)->get();
        return DataTables::of($Query)->addIndexColumn()->make();
    }

    public function deviceStatus(Request $request)
    {
        $devices_status= Terminal::with('user')->get();
        return view('admin.deviceStatus',compact('devices_status'));
    }
}
