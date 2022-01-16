<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class MarkIdeaAsNotSpam extends Component
{
    public Idea $idea;

    public function markAsNotSpam()
    {
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $this->idea->spam_reports = 0;
        $this->idea->save();

        $this->emit('ideaWasMarkedAsNotSpam', 'Spam Counter was reset!');
    }

    public function render()
    {
        return view('livewire.mark-idea-as-not-spam');
    }
}
