<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function student()
    {
        $complaints = Complaint::where('user_id', Auth::id())->latest()->get();
        return view('student.dashboard', compact('complaints'));
    }

    public function admin(Request $request)
    {
        $query = Complaint::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($qu) use ($request) {
                      $qu->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $complaints = $query->latest()->get();
        
        $pending = Complaint::where('status', 'pending')->count();
        $processing = Complaint::where('status', 'processing')->count();
        $resolved = Complaint::where('status', 'resolved')->count();
        
        return view('admin.dashboard', compact('complaints', 'pending', 'processing', 'resolved'));
    }
}
