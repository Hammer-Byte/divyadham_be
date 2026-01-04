<?php

namespace Database\Seeders;

use App\Models\Pages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h2>About Divyadham</h2><p>Divyadham is a platform dedicated to connecting communities and promoting village development. We work towards creating sustainable and prosperous villages through various initiatives and programs.</p><p>Our mission is to empower rural communities and preserve our rich cultural heritage while embracing modern development.</p>',
                'status' => 1,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Privacy Policy</h2><p>We are committed to protecting your privacy. This policy explains how we collect, use, and safeguard your personal information.</p><h3>Information We Collect</h3><p>We collect information that you provide directly to us, including name, email, phone number, and other contact details.</p><h3>How We Use Your Information</h3><p>We use your information to provide services, communicate with you, and improve our platform.</p>',
                'status' => 1,
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'content' => '<h2>Terms and Conditions</h2><p>By using our platform, you agree to comply with these terms and conditions.</p><h3>User Responsibilities</h3><p>Users are responsible for maintaining the confidentiality of their account information and for all activities that occur under their account.</p><h3>Platform Usage</h3><p>The platform is provided for lawful purposes only. Users must not engage in any illegal or harmful activities.</p>',
                'status' => 1,
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<h2>Contact Us</h2><p>We would love to hear from you! Reach out to us through any of the following channels:</p><h3>Email</h3><p>Email us at: info@divyadham.com</p><h3>Phone</h3><p>Call us at: +91-9876543210</p><h3>Address</h3><p>Divyadham Village<br>District, State<br>PIN: 123456</p>',
                'status' => 1,
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => '<h2>Frequently Asked Questions</h2><h3>How do I register?</h3><p>You can register by providing your phone number and basic information through our registration form.</p><h3>How can I donate?</h3><p>You can donate to various campaigns through our donation platform. All donations are secure and transparent.</p><h3>How do I participate in events?</h3><p>Browse through our events section and register for events you are interested in attending.</p>',
                'status' => 1,
            ],
        ];

        foreach ($pages as $page) {
            Pages::create($page);
        }
    }
}

