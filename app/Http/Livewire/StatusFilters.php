<?php

namespace App\Http\Livewire;

use App\Models\Status;
use Livewire\Component;
use Route;

class StatusFilters extends Component
{
    public string $status;
    public array $statusCount;


    public function mount()
    {
        $this->statusCount = Status::getCount();
        $this->status = request()->status ?? 'All';

        if (Route::currentRouteName() == 'idea.show') {
            $this->status = '';
        }
    }

    public function setStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->emit('queryStringUpdatedStatus', $this->status);

        if ($this->getPreviousRouteName() === 'idea.show') {
            return redirect()->route('idea.index', [
                'status' => $this->status,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.status-filters');
    }

    private function getPreviousRouteName()
    {
        return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
    }
}
