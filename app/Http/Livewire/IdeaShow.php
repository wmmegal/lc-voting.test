<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public object $idea;
    public int $votesCount;
    public bool $hasVoted;

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea       = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted   = $idea->isVotedByUser(auth()->user());
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
