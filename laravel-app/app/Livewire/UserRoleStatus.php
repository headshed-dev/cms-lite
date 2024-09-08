<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserRoleStatus extends Component
{

    public function currentUserHasRoles()
    {
        $current_user = Auth::user();

        $user = User::find($current_user->id);

        $roles = $user->getRoleNames()->count();

        if ($roles > 0) {
            return true;
        } else {
            return false;
        }
    }



    public function render()
    {
        return view('livewire.user-role-status', [
            'currentUserHasRoles' => $this->currentUserHasRoles(),
        ]);
    }


}
