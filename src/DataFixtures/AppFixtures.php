<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoriesData = [
            ['name' => 'Electronics',      'slug' => 'electronics',  'description' => 'Headphones, speakers, gadgets and more'],
            ['name' => 'Fashion',          'slug' => 'fashion',      'description' => 'Clothing, accessories and footwear'],
            ['name' => 'Home & Garden',    'slug' => 'home-garden',  'description' => 'Furniture, decor and gardening tools'],
            ['name' => 'Sports & Fitness', 'slug' => 'sports',       'description' => 'Workout gear, yoga mats and equipment'],
            ['name' => 'Books',            'slug' => 'books',        'description' => 'Fiction, non-fiction and educational'],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $category = new Category();
            $category->setName($data['name']);
            $category->setSlug($data['slug']);
            $category->setDescription($data['description']);
            $manager->persist($category);
            $categories[$data['slug']] = $category;
        }

        $productsData = [
            ['name' => 'Wireless Headphones',  'price' => 79.99,  'category' => 'electronics', 'description' => 'Premium noise-cancelling wireless headphones with 30h battery life.'],
            ['name' => 'Bluetooth Speaker',    'price' => 59.99,  'category' => 'electronics', 'description' => 'Portable waterproof speaker with 360° sound.'],
            ['name' => 'Smartphone Stand',     'price' => 19.99,  'category' => 'electronics', 'description' => 'Adjustable aluminium stand for all smartphones.'],
            ['name' => 'USB-C Cable 2m',       'price' => 12.99,  'category' => 'electronics', 'description' => 'Braided fast-charging USB-C cable, 2 meters.'],
            ['name' => 'Wireless Mouse',       'price' => 29.99,  'category' => 'electronics', 'description' => 'Ergonomic wireless mouse with silent click.'],
            ['name' => 'Mechanical Keyboard',  'price' => 89.99,  'category' => 'electronics', 'description' => 'Compact TKL mechanical keyboard with RGB backlight.'],
            ['name' => 'Webcam HD 1080p',      'price' => 49.99,  'category' => 'electronics', 'description' => 'Full HD webcam with built-in microphone.'],
            ['name' => 'Power Bank 20000mAh',  'price' => 39.99,  'category' => 'electronics', 'description' => 'High-capacity power bank with dual USB output.'],
            ['name' => 'Smart Watch Pro',      'price' => 199.99, 'category' => 'electronics', 'description' => 'Smart watch with health tracking and GPS.'],
            ['name' => 'Classic Leather Jacket','price' => 149.99,'category' => 'fashion',     'description' => 'Genuine leather jacket, timeless style.'],
            ['name' => 'Running Sneakers',     'price' => 89.99,  'category' => 'fashion',     'description' => 'Lightweight and breathable running shoes.'],
            ['name' => 'Smart Plant Sensor',   'price' => 34.99,  'category' => 'home-garden', 'description' => 'Monitors soil moisture, light and temperature.'],
            ['name' => 'Yoga Mat Premium',     'price' => 29.99,  'category' => 'sports',      'description' => 'Non-slip premium yoga mat, 6mm thick.'],
            ['name' => 'Web Development Guide','price' => 24.99,  'category' => 'books',       'description' => 'Complete guide to modern web development.'],
        ];

        foreach ($productsData as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setDescription($data['description']);
            $product->setCategory($categories[$data['category']]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
