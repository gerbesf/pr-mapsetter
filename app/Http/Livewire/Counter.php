<?php

namespace App\Http\Livewire;

use App\EtcLocker;
use App\Models\SetLocker;
use Carbon\Carbon;
use Livewire\Component;

class Counter extends Component
{

    public $minuted,$secondd;

    public $lock;

    public $seconds = 0;
/*
    public function mount($minuted, $second){
        $this->minuted = $minuted;
        $this->secondd = $second;
    }*/

    public function mount( $id ){
        $this->lock = SetLocker::where('id',$id)->first();



        /* if(Carbon::parse($this->lock->created_at)->addMinutes(  env('VOTE_TIME') )->isPast()){
             SetLocker::where('id',$id)->update([
                 'status' => 'expired'
             ]);
             $EtcLocker = new EtcLocker();
             $EtcLocker->discordAbandouVote($lock);
             return redirect('/');
         }*/
    }

    public function redirectEXtp(){
        return redirect(url('/'));
    }

    public function render()
    {


        if(isset($this->lock->status) && $this->lock->status=="expired"){
           # return redirect('/');
           # dd('Expirado');
       #     return redirect('/');
        }

        if($this->lock){
            $this->minuted = Carbon::createFromFormat('Y-m-d H:i:s',$this->lock->created_at)->addMinutes( env('VOTE_TIME'))->diffInMinutes();
            $this->secondd = Carbon::createFromFormat('Y-m-d H:i:s',$this->lock->created_at)->addMinutes( env('VOTE_TIME') )->subMinutes( $this->minuted )->diffInSeconds();
        }

        if( Carbon::createFromFormat('Y-m-d H:i:s',$this->lock->created_at)->addMinutes( env('VOTE_TIME'))->isPast() ){

            SetLocker::where('id',$this->lock->id)->update([
                'status' => 'expired'
            ]);
            $EtcLocker = new EtcLocker();
            $EtcLocker->discordAbandouVote($this->lock);
            $this->redirectEXtp();
        }
        $this->seconds = Carbon::createFromFormat('Y-m-d H:i:s',$this->lock->created_at)->addMinutes( env('VOTE_TIME'))->diffInSeconds();

        return view('livewire.counter');
    }
}
