<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.auth')]
#[Title('Daftar Akun Baru - Talksy.id')]
class RegisterPage extends Component
{
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
