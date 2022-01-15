<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class MarkIdeaAsSpam extends Component
{
    public Idea $idea;

    public function markAsSpam()
    {
        if (auth()->guest()) {
            abort(403);
        }

        $this->idea->spam_reports++;
        $this->idea->save();

        $this->emit('ideaWasMarkedAsSpam');
    }

    public function render()
    {
        return view('livewire.mark-idea-as-spam');
    }
}
