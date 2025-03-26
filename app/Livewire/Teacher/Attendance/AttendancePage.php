<?php

namespace App\Livewire\Teacher\Attendance;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Masmerise\Toaster\Toaster;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttendancePage extends Component
{
    public $year, $month, $grade;
    public $students = [];
    public $attendance = [];
    public $grades = [];

    public function mount()
    {
        $this->grades = Grade::all();
    }

    /**
     * @return void
     */
    public function fetchStudents(): void
    {
        if($this->year && $this->month && $this->grade) {
            $this->students = Student::where('grade_id', $this->grade)->get();
            // Generate days in a month
            foreach($this->students as $student) {
                foreach(range(1, Carbon::create($this->year, $this->month)->daysInMonth) as $day) {
                    $date = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');
                    $this->attendance[$student->id][$day] = Attendance::where('student_id', $student->id)
                        ->whereDate('date', $date)
                        ->value('status') ?? 'present';
                }
            }
        }
    }

    public function updateAttendance($studentId, $day, $status): void
    {
        $date = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');

        Attendance::updateOrCreate(
            ['student_id' => $studentId, 'date' => $date],
            [
                'status' => $status,
                'grade_id' => $this->grade,
            ]);

        // Sync the state of stauts
        $this->attendance[$studentId][$day] = $status;

        Toaster::success('Attendance for date: ' . $date .' for studentID ' . $studentId . ' was updated successfully');
    }

    public function markAll($day, $status): void
    {
        foreach($this->students as $student) {
            $this->updateAttendance($student->id, $day, $status);
        }
    }

    public function exportToExcel(): BinaryFileResponse
    {
        return Excel::download( new AttendanceExport($this->year, $this->month, $this->grade), 'attendance.xlsx');
    }

    public function render(): View
    {
        return view('livewire.teacher.attendance.attendance-page', [
            'daysInMonth' => carbon::create($this->year, $this->month)->daysInMonth,
        ]);
    }
}
