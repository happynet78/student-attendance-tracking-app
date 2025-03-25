<?php

namespace App\Livewire\Teacher\Student;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

#[Title('Student Attendance | Student List')]
class StudentList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public function delete($id)
    {
        Student::find($id)->delete();
        Toaster::success('student deleted successfully!');

        return redirect()->route('student.index');
    }

    public function render(): View
    {
        return view('livewire.teacher.student.student-list', [
             'students' => Student::orderBy('created_at', 'DESC')->paginate(5)
        ]);
    }
}
