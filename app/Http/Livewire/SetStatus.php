<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyAllVoters;
use App\Mail\IdeaStatusUpdateMailable;
use App\Models\Idea;
use Livewire\Component;
use Mail;
use Symfony\Component\HttpFoundation\Response;

class SetStatus extends Component
{
    public Idea $idea;
    public $status;
    public $notifyAllVoters;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function setStatus()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if ($this->notifyAllVoters) {
            NotifyAllVoters::dispatch($this->idea);
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        $this->emit('statusWasUpdated', 'Status was updated successfully!');
    }


    public function render()
    {
        return view('livewire.set-status');
    }
}
