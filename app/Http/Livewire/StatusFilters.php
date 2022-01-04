<?php

namespace App\Http\Livewire;

use App\Models\Status;
use Livewire\Component;
use Route;

class StatusFilters extends Component
{
    public string $status = 'All';
    public array $statusCount;

    protected $queryString = [
        'status'
    ];

    public function mount()
    {
        $this->statusCount = Status::getCount();

        if (Route::currentRouteName() == 'idea.show') {
            $this->status = '';
            $this->queryString = [];
        }
    }

    public function setStatus($newStatus)
    {
        $this->status = $newStatus;

        return redirect()->route('idea.index', [
            'status' => $this->status
        ]);
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
