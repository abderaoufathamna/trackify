@extends('layouts.admin')

@section('title', 'All Attendances')

@section('content')

    <h2>All Attendances</h2>

    <table border="1">
        <tr>
            <th>Student</th>
            <th>Module</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

        @forelse ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->student->user->full_name }}</td>
                <td>{{ $attendance->module->name }}</td>
                <td style="color: red;">{{ $attendance->status }}</td>
                <td>{{ $attendance->date->format('Y-m-d') }}</td>
            </tr>
        @empty
            <tr><td colspan="4">No attendance yet.</td></tr>
        @endforelse
    </table>

    <br><hr><br>

    <h2>Absences by Module</h2>

    <table border="1">
        <tr>
            <th>Module</th>
            <th>Absences</th>
        </tr>

        @forelse ($absencesByModule as $module)
            <tr>
                <td>{{ $module->name }}</td>
                <td>{{ $module->absences_count }}</td>
            </tr>
        @empty
            <tr><td colspan="2">No modules yet.</td></tr>
        @endforelse
    </table>

@endsection