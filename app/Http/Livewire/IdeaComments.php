<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;

class IdeaComments extends Component
{
    use WithPagination;

    public Idea $idea;
    protected $listeners = ['commentWasAdded'];

    public function commentWasAdded()
    {
        $this->idea->refresh();
        $this->gotoPage($this->idea->comments()->paginate()->lastPage());
    }

    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => Comment::with('user')->where('idea_id', $this->idea->id)->paginate()->withQueryString()
        ]);
    }
}
