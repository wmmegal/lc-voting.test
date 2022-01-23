<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Livewire\Component;

class AddComment extends Component
{
    public Idea $idea;
    public $comment;
    protected $rules = [
        'comment' => 'required|min:4'
    ];

    public function addComment()
    {
        if (auth()->guest()) {
            abort(403);
        }

        $this->validate();

        Comment::create([
            'idea_id' => $this->idea->id,
            'user_id' => auth()->user()->id,
            'body' => $this->comment
        ]);

        $this->reset('comment');

        $this->emit('commentWasAdded', 'Comment was posted!');
    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}
