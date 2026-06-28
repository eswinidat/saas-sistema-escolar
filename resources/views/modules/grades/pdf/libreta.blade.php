<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1a1a1a; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 8px; margin-bottom: 12px; }
        .school { font-size: 14px; font-weight: bold; color: #1e40af; }
        .subtitle { font-size: 11px; color: #555; }
        .section { margin: 12px 0; }
        .section-title { background: #eff6ff; padding: 5px 8px; font-weight: bold; color: #1e40af; border-left: 3px solid #2563eb; margin-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 5px 6px; }
        th { background: #f8fafc; font-size: 9px; }
        .info-grid td { border: none; padding: 2px 4px; }
        .info-label { font-weight: bold; width: 120px; color: #475569; }
        .level-ad { color: #059669; font-weight: bold; }
        .level-a { color: #2563eb; font-weight: bold; }
        .level-b { color: #d97706; font-weight: bold; }
        .level-c { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; font-size: 9px; }
        .signatures { margin-top: 30px; }
        .signatures td { border: none; text-align: center; width: 33%; padding-top: 30px; }
        .sign-line { border-top: 1px solid #333; display: inline-block; width: 80%; padding-top: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="school">{{ $school->name ?? 'Institución Educativa' }}</div>
        <div class="subtitle">RUC: {{ $school->ruc ?? '—' }} · {{ $school->address ?? '' }}</div>
        <div class="subtitle" style="margin-top:6px; font-size:12px; font-weight:bold;">INFORME DE PROGRESO — LIBRETA DE NOTAS</div>
        <div class="subtitle">{{ $period->name }} · Año escolar {{ $period->academicYear->year ?? '' }}</div>
    </div>

    <div class="section">
        <table class="info-grid">
            <tr>
                <td class="info-label">Apellidos y nombres:</td>
                <td><strong>{{ $student->fullName() }}</strong></td>
                <td class="info-label">DNI:</td>
                <td>{{ $student->document_number }}</td>
            </tr>
            <tr>
                <td class="info-label">Grado y sección:</td>
                <td>
                    @if($enrollment)
                        {{ $enrollment->section->grade->level->name ?? '' }}
                        {{ $enrollment->section->grade->name ?? '' }} — {{ $enrollment->section->name ?? '' }}
                    @else
                        —
                    @endif
                </td>
                <td class="info-label">Turno:</td>
                <td>{{ $enrollment->section->turn->name ?? '—' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">CALIFICACIONES POR COMPETENCIAS (MINEDU)</div>
        @forelse($grades as $courseName => $courseGrades)
            <p style="font-weight:bold; margin:8px 0 4px; color:#334155;">{{ $courseName }}</p>
            <table style="margin-bottom:10px;">
                <thead>
                    <tr>
                        <th>Competencia</th>
                        <th width="60">Calif.</th>
                        <th width="50">Num.</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseGrades as $grade)
                        <tr>
                            <td>{{ $grade->competency->name ?? '—' }}</td>
                            <td style="text-align:center;" class="level-{{ strtolower($grade->achievement_level ?? '') }}">
                                {{ $grade->achievement_level ?? '—' }}
                            </td>
                            <td style="text-align:center;">{{ $grade->numeric_grade ?? '—' }}</td>
                            <td>{{ $grade->observations ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @empty
            <p style="color:#888;">Sin calificaciones registradas para este periodo.</p>
        @endforelse
    </div>

    <div class="section">
        <div class="section-title">RESUMEN DE ASISTENCIA</div>
        <table>
            <tr>
                <th>Presente</th><th>Falta</th><th>Tardanza</th><th>Justificada</th><th>Total días</th>
            </tr>
            <tr style="text-align:center;">
                <td>{{ $attendance['present'] ?? 0 }}</td>
                <td>{{ $attendance['absent'] ?? 0 }}</td>
                <td>{{ $attendance['late'] ?? 0 }}</td>
                <td>{{ $attendance['justified'] ?? 0 }}</td>
                <td>{{ $attendance['total'] ?? 0 }}</td>
            </tr>
        </table>
    </div>

    <div class="section" style="font-size:9px; color:#64748b;">
        <strong>Escala de calificación:</strong>
        AD = Logro destacado · A = Logro esperado · B = En proceso · C = En inicio
    </div>

    <table class="signatures">
        <tr>
            <td><div class="sign-line">Tutor(a)</div></td>
            <td><div class="sign-line">Director(a)</div></td>
            <td><div class="sign-line">Apoderado</div></td>
        </tr>
    </table>

    <div class="footer" style="text-align:center;">
        Documento generado el {{ now()->format('d/m/Y H:i') }} — {{ $school->name ?? '' }}
    </div>
</body>
</html>
