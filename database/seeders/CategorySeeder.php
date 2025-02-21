<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Restaurants', 'Cafés & Coffee Shops', 'Bars & Pubs', 'Bakeries & Dessert Shops', 'Food Trucks',
            'Specialty Food Stores', 'Clothing & Apparel Stores', 'Shoe & Accessories Shops', 'Electronics & Tech Stores',
            'Bookstores', 'Furniture & Home Decor Stores', 'Grocery & Supermarkets', 'Thrift & Vintage Shops',
            'Beauty & Cosmetics Stores', 'Gyms & Fitness Centers', 'Yoga & Pilates Studios', 'Spas & Massage Therapy Centers',
            'Chiropractors & Wellness Clinics', 'Health Food & Supplement Stores', 'Mental Health & Counseling Services',
            'Movie Theaters', 'Concert Venues', 'Bowling Alleys & Arcades', 'Escape Rooms', 'Amusement & Theme Parks',
            'Gaming Lounges & VR Arcades', 'Nightclubs & Live Music Venues', 'Art Galleries & Museums', 'Hotels & Resorts',
            'Bed & Breakfasts', 'Hostels & Short-Term Rentals', 'Travel Agencies & Tour Operators',
            'Car Rentals & Transportation Services', 'Salons & Barbershops', 'Nail & Beauty Salons', 'Tailors & Dry Cleaners',
            'Pet Grooming & Boarding Services', 'Co-Working Spaces & Offices', 'Printing & Copy Services',
            'Legal & Financial Consulting', 'Marketing & Advertising Agencies', 'Language Schools', 'Music & Dance Studios',
            'Tutoring & Test Prep Centers', 'Cooking & Craft Classes', 'Wedding & Event Planning Services',
            'Party Supply & Rental Stores', 'Conference & Meeting Venues', 'Photography & Videography Services',
            'Car Dealerships', 'Auto Repair & Maintenance Shops', 'Gas Stations & Car Washes', 'Bike & Scooter Rental Services'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}

