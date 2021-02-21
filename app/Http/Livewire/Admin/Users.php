<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Users extends Component
{


    // Form Inputs
    public $form_nickname;
    public $form_username;
    public $form_password;
    public $form_level;
    public $form_hash;

    public $form = false;
    public $action = false;

    // Entity Update
    public $id_entity;

    public function viewEntity( $id ){
        $this->form = true;
        $this->action = 'modify';
        $entity = Admin::where('id',$id)->first();
        $this->id_entity = $entity->id;
        $this->form_username = $entity->username;
        $this->form_nickname = $entity->nickname;
        $this->form_level = $entity->level;
        $this->form_hash = $entity->hash;
    }

    public function updateEntity(){
        Admin::where('id',$this->id_entity)->update([
            'nickname' => $this->form_nickname,
            'username' => $this->form_username,
            'hash' => $this->form_hash,
        ]);
        $this->backTable();
    }

    public function createForm(){
        $this->form = true;
        $this->action = 'create';
        $this->form_level = 'M';
    }

    public function createEntity(){
        Admin::create([
            'nickname' => $this->form_nickname,
            'username' => $this->form_username,
            'password' => Hash::make($this->form_password),
            'level' => $this->form_level,
            'hash' => $this->form_hash,
        ]);
        $this->backTable();
    }

    public function removeAdmin( $id ){
        Admin::where('id',$id)->delete();
    }

    public function backTable(){
        $this->form=false;
        $this->action=false;
    }

    public function render()
    {

        $Users = Admin::get();

        return view('livewire.admin.users',[
            'users' => $Users
        ]);
    }
}
