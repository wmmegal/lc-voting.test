<?php

namespace Filters;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryFiltersTest extends TestCase
{
    use RefreshDatabase;


    public function test_selecting_a_category_filters_correctly()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        Idea::factory()->create([
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->category->name === 'Category 1';
            });

        Livewire::withQueryParams(['category' => 'Category 1'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->category->name === 'Category 1';
            });
    }


    public function test_selecting_a_status_and_a_category_filters_correctly()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
        ]);

        Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
        ]);

        Idea::factory()->create([
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
        ]);

        Idea::factory()->create([
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('status', 'Open')
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->category->name === 'Category 1'
                    && $ideas->first()->status->name === 'Open';
            });

        Livewire::withQueryParams(['status' => 'Open', 'category' => 'Category 1'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->category->name === 'Category 1'
                    && $ideas->first()->status->name === 'Open';
            });
    }


    public function test_selecting_all_categories_filters_correctly()
    {
        Idea::factory(3)->create();

        Livewire::test(IdeasIndex::class)
            ->set('category', 'All Categories')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 3;
            });
    }
}
