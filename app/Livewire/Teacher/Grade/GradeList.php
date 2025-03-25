<?php

namespace App\Livewire\Teacher\Grade;

use App\Models\Grade;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use function Livewire\Volt\title;

#[Title('Student Attendance | Grade List')]
class GradeList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'simple-tailwind';

    public function delete($id)
    {
        Grade::find($id)->delete();
        Toaster::success('Grade Deleted Successfully');
        return redirect()->route('grade.index');
    }

    public function render()
    {
        return view('livewire.teacher.grade.grade-list', [
            'grades' => Grade::orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }
}
