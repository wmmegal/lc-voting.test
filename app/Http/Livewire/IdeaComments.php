<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaComments extends Component
{
    public Idea $idea;

    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => $this->idea->comments
        ]);
    }
}
