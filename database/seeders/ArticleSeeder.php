<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $pages = [
            [
                'id' => 1,
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => 'Example content for the privacy policy page. This should include details about how user data is collected, used, and protected.',
                'type' => 'page',
                'author_id' => 1,
                'status' => 'published',
                'meta_description' => 'Learn about how we collect, use, and protect your personal information.',
            ],
            [
                'id' => 2,
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => 'Example content for the terms of service page. This should outline the rules and guidelines for using the website and services.',
                'type' => 'page',
                'author_id' => 1,
                'status' => 'published',
                'meta_description' => 'Read our terms and conditions for using our website and services.',
            ],
            [
                'id' => 3,
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'content' => 'Example content for the cookie policy page. This should explain how cookies and similar technologies are used on the website.',
                'type' => 'page',
                'author_id' => 1,
                'status' => 'published',
                'meta_description' => 'Understand how we use cookies and similar technologies on our website.',
            ],
            [
                'id' => 4,
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => 'Example content for the about us page. This should provide information about the company, its mission, and its team.',
                'type' => 'page',
                'author_id' => 1,
                'status' => 'published',
                'meta_description' => 'Learn more about our company, mission, and team.',
            ]
        ];

        foreach ($pages as $page) {
            Article::create($page);
        }
    }
}
