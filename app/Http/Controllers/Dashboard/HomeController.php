<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Lecture;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function index()
    {
        $adminsCount = User::admins()->count();
        $studentsCount = User::students()->count();
        $stagesCount = Stage::count();
        $subjectsCount = Subject::count();
        $lecturesCount = Lecture::count();
        $rolesCount = Role::count();
        $contactsCount = Contact::count();
        $pendingCount = Subscription::where('payment_status', 'pending')->count();
        $pendingSubscriptions = Subscription::with(['user', 'subject'])
            ->where('payment_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.home', compact(
            'adminsCount',
            'studentsCount',
            'stagesCount',
            'subjectsCount',
            'lecturesCount',
            'rolesCount',
            'contactsCount',
            'pendingCount',
            'pendingSubscriptions'
        ));
    }
}
