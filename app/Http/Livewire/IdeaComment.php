<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class IdeaComment extends Component
{
    public Comment $comment;
    public int $ideaUserId;

    protected $listeners = [
        'commentWasUpdated' => 'refreshComment',
        'commentWasMarkedAsSpam' => 'refreshComment',
        'commentWasMarkedAsNotSpam' => 'refreshComment',
    ];

    public function refreshComment()
    {
        $this->comment->refresh();
    }

    public function mount(Comment $comment, $ideaUserId)
    {
        $this->comment = $comment;
        $this->ideaUserId = $ideaUserId;
    }

    public function render()
    {
        return view('livewire.idea-comment');
    }
}
