<?php

namespace App\Livewire\Teacher\Grade;

use App\Models\Grade;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use function Livewire\Volt\title;

#[Title('Student Attendance | Add Grade')]
class AddGrade extends Component
{
    public $name = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
        ]);

        Grade::create([
            'name' => $this->name,
        ]);

        $this->reset('name');

        Toaster::success('Grade added successfully');

        return redirect()->route('grade.index');
    }

    public function render()
    {
        return view('livewire.teacher.grade.add-grade');
    }
}
