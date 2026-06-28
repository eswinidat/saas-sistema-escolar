<?php

namespace Database\Seeders;

use App\Models\School;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Enrollment\Models\Guardian;
use App\Modules\Enrollment\Models\Student;
use App\Modules\Settings\Models\AcademicYear;
use App\Modules\Settings\Models\Grade;
use App\Modules\Settings\Models\Level;
use App\Modules\Settings\Models\Section;
use App\Modules\Settings\Models\Turn;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::where('ruc', '20123456789')->first();

        if (! $school) {
            return;
        }

        app()->instance('current_school_id', $school->id);

        $year = AcademicYear::firstOrCreate(
            ['school_id' => $school->id, 'year' => '2026'],
            [
                'start_date' => '2026-03-01',
                'end_date' => '2026-12-15',
                'is_active' => true,
            ]
        );

        $levelPrimary = Level::firstOrCreate(
            ['school_id' => $school->id, 'name' => 'Primaria'],
            ['code' => 'PRI', 'order' => 2, 'is_active' => true]
        );

        $levelInitial = Level::firstOrCreate(
            ['school_id' => $school->id, 'name' => 'Inicial'],
            ['code' => 'INI', 'order' => 1, 'is_active' => true]
        );

        $grade1 = Grade::firstOrCreate(
            ['school_id' => $school->id, 'level_id' => $levelPrimary->id, 'name' => '1ro'],
            ['order' => 1, 'is_active' => true]
        );

        Grade::firstOrCreate(
            ['school_id' => $school->id, 'level_id' => $levelPrimary->id, 'name' => '2do'],
            ['order' => 2, 'is_active' => true]
        );

        Grade::firstOrCreate(
            ['school_id' => $school->id, 'level_id' => $levelInitial->id, 'name' => '3 años'],
            ['order' => 1, 'is_active' => true]
        );

        $turnMorning = Turn::firstOrCreate(
            ['school_id' => $school->id, 'name' => 'Mañana'],
            ['start_time' => '07:30', 'end_time' => '13:00', 'is_active' => true]
        );

        Turn::firstOrCreate(
            ['school_id' => $school->id, 'name' => 'Tarde'],
            ['start_time' => '13:00', 'end_time' => '18:30', 'is_active' => true]
        );

        $section = Section::firstOrCreate(
            [
                'school_id' => $school->id,
                'grade_id' => $grade1->id,
                'academic_year_id' => $year->id,
                'name' => 'A',
            ],
            [
                'turn_id' => $turnMorning->id,
                'capacity' => 30,
                'tutor_name' => 'Prof. García',
                'is_active' => true,
            ]
        );

        $student = Student::firstOrCreate(
            ['school_id' => $school->id, 'document_number' => '71234567'],
            [
                'document_type' => 'DNI',
                'first_name' => 'María',
                'last_name' => 'López',
                'middle_name' => 'Quispe',
                'birth_date' => '2015-04-12',
                'gender' => 'F',
                'status' => 'active',
            ]
        );

        $guardian = Guardian::firstOrCreate(
            ['school_id' => $school->id, 'document_number' => '45678901'],
            [
                'document_type' => 'DNI',
                'first_name' => 'Carlos',
                'last_name' => 'López',
                'middle_name' => 'Vargas',
                'phone' => '999888777',
                'is_economic_responsible' => true,
            ]
        );

        if (! $student->guardians()->where('guardian_id', $guardian->id)->exists()) {
            $student->guardians()->attach($guardian->id, [
                'relationship' => 'padre',
                'is_primary' => true,
                'is_economic_responsible' => true,
            ]);
        }

        Enrollment::firstOrCreate(
            ['student_id' => $student->id, 'academic_year_id' => $year->id],
            [
                'school_id' => $school->id,
                'section_id' => $section->id,
                'turn_id' => $turnMorning->id,
                'enrollment_number' => 'MAT-2026-001',
                'enrollment_date' => now()->toDateString(),
                'type' => 'new',
                'status' => 'active',
            ]
        );

        $teacher = \App\Modules\Academic\Models\Teacher::firstOrCreate(
            ['school_id' => $school->id, 'document_number' => '12345678'],
            [
                'document_type' => 'DNI',
                'first_name' => 'Ana',
                'last_name' => 'García',
                'middle_name' => 'Ruiz',
                'specialty' => 'Matemática',
                'email' => 'ana.garcia@sanmartin.edu.pe',
                'phone' => '999111222',
                'status' => 'active',
            ]
        );

        $courseMath = \App\Modules\Academic\Models\Course::firstOrCreate(
            ['school_id' => $school->id, 'code' => 'MAT'],
            [
                'grade_id' => $grade1->id,
                'name' => 'Matemática',
                'hours_per_week' => 5,
                'is_active' => true,
            ]
        );

        \App\Modules\Academic\Models\Course::firstOrCreate(
            ['school_id' => $school->id, 'code' => 'COM'],
            [
                'grade_id' => $grade1->id,
                'name' => 'Comunicación',
                'hours_per_week' => 5,
                'is_active' => true,
            ]
        );

        \App\Modules\Academic\Models\TeacherAssignment::firstOrCreate(
            [
                'teacher_id' => $teacher->id,
                'course_id' => $courseMath->id,
                'section_id' => $section->id,
                'academic_year_id' => $year->id,
            ],
            [
                'school_id' => $school->id,
                'hours_per_week' => 5,
                'is_active' => true,
            ]
        );

        \App\Modules\Academic\Models\Schedule::firstOrCreate(
            [
                'section_id' => $section->id,
                'course_id' => $courseMath->id,
                'teacher_id' => $teacher->id,
                'day_of_week' => 1,
                'start_time' => '08:00',
            ],
            [
                'school_id' => $school->id,
                'academic_year_id' => $year->id,
                'end_time' => '09:30',
                'classroom' => 'A-101',
            ]
        );

        \App\Modules\Attendance\Models\AttendanceRecord::firstOrCreate(
            ['student_id' => $student->id, 'date' => now()->toDateString()],
            [
                'school_id' => $school->id,
                'section_id' => $section->id,
                'academic_year_id' => $year->id,
                'status' => 'present',
                'check_in_time' => '07:45',
                'check_out_time' => '13:00',
            ]
        );

        $period = \App\Modules\Grades\Models\GradingPeriod::firstOrCreate(
            ['academic_year_id' => $year->id, 'number' => 1],
            [
                'school_id' => $school->id,
                'name' => 'I Bimestre',
                'type' => 'bimester',
                'start_date' => '2026-03-01',
                'end_date' => '2026-04-30',
                'is_active' => true,
            ]
        );

        $competency = \App\Modules\Grades\Models\Competency::firstOrCreate(
            ['school_id' => $school->id, 'course_id' => $courseMath->id, 'code' => 'MAT-C1'],
            ['name' => 'Resuelve problemas de cantidad', 'order' => 1, 'is_active' => true]
        );

        \App\Modules\Grades\Models\Capability::firstOrCreate(
            ['competency_id' => $competency->id, 'name' => 'Traduce cantidades a expresiones numéricas'],
            ['order' => 1]
        );

        \App\Modules\Grades\Models\StudentGrade::firstOrCreate(
            [
                'student_id' => $student->id,
                'course_id' => $courseMath->id,
                'grading_period_id' => $period->id,
                'competency_id' => $competency->id,
                'capability_id' => null,
            ],
            [
                'school_id' => $school->id,
                'achievement_level' => 'A',
                'numeric_grade' => 16,
                'observations' => 'Buen desempeño',
            ]
        );

        $pensionConcept = \App\Modules\Treasury\Models\PaymentConcept::firstOrCreate(
            ['school_id' => $school->id, 'code' => 'PEN'],
            [
                'name' => 'Pensión mensual',
                'type' => 'pension',
                'default_amount' => 350.00,
                'is_recurring' => true,
                'is_active' => true,
            ]
        );

        $charge = \App\Modules\Treasury\Models\StudentCharge::firstOrCreate(
            [
                'student_id' => $student->id,
                'payment_concept_id' => $pensionConcept->id,
                'period_label' => 'Marzo 2026',
            ],
            [
                'school_id' => $school->id,
                'academic_year_id' => $year->id,
                'amount' => 350.00,
                'paid_amount' => 200.00,
                'due_date' => now()->subDays(5)->toDateString(),
                'status' => 'partial',
            ]
        );

        \App\Modules\Treasury\Models\Payment::firstOrCreate(
            ['student_id' => $student->id, 'receipt_number' => 'REC-2026-001'],
            [
                'school_id' => $school->id,
                'student_charge_id' => $charge->id,
                'amount' => 200.00,
                'payment_date' => now()->subDays(10)->toDateString(),
                'payment_method' => 'transfer',
            ]
        );

        $payment = \App\Modules\Treasury\Models\Payment::where('receipt_number', 'REC-2026-001')->first();
        $director = \App\Models\User::where('email', 'director@sanmartin.edu.pe')->first();

        \App\Modules\Billing\Models\SunatSetting::firstOrCreate(
            ['school_id' => $school->id],
            [
                'business_name' => $school->name,
                'ruc' => $school->ruc,
                'address' => $school->address,
                'boleta_series' => 'B001',
                'factura_series' => 'F001',
                'nota_credito_series' => 'FC01',
                'ose_provider' => 'demo',
                'is_production' => false,
                'is_active' => true,
            ]
        );

        if ($payment && $director) {
            $doc = \App\Modules\Billing\Models\ElectronicDocument::firstOrCreate(
                ['school_id' => $school->id, 'full_number' => 'B001-00000001'],
                [
                    'payment_id' => $payment->id,
                    'student_id' => $student->id,
                    'document_type' => '03',
                    'series' => 'B001',
                    'number' => 1,
                    'issue_date' => $payment->payment_date,
                    'customer_doc_type' => '1',
                    'customer_doc_number' => $guardian->document_number,
                    'customer_name' => $guardian->fullName(),
                    'subtotal' => round(200 / 1.18, 2),
                    'igv' => round(200 - (200 / 1.18), 2),
                    'total' => 200.00,
                    'status' => 'accepted',
                    'sunat_hash' => strtoupper(\Illuminate\Support\Str::random(40)),
                    'qr_data' => implode('|', [$school->ruc, '03', 'B001', 1, number_format(round(200 - (200 / 1.18), 2), 2, '.', ''), '200.00', $payment->payment_date->format('Y-m-d'), '1', $guardian->document_number]),
                    'sunat_response' => 'Comprobante aceptado (modo demo).',
                    'issued_by' => $director->id,
                    'sent_at' => now(),
                ]
            );

            \App\Modules\Billing\Models\ElectronicDocumentItem::firstOrCreate(
                ['electronic_document_id' => $doc->id, 'line' => 1],
                [
                    'description' => 'Pensión mensual — Marzo 2026',
                    'quantity' => 1,
                    'unit_price' => 200.00,
                    'subtotal' => round(200 / 1.18, 2),
                    'igv' => round(200 - (200 / 1.18), 2),
                    'total' => 200.00,
                ]
            );
        }

        $padreUser = \App\Models\User::firstOrCreate(
            ['email' => 'padre@sanmartin.edu.pe'],
            [
                'name' => 'Carlos López (Apoderado)',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
            ]
        );
        $padreUser->syncRoles(['Padre']);
        $guardian->update(['user_id' => $padreUser->id]);

        $superAdmin = \App\Models\User::where('email', 'admin@sistema.edu.pe')->first();
        $director = \App\Models\User::where('email', 'director@sanmartin.edu.pe')->first();

        if ($superAdmin && $director) {
            $chat = app(\App\Services\ChatService::class);
            $conversation = $chat->findOrCreateDirect($superAdmin, $director);
            $chat->send($conversation, $director, 'Hola, necesitamos activar facturación SUNAT para el colegio.');
            $chat->send($conversation, $superAdmin, '¡Hola! Claro, revisa Facturación → Configuración SUNAT en modo demo. Estoy disponible para cualquier consulta.');
        }
    }
}
