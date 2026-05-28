<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'name' => 'About Us',
                'meta_title' => 'About Us | Ratnavriksha',
                'label' => 'About Us',
                'heading' => "Our Legacy.\nOur Commitment.",
                'description' => 'At Ratnavriksha, we believe a diamond is more than a gem – it\'s a promise, a memory, and a legacy for generations.',
                'status' => 'active',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'name' => 'Contact Us',
                'meta_title' => 'Contact Us | Ratnavriksha',
                'label' => 'Contact Us',
                'heading' => "Get In Touch.\nWe're Here to Help.",
                'description' => 'Reach out to our team for diamond enquiries, partnerships, or any questions about Ratnavriksha.',
                'status' => 'active',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'diamonds'],
            [
                'name' => 'Diamonds',
                'meta_title' => 'Diamonds | Ratnavriksha',
                'label' => 'Diamonds',
                'heading' => "Find Your\nPerfect Diamond",
                'description' => 'Explore our curated range of natural diamonds across shapes, colors, cuts, and clarities.',
                'status' => 'active',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'blogs'],
            [
                'name' => 'Blogs',
                'meta_title' => 'Blogs | Ratnavriksha',
                'label' => 'Blogs',
                'heading' => "Insights\n& Stories",
                'description' => 'Read expert articles, buying guides, and diamond knowledge from our team.',
                'status' => 'active',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'news-events'],
            [
                'name' => 'News & Events',
                'meta_title' => 'News & Events | Ratnavriksha',
                'label' => 'News & Events',
                'heading' => "Latest News\n& Events",
                'description' => 'Stay updated with announcements, launches, and upcoming events from Ratnavriksha.',
                'status' => 'active',
            ]
        );
    }
}
