<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminComponent extends Component
{
    use WithPagination ,WithFileUploads;
    protected $paginationTheme = 'bootstrap';


}