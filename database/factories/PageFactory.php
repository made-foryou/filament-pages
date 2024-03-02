<?php

namespace MadeForYou\FilamentPages\Database\Factories;

use MadeForYou\FilamentPages\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PageFactory extends Factory
{
	protected $model = Page::class;

	public function definition(): array
	{
		return [
			'name' => $this->faker->name(),
            'summary' => $this->faker->paragraph(),
			'content' => '[]',
		];
	}
}
