<?php

namespace App\Livewire\Teacher\Grade;

use App\Models\Grade;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Student Attendance | Edit Grade')]
class EditGrade extends Component
{
    public $name = '';
    public $grade_details;

    public function mount($id): void
    {
        $this->grade_details = Grade::find($id);

        $this->fill([
            'name' => $this->grade_details->name,
        ]);
    }

    public function update(){
        $this->validate([
            'name' => 'required|string',
        ]);

        Grade::find($this->grade_details->id)->update([
            'name' => $this->name,
        ]);

        Toaster::success('grade updated successfully!');
        return redirect()->route('grade.index');
    }

    public function render()
    {
        return view('livewire.teacher.grade.edit-grade');
    }
}
