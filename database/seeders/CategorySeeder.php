<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Food & Beverage' => [
                'Restaurants',
                'Cafés & Coffee Shops',
                'Bars & Pubs',
                'Bakeries & Dessert Shops',
                'Food Trucks',
                'Specialty Food Stores'
            ],
            'Retail & Shopping' => [
                'Clothing & Apparel Stores',
                'Shoe & Accessories Shops',
                'Electronics & Tech Stores',
                'Bookstores',
                'Furniture & Home Decor Stores',
                'Grocery & Supermarkets',
                'Thrift & Vintage Shops',
                'Beauty & Cosmetics Stores'
            ],
            'Health & Wellness' => [
                'Gyms & Fitness Centers',
                'Yoga & Pilates Studios',
                'Spas & Massage Therapy Centers',
                'Chiropractors & Wellness Clinics',
                'Health Food & Supplement Stores',
                'Mental Health & Counseling Services'
            ],
            'Entertainment & Leisure' => [
                'Movie Theaters',
                'Concert Venues',
                'Bowling Alleys & Arcades',
                'Escape Rooms',
                'Amusement & Theme Parks',
                'Gaming Lounges & VR Arcades',
                'Nightclubs & Live Music Venues',
                'Art Galleries & Museums'
            ],
            'Hospitality & Travel' => [
                'Hotels & Resorts',
                'Bed & Breakfasts',
                'Hostels & Short-Term Rentals',
                'Travel Agencies & Tour Operators',
                'Car Rentals & Transportation Services'
            ],
            'Personal Services' => [
                'Salons & Barbershops',
                'Nail & Beauty Salons',
                'Tailors & Dry Cleaners',
                'Pet Grooming & Boarding Services'
            ],
            'Professional Services' => [
                'Co-Working Spaces & Offices',
                'Printing & Copy Services',
                'Legal & Financial Consulting',
                'Marketing & Advertising Agencies'
            ],
            'Education & Learning' => [
                'Language Schools',
                'Music & Dance Studios',
                'Tutoring & Test Prep Centers',
                'Cooking & Craft Classes'
            ],
            'Events & Experiences' => [
                'Wedding & Event Planning Services',
                'Party Supply & Rental Stores',
                'Conference & Meeting Venues',
                'Photography & Videography Services'
            ],
            'Automotive & Transportation' => [
                'Car Dealerships',
                'Auto Repair & Maintenance Shops',
                'Gas Stations & Car Washes',
                'Bike & Scooter Rental Services'
            ]
        ];

        foreach ($categories as $parentName => $subcategories) {
            $parent = Category::create(['name' => $parentName]);

            foreach ($subcategories as $subcategory) {
                Category::create(['name' => $subcategory, 'parent_id' => $parent->id]);
            }
        }
    }
}

