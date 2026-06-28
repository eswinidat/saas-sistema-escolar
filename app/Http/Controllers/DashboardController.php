<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Modules\Academic\Models\Teacher;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Treasury\Models\StudentCharge;
use App\Support\AdminPanel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $type = AdminPanel::type();
        $user = Auth::user();

        return match ($type) {
            'super' => view('admin.dashboard-super', $this->superStats()),
            'teacher' => view('admin.dashboard-teacher', $this->teacherStats($user)),
            'student' => view('admin.dashboard-student', $this->studentStats($user)),
            default => view('admin.dashboard-school', $this->schoolStats($user)),
        };
    }

    protected function superStats(): array
    {
        $schoolId = session('current_school_id');
        $user = Auth::user();
        $chat = app(\App\Services\ChatService::class);

        $contacts = $chat->schoolContactsForSuperAdmin();
        $conversations = $chat->conversationsFor($user);
        $activeConversation = $conversations->first();
        $messages = $activeConversation
            ? $activeConversation->messages()->with('user')->latest()->take(20)->get()->reverse()->values()
            : collect();

        if ($activeConversation) {
            $chat->markRead($activeConversation, $user);
        }

        return [
            'totalSchools' => School::count(),
            'totalUsers' => User::count(),
            'activeSchool' => $schoolId ? School::find($schoolId) : null,
            'schoolStudents' => $schoolId ? Student::withoutGlobalScopes()->where('school_id', $schoolId)->count() : 0,
            'schoolTeachers' => $schoolId ? Teacher::withoutGlobalScopes()->where('school_id', $schoolId)->count() : 0,
            'chatContacts' => $contacts,
            'chatConversation' => $activeConversation,
            'chatMessages' => $messages,
            'chatUnread' => $chat->unreadCount($user),
        ];
    }

    protected function schoolStats(User $user): array
    {
        $schoolId = $user->school_id;

        return [
            'school' => $user->school,
            'students' => $schoolId ? Student::where('school_id', $schoolId)->count() : 0,
            'teachers' => $schoolId ? Teacher::where('school_id', $schoolId)->count() : 0,
            'enrollments' => $schoolId ? Enrollment::where('school_id', $schoolId)->where('status', 'active')->count() : 0,
            'pendingCharges' => $schoolId
                ? StudentCharge::where('school_id', $schoolId)->whereIn('status', ['pending', 'partial', 'overdue'])->count()
                : 0,
        ];
    }

    protected function teacherStats(User $user): array
    {
        $teacher = Teacher::where('school_id', $user->school_id)
            ->where('email', $user->email)
            ->first();

        return [
            'school' => $user->school,
            'teacher' => $teacher,
            'assignments' => $teacher
                ? $teacher->assignments()->where('is_active', true)->count()
                : 0,
        ];
    }

    protected function studentStats(User $user): array
    {
        return [
            'school' => $user->school,
            'user' => $user,
        ];
    }
}
