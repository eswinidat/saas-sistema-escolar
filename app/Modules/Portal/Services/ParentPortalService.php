<?php

namespace App\Modules\Portal\Services;

use App\Models\User;
use App\Modules\Enrollment\Models\Guardian;
use App\Modules\Enrollment\Models\Student;
use Illuminate\Support\Collection;

class ParentPortalService
{
    public function guardianForUser(User $user): ?Guardian
    {
        return Guardian::where('user_id', $user->id)->first();
    }

    public function studentsForUser(User $user): Collection
    {
        $guardian = $this->guardianForUser($user);

        if (! $guardian) {
            return collect();
        }

        if ($user->school_id) {
            app()->instance('current_school_id', $user->school_id);
        }

        return $guardian->students()
            ->with(['enrollments.section.grade', 'enrollments.academicYear'])
            ->get();
    }

    public function selectedStudent(User $user, ?int $studentId = null): ?Student
    {
        $students = $this->studentsForUser($user);

        if ($students->isEmpty()) {
            return null;
        }

        if ($studentId) {
            return $students->firstWhere('id', $studentId);
        }

        return $students->first();
    }
}
