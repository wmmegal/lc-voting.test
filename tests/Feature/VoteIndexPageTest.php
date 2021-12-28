<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoteIndexPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_contains_idea_index_livewire_component()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $this->get(route('idea.index'))
            ->assertSeeLivewire('idea-index');
    }

    public function test_index_page_correctly_receives_votes_count()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $userB->id
        ]);

        $this->get(route('idea.index'))
            ->assertViewHas('ideas', function ($ideas) {
                return (int) $ideas->first()->votes_count === 2;
            });
    }

	public function test_user_who_is_logged_in_shows_voted_if_idea_already_voted_for()
	{
		$user = User::factory()->create();

		$categoryOne = Category::factory()->create(['name' => 'Category 1']);

		$statusOpen = Status::factory()->create(['name' => 'Open']);

		$idea = Idea::factory()->create([
			'user_id' => $user->id,
			'category_id' => $categoryOne->id,
			'status_id' => $statusOpen->id,
			'title' => 'My First Idea',
			'description' => 'Description for my first idea',
		]);

		Vote::factory()->create([
			'idea_id' => $idea->id,
			'user_id' => $user->id,
		]);

		Livewire::actingAs($user)
		        ->test(IdeaIndex::class, [
			        'idea' => $idea,
			        'votesCount' => 5,
		        ])
		        ->assertSet('hasVoted', true)
		        ->assertSee('Voted');
	}
}
