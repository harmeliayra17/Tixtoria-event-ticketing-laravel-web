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
        // 1. Seed Users (Ensure the main accounts are updated or created)
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

        // 3. Seed Locations (10 premium, real-world venues)
        $locationsData = [
            [
                'location_name' => 'Gelora Bung Karno Main Stadium',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
            ],
            [
                'location_name' => 'ICE BSD City Exhibition Hall',
                'city' => 'Tangerang',
                'province' => 'Banten',
            ],
            [
                'location_name' => 'Jakarta International Stadium (JIS)',
                'city' => 'Jakarta Utara',
                'province' => 'DKI Jakarta',
            ],
            [
                'location_name' => 'Graha Sabha Pramana UGM',
                'city' => 'Sleman',
                'province' => 'DI Yogyakarta',
            ],
            [
                'location_name' => 'Grand City Convention Center',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
            ],
            [
                'location_name' => 'Sabuga ITB Convention Hall',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'location_name' => 'Manahan Stadium',
                'city' => 'Surakarta',
                'province' => 'Jawa Tengah',
            ],
            [
                'location_name' => 'Bali Nusa Dua Convention Center (BNDCC)',
                'city' => 'Badung',
                'province' => 'Bali',
            ],
            [
                'location_name' => 'Jatim Park 3 Theme Park',
                'city' => 'Batu',
                'province' => 'Jawa Timur',
            ],
            [
                'location_name' => 'Marina Bay Sands Expo Center',
                'city' => 'Downtown Core',
                'province' => 'Singapore',
            ],
        ];

        $locations = [];
        foreach ($locationsData as $locData) {
            $locations[] = Location::updateOrCreate(
                ['location_name' => $locData['location_name']],
                $locData
            );
        }

        // 4. Clear existing events first to prevent duplicates or mix-up with un-real events
        Event::truncate();

        // 5. Seed 42 Rich, Realistic, and Trending Events for 2026/2027
        $eventsData = [
            // --- ENTERTAINMENT & ARTS (1-10) ---
            [
                'title' => 'Coldplay: Music of the Spheres Tour 2026',
                'description' => 'Experience the world-renowned record-breaking live show. Enjoy signature glowing wristbands, spectacular laser lights, and top-tier hits like Yellow, Fix You, and Viva La Vida live under the stars.',
                'date' => '2026-08-15',
                'time' => '19:00:00',
                'price' => 850000,
                'quota' => 500,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[0]->id, // GBK
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Billie Eilish: Hit Me Hard and Soft Tour',
                'description' => 'The global pop phenomenon performs her latest award-winning album. With stunning minimalist staging, intimate lighting, and powerful basslines, this promises to be a deeply immersive audio-visual concert.',
                'date' => '2026-10-02',
                'time' => '20:00:00',
                'price' => 1200000,
                'quota' => 400,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[2]->id, // JIS
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Taylor Swift: The Eras Tour (Continuation)',
                'description' => 'A three-hour musical journey through all of Taylor Swift\'s iconic creative eras. Featuring dozens of custom outfits, elaborate theatrical stages, and all of her chart-topping stadium anthems.',
                'date' => '2026-11-20',
                'time' => '18:00:00',
                'price' => 2500000,
                'quota' => 600,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[9]->id, // Marina Bay Sands
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Dua Lipa: Radical Optimism Tour',
                'description' => 'Get ready to dance to Dua Lipa\'s high-energy electropop performance. Accompanied by world-class backing dancers, dazzling choreography, and massive sing-alongs of Levitating and Houdini.',
                'date' => '2026-07-08',
                'time' => '19:30:00',
                'price' => 950000,
                'quota' => 350,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Bruno Mars Live in Jakarta',
                'description' => 'The ultimate showman is back! Sing along to 24K Magic, Uptown Funk, and Leave The Door Open in an unforgettable night filled with retro funk, soul, and spectacular dance moves.',
                'date' => '2026-09-12',
                'time' => '20:00:00',
                'price' => 1500000,
                'quota' => 450,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[2]->id, // JIS
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'LANY: A Beautiful Mind Tour 2026',
                'description' => 'Indie pop sensation LANY returns for a night of emotional synth-pop and dreamy melodies. Experience their signature aesthetic and sing along to classic hits like ILYSB and Super Far.',
                'date' => '2026-06-28',
                'time' => '19:00:00',
                'price' => 750000,
                'quota' => 300,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1506157786151-b8491531f063?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Tomorrowland Asia Electronic Music Festival',
                'description' => 'The legendary EDM festival comes to Southeast Asia. Featuring top DJs, mind-bending stage designs, immersive light shows, and a massive community of electronic music lovers.',
                'date' => '2026-12-05',
                'time' => '15:00:00',
                'price' => 2000000,
                'quota' => 800,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[7]->id, // BNDCC Bali
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1482578018400-6f60c5a67bcb?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Ed Sheeran: Mathematics Tour',
                'description' => 'Ed Sheeran performs in a spectacular 360-degree round stage design. Watch him build complex live loops entirely on the spot, delivering emotional acoustic tracks and upbeat radio anthems.',
                'date' => '2026-08-30',
                'time' => '18:30:00',
                'price' => 1100000,
                'quota' => 500,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[0]->id, // GBK
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'The Weeknd: After Hours Till Dawn Tour',
                'description' => 'A theatrical sci-fi concert experience set in a dystopian cityscape. Sing along to Blinding Lights, Starboy, and Save Your Tears with massive flame machines and lighting rigs.',
                'date' => '2026-10-18',
                'time' => '19:00:00',
                'price' => 1800000,
                'quota' => 400,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[2]->id, // JIS
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Java Jazz Festival 2026',
                'description' => 'One of the largest jazz festivals in the world, featuring legendary jazz musicians and contemporary crossover artists across multiple indoor and outdoor stages.',
                'date' => '2026-06-05',
                'time' => '16:00:00',
                'price' => 450000,
                'quota' => 300,
                'id_category' => $categories['Entertainment and Arts']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1486591978090-58e619d37fe7?w=800&auto=format&fit=crop&q=80',
            ],

            // --- TECHNOLOGY & SCIENCE (11-16) ---
            [
                'title' => 'ASEAN Tech & AI Summit 2026',
                'description' => 'Gather with regional tech leaders, researchers, and venture capitalists to explore developments in large language models, agentic workflows, robotics, and the digital economy.',
                'date' => '2026-07-15',
                'time' => '09:00:00',
                'price' => 150000,
                'quota' => 250,
                'id_category' => $categories['Technology and Science']->id,
                'location_id' => $locations[7]->id, // BNDCC Bali
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Google I/O Extended Jakarta',
                'description' => 'Get the local developer perspective on the latest Google announcements. Deep dives into Android SDKs, Flutter updates, Gemini API integration, and Firebase developments.',
                'date' => '2026-06-20',
                'time' => '13:00:00',
                'price' => 0,
                'quota' => 200,
                'id_category' => $categories['Technology and Science']->id,
                'location_id' => $locations[5]->id, // Sabuga ITB
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1591453089816-0fbb971b454c?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Global Web3 & Blockchain Congress',
                'description' => 'An international congress focused on decentralized finance, smart contract security, zero-knowledge proofs, and real-world asset tokenization strategies.',
                'date' => '2026-11-10',
                'time' => '09:30:00',
                'price' => 250000,
                'quota' => 150,
                'id_category' => $categories['Technology and Science']->id,
                'location_id' => $locations[4]->id, // Grand City
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Cybersecurity & Cloud Security Expo',
                'description' => 'A premier expo displaying state-of-the-art defenses against ransomware, data breaches, and cloud vulnerabilities. Features live hacking demonstrations.',
                'date' => '2026-09-08',
                'time' => '09:00:00',
                'price' => 120000,
                'quota' => 200,
                'id_category' => $categories['Technology and Science']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Sustainable Energy Forum 2026',
                'description' => 'Leading scientists and policymakers present solutions on solar efficiency, battery storage breakthroughs, and microgrid implementations for green cities.',
                'date' => '2026-08-22',
                'time' => '10:00:00',
                'price' => 50000,
                'quota' => 120,
                'id_category' => $categories['Technology and Science']->id,
                'location_id' => $locations[5]->id, // Sabuga ITB
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Quantum Computing & Future Physics',
                'description' => 'A rare public talk by leading physicists on quantum superposition, computing qubits, and the future of computational cryptography in the next decade.',
                'date' => '2026-10-14',
                'time' => '14:00:00',
                'price' => 60000,
                'quota' => 100,
                'id_category' => $categories['Technology and Science']->id,
                'location_id' => $locations[3]->id, // GSP UGM
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=800&auto=format&fit=crop&q=80',
            ],

            // --- EDUCATION & SEMINAR (17-22) ---
            [
                'title' => 'International Higher Education Expo 2026',
                'description' => 'Meet representatives from top Ivy League and European universities. Learn about scholarship programs, admission criteria, and international student visas.',
                'date' => '2026-07-25',
                'time' => '10:00:00',
                'price' => 0,
                'quota' => 500,
                'id_category' => $categories['Education and Seminar']->id,
                'location_id' => $locations[3]->id, // GSP UGM
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'TEDxUGM: Rethinking the Future',
                'description' => 'Inspirational local and international speakers share powerful ideas on community resilience, eco-living, design thinking, and educational innovations.',
                'date' => '2026-09-20',
                'time' => '13:00:00',
                'price' => 35000,
                'quota' => 150,
                'id_category' => $categories['Education and Seminar']->id,
                'location_id' => $locations[3]->id, // GSP UGM
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'National Digital Marketing Summit',
                'description' => 'Master SEO, algorithmic social advertising, branding strategy, and AI-assisted copywriting tools. Learn directly from successful industry leaders and CMOs.',
                'date' => '2026-08-05',
                'time' => '09:00:00',
                'price' => 180000,
                'quota' => 250,
                'id_category' => $categories['Education and Seminar']->id,
                'location_id' => $locations[4]->id, // Grand City
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Creative Writing Workshop & Masterclass',
                'description' => 'Develop your voice, construct complex narratives, and learn publishing strategies. Includes interactive writing exercises and feedback sessions with published authors.',
                'date' => '2026-06-18',
                'time' => '10:00:00',
                'price' => 50000,
                'quota' => 80,
                'id_category' => $categories['Education and Seminar']->id,
                'location_id' => $locations[5]->id, // Sabuga ITB
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Leadership & Professional Public Speaking',
                'description' => 'Conquer stage fright, build confidence, structure persuasive presentations, and influence people. Perfect for corporate managers and aspiring public figures.',
                'date' => '2026-07-30',
                'time' => '09:00:00',
                'price' => 75000,
                'quota' => 120,
                'id_category' => $categories['Education and Seminar']->id,
                'location_id' => $locations[3]->id, // GSP UGM
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Fintech Regulation & Financial Literacy',
                'description' => 'A comprehensive seminar covering personal finance management, tax basics, crypto regulation, and smart long-term investing principles.',
                'date' => '2026-11-05',
                'time' => '13:00:00',
                'price' => 40000,
                'quota' => 150,
                'id_category' => $categories['Education and Seminar']->id,
                'location_id' => $locations[4]->id, // Grand City
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=800&auto=format&fit=crop&q=80',
            ],

            // --- SPORTS & HEALTH (23-28) ---
            [
                'title' => 'Jakarta International Marathon 2026',
                'description' => 'Join thousands of local and international runners in full marathon, half-marathon, and 10K courses. Route spans historic landmarks of central Jakarta.',
                'date' => '2026-10-11',
                'time' => '04:30:00',
                'price' => 300000,
                'quota' => 800,
                'id_category' => $categories['Sports and Health']->id,
                'location_id' => $locations[0]->id, // GBK
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Bali International Triathlon 2026',
                'description' => 'The ultimate test of endurance. Swim through pristine coastal waters, cycle across Bali\'s highway bridges, and run along Nusa Dua\'s scenic resort pathways.',
                'date' => '2026-06-25',
                'time' => '05:30:00',
                'price' => 650000,
                'quota' => 250,
                'id_category' => $categories['Sports and Health']->id,
                'location_id' => $locations[7]->id, // BNDCC Bali
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1530541930197-ff16ac917b0e?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'FIBA Asia Cup 2026 (Group Stage)',
                'description' => 'Watch top-tier Asian basketball teams face off in high-intensity qualifying matches. Live matches, concessions, and incredible courtside action.',
                'date' => '2026-08-20',
                'time' => '14:00:00',
                'price' => 150000,
                'quota' => 300,
                'id_category' => $categories['Sports and Health']->id,
                'location_id' => $locations[0]->id, // GBK
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Indonesia Open Badminton Championship',
                'description' => 'Cheer for your favorite badminton stars at one of the world\'s most prestigious BWF World Tour Super 1000 tournaments.',
                'date' => '2026-06-14',
                'time' => '09:00:00',
                'price' => 200000,
                'quota' => 400,
                'id_category' => $categories['Sports and Health']->id,
                'location_id' => $locations[0]->id, // GBK
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Yoga & Mindfulness Retreat Bali',
                'description' => 'Reconnect with your inner self. Daily Vinyasa flow, pranayama breathing sessions, organic meal prep tutorials, and beach meditation circles.',
                'date' => '2026-07-18',
                'time' => '07:00:00',
                'price' => 450000,
                'quota' => 100,
                'id_category' => $categories['Sports and Health']->id,
                'location_id' => $locations[7]->id, // BNDCC Bali
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Indonesia Fitness & Bodybuilding Expo',
                'description' => 'Interactive workout workshops, expert nutrition seminars, supplement brand discount pop-ups, and regional bodybuilding championships.',
                'date' => '2026-11-28',
                'time' => '09:00:00',
                'price' => 80000,
                'quota' => 200,
                'id_category' => $categories['Sports and Health']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=800&auto=format&fit=crop&q=80',
            ],

            // --- BUSINESS & NETWORKING (29-32) ---
            [
                'title' => 'Asia-Pacific Business & Capital Forum',
                'description' => 'Connect with corporate executives, institutional investors, and innovators to discuss trading agreements, sustainable growth, and cross-border expansion.',
                'date' => '2026-07-22',
                'time' => '10:00:00',
                'price' => 850000,
                'quota' => 200,
                'id_category' => $categories['Business and Networking']->id,
                'location_id' => $locations[9]->id, // MBS Singapore
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'E-Commerce & Retail Innovation Expo',
                'description' => 'Discover the future of online retail. Learn about omnichannel logistics, automated checkouts, personalization engines, and social media shop integration.',
                'date' => '2026-08-11',
                'time' => '09:00:00',
                'price' => 100000,
                'quota' => 200,
                'id_category' => $categories['Business and Networking']->id,
                'location_id' => $locations[4]->id, // Grand City
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Venture Capital & Startup Speed Dating',
                'description' => 'Pitch your business idea directly to active angel investors and venture capitalists in rapid 5-minute roundtables. Open to early-stage founders.',
                'date' => '2026-06-30',
                'time' => '14:00:00',
                'price' => 200000,
                'quota' => 80,
                'id_category' => $categories['Business and Networking']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Young Entrepreneur & Innovation Summit',
                'description' => 'Celebrate youth entrepreneurship. Panel discussions on bootstrap financing, market-fit testing, remote team management, and product design principles.',
                'date' => '2026-09-05',
                'time' => '09:00:00',
                'price' => 80000,
                'quota' => 180,
                'id_category' => $categories['Business and Networking']->id,
                'location_id' => $locations[5]->id, // Sabuga ITB
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=80',
            ],

            // --- CHILDREN & FAMILY (33-36) ---
            [
                'title' => 'Disney On Ice: Mickey and Friends',
                'description' => 'A magical ice-skating show for the whole family. Witness spectacular spins, beautiful scenery, and timeless songs from Disney classics.',
                'date' => '2026-12-20',
                'time' => '11:00:00',
                'price' => 350000,
                'quota' => 400,
                'id_category' => $categories['Children and Family']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Kids Fun Science Fair & Robotics Lab',
                'description' => 'Hands-on physics experiments, chemistry color reactions, basic Lego robotics programming, and volcanic eruption mockups designed for curious young minds.',
                'date' => '2026-06-21',
                'time' => '10:00:00',
                'price' => 50000,
                'quota' => 150,
                'id_category' => $categories['Children and Family']->id,
                'location_id' => $locations[8]->id, // Jatim Park 3
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1566088939664-82717fe9008a?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Family Summer Camp & Outdoor Quest',
                'description' => 'Family bonding games, nature trails, basic archery training, campfire roasting, and acoustic starlight sing-alongs in a secured campground.',
                'date' => '2026-08-08',
                'time' => '15:00:00',
                'price' => 150000,
                'quota' => 100,
                'id_category' => $categories['Children and Family']->id,
                'location_id' => $locations[8]->id, // Jatim Park 3
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Creative Lego Building Championship',
                'description' => 'A creative competition for children aged 6 to 12. Teams build futuristic cities, vehicles, and creatures with thousands of colorful Lego bricks.',
                'date' => '2026-09-19',
                'time' => '10:00:00',
                'price' => 75000,
                'quota' => 100,
                'id_category' => $categories['Children and Family']->id,
                'location_id' => $locations[4]->id, // Grand City
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=800&auto=format&fit=crop&q=80',
            ],

            // --- CULTURE & TRADITIONS (37-39) ---
            [
                'title' => 'Balinese Traditional Dance & Gamelan Gala',
                'description' => 'Experience the spiritual beauty of Kecak and Barong dances, set against the backdrop of Nusa Dua ocean breeze with complex gamelan percussion.',
                'date' => '2026-07-28',
                'time' => '18:00:00',
                'price' => 120000,
                'quota' => 250,
                'id_category' => $categories['Culture and Traditions']->id,
                'location_id' => $locations[7]->id, // BNDCC Bali
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Jogja Heritage, Batik & Craft Fair 2026',
                'description' => 'A massive exhibition of hand-painted batik fabrics, wooden puppets, silver jewelry, and traditional pottery from local Indonesian micro-artisans.',
                'date' => '2026-09-25',
                'time' => '10:00:00',
                'price' => 0,
                'quota' => 400,
                'id_category' => $categories['Culture and Traditions']->id,
                'location_id' => $locations[3]->id, // GSP UGM
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Indonesian Gastronomy & Culinary Heritage',
                'description' => 'Taste authentic, historical recipes from across the Indonesian archipelago. Features live presentations by traditional master chefs and food historians.',
                'date' => '2026-08-09',
                'time' => '11:00:00',
                'price' => 50000,
                'quota' => 300,
                'id_category' => $categories['Culture and Traditions']->id,
                'location_id' => $locations[4]->id, // Grand City
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&auto=format&fit=crop&q=80',
            ],

            // --- LIFESTYLE & COMMUNITY (40-42) ---
            [
                'title' => 'International Coffee, Cocoa & Barista Expo',
                'description' => 'Sample premium single-origin coffee beans, learn home brewing methods, and witness the regional Latte Art and Barista Cup championships.',
                'date' => '2026-06-19',
                'time' => '10:00:00',
                'price' => 40000,
                'quota' => 200,
                'id_category' => $categories['Lifestyle and Community']->id,
                'location_id' => $locations[5]->id, // Sabuga ITB
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Jakarta Fashion & Streetwear Week 2026',
                'description' => 'Runway shows from local designers, pop-up stores selling exclusive runway items, styling workshops, and massive streetwear enthusiast gatherings.',
                'date' => '2026-10-25',
                'time' => '13:00:00',
                'price' => 250000,
                'quota' => 200,
                'id_category' => $categories['Lifestyle and Community']->id,
                'location_id' => $locations[1]->id, // ICE BSD
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&auto=format&fit=crop&q=80',
            ],
            [
                'title' => 'Sneakerhead & Luxury Streetwear Swap Meet',
                'description' => 'Buy, sell, and trade rare sneakers, collectible apparel, and limited-edition accessories. Authenticators will be on-site to inspect all luxury items.',
                'date' => '2026-07-04',
                'time' => '11:00:00',
                'price' => 60000,
                'quota' => 150,
                'id_category' => $categories['Lifestyle and Community']->id,
                'location_id' => $locations[4]->id, // Grand City
                'user_id' => $organizer->id,
                'image' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?w=800&auto=format&fit=crop&q=80',
            ]
        ];

        foreach ($eventsData as $eventData) {
            Event::create($eventData);
        }
    }
}
