<?php

namespace Database\Factories;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(mt_rand(3, 6)),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['title']);
            },
            'content' => $this->faker->paragraphs(mt_rand(3, 10), true),
            'meta_description' => $this->faker->sentence(mt_rand(10, 20)),
            'meta_keywords' => implode(',', $this->faker->words(mt_rand(3, 6))),
            'featured_image' => $this->faker->randomElement(['portfolio_03.jpeg', 'portfolio_02.jpeg', 'portfolio_01.jpeg']),
            'status' => $this->faker->randomElement(['published', 'draft', 'archived']),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_id' => 1,
            'category_id' => $this->faker->numberBetween(1, 8),
        ];
    }
}
