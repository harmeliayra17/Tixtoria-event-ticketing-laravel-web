<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@tixtoria.com'],
            [
                'name' => 'Diana Prince',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'profile' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&auto=format&fit=crop&q=80',
            ]
        );

        $organizer = User::updateOrCreate(
            ['email' => 'organizer@tixtoria.com'],
            [
                'name' => 'Johnathan Miller',
                'password' => Hash::make('password'),
                'role' => 'organizer',
                'profile' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150&auto=format&fit=crop&q=80',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@tixtoria.com'],
            [
                'name' => 'Alice Cooper',
                'password' => Hash::make('password'),
                'role' => 'user',
                'profile' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&auto=format&fit=crop&q=80',
            ]
        );

        // 2. Seed Categories
        $categoriesList = [
            'Entertainment and Arts',
            'Education and Seminar',
            'Sports and Health',
            'Culture and Traditions',
            'Business and Networking',
            'Children and Family',
            'Technology and Science',
            'Lifestyle and Community',
        ];

        $categories = [];
        foreach ($categoriesList as $catName) {
            $categories[$catName] = Category::updateOrCreate(
                ['name' => $catName]
            );
        }

        // 3. Seed Locations
        $locationsData = [
            [
                'location_name' => 'Gelora Bung Karno',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
            ],
            [
                'location_name' => 'Graha Sabha Pramana',
                'city' => 'Sleman',
                'province' => 'DI Yogyakarta',
            ],
            [
                'location_name' => 'Grand City Convention',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
            ],
            [
                'location_name' => 'Sabuga ITB',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
            ],
        ];

        $locations = [];
        foreach ($locationsData as $locData) {
            $locations[] = Location::create($locData);
        }

        // 4. Seed Events
        $eventsData = [
            [
                'title' => 'Jakarta Summer Live Festival 2026',
                'description' => 'The biggest summer music event in Jakarta featuring prominent local and international bands, live art performance, and food festival. Don\'t miss out on the ultimate summer vibe!',
                'date' => '2026-08-15',
                'time' => '16:00:00',
                'price' => 350000,
                'quota' => 200,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[0]->id,
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'AI & Future Tech Conference',
                'description' => 'Join technology leaders, innovators, and academic researchers for a deep dive into the latest artificial intelligence algorithms, LLM optimization, and their impact on global productivity and industries.',
                'date' => '2026-09-10',
                'time' => '09:00:00',
                'price' => 15000,
                'quota' => 150,
                'id_category' => $categories['Technology and Science']->id,
                'location_id' => $locations[1]->id,
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1591453089816-0fbb971b454c?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Indonesia Culture & Art Exhibition',
                'description' => 'A showcase of Indonesia\'s rich cultural heritage. Enjoy traditional dance performances, fine arts gallery from local artists, and live workshops on batik making and puppetry.',
                'date' => '2026-07-22',
                'time' => '10:00:00',
                'price' => 0, // Free
                'quota' => 300,
                'id_category' => $categories['Culture and Traditions']->id,
                'location_id' => $locations[2]->id,
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Yogyakarta Marathon 2026',
                'description' => 'Run for health and fun! The Yogyakarta Marathon offers 5K, 10K, and half-marathon tracks running through the historical streets and beautiful scenic countrysides of Sleman.',
                'date' => '2026-10-05',
                'time' => '05:00:00',
                'price' => 250000,
                'quota' => 500,
                'id_category' => $categories['Sports and Health']->id,
                'location_id' => $locations[1]->id,
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1502224562085-639556652f33?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Startup Founders Networking Brunch',
                'description' => 'Connect with other founders, angel investors, and venture capitalists in a relaxed weekend atmosphere. Shares experiences, pitch your idea, and find co-founders.',
                'date' => '2026-07-12',
                'time' => '11:00:00',
                'price' => 75000,
                'quota' => 50,
                'id_category' => $categories['Business and Networking']->id,
                'location_id' => $locations[3]->id,
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=80',
            ]
        ];

        foreach ($eventsData as $eventData) {
            Event::create($eventData);
        }
    }
}
