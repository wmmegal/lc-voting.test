<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public Idea $idea;
    public int $votesCount;
    public bool $hasVoted;

    protected $listeners = [
        'statusWasUpdated' => 'ideaRefresh',
        'ideaWasUpdated' => 'ideaRefresh',
        'ideaWasMarkedAsSpam' => 'ideaRefresh',
        'ideaWasMarkedAsNotSpam' => 'ideaRefresh',
        'commentWasAdded' => 'ideaRefresh',
        'commentWasDeleted' => 'ideaRefresh',
    ];

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function ideaRefresh()
    {
        $this->idea->refresh();
    }

    public function vote()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        if ($this->hasVoted) {
            $this->idea->removeVote(auth()->user());
            $this->votesCount--;
            $this->hasVoted = false;
        } else {
            $this->idea->vote(auth()->user());
            $this->votesCount++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
