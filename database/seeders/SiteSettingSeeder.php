<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Footer bottom links
            [
            'id' => 1,
            'key' => 'footer-bottom',
            'type' => 'internal_link',
            'value' => 'Privacy Policy',
            'article_id' => 1,
            'order' => 1
            ],
            [
            'id' => 2,
            'key' => 'footer-bottom',
            'type' => 'internal_link',
            'value' => 'Terms of Service',
            'article_id' => 2,
            'order' => 2
            ],
            [
            'id' => 3,
            'key' => 'footer-bottom',
            'type' => 'internal_link',
            'value' => 'Cookie Policy',
            'article_id' => 3,
            'order' => 3
            ],
            // Additional settings
            [
            'id' => 4,
            'key' => 'site-title',
            'type' => 'text',
            'value' => 'TenEcho'
            ],
            [
            'id' => 5,
            'key' => 'site-description',
            'type' => 'text',
            'value' => 'Technology moves fast. We keep you faster.'
            ],
            [
            'id' => 6,
            'key' => 'copyright',
            'type' => 'text',
            'value' => '© 2025 Tenecho. All rights reserved.'
            ],

            // Nav top
            [
            'id' => 11,
            'key' => 'nav-top',
            'type' => 'text',
            'value' => 'If it’s not giving joy, it’s gotta go.'
            ],

            // Social links with SVG icons
            [
            'id' => 7,
            'key' => 'social-links',
            'type' => 'external_link',
            'value' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M10.4883 14.651L15.25 21H22.25L14.3917 10.5223L20.9308 3H18.2808L13.1643 8.88578L8.75 3H1.75L9.26086 13.0145L2.31915 21H4.96917L10.4883 14.651ZM16.25 19L5.75 5H7.75L18.25 19H16.25Z" /></svg>',
            'description' => 'X',
            'url' => 'https://x.com',
            'order' => 1
            ],
            [
            'id' => 8,
            'key' => 'social-links',
            'type' => 'external_link',
            'value' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.001 2C6.47813 2 2.00098 6.47715 2.00098 12C2.00098 16.9913 5.65783 21.1283 10.4385 21.8785V14.8906H7.89941V12H10.4385V9.79688C10.4385 7.29063 11.9314 5.90625 14.2156 5.90625C15.3097 5.90625 16.4541 6.10156 16.4541 6.10156V8.5625H15.1931C13.9509 8.5625 13.5635 9.33334 13.5635 10.1242V12H16.3369L15.8936 14.8906H13.5635V21.8785C18.3441 21.1283 22.001 16.9913 22.001 12C22.001 6.47715 17.5238 2 12.001 2Z" /></svg>',
            'description' => 'Facebook',
            'url' => 'https://www.facebook.com',
            'order' => 2
            ],
            [
            'id' => 9,
            'key' => 'social-links',
            'type' => 'external_link',
            'value' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM9.71002 19.6674C8.74743 17.6259 8.15732 15.3742 8.02731 13H4.06189C4.458 16.1765 6.71639 18.7747 9.71002 19.6674ZM10.0307 13C10.1811 15.4388 10.8778 17.7297 12 19.752C13.1222 17.7297 13.8189 15.4388 13.9693 13H10.0307ZM19.9381 13H15.9727C15.8427 15.3742 15.2526 17.6259 14.29 19.6674C17.2836 18.7747 19.542 16.1765 19.9381 13ZM4.06189 11H8.02731C8.15732 8.62577 8.74743 6.37407 9.71002 4.33256C6.71639 5.22533 4.458 7.8235 4.06189 11ZM10.0307 11H13.9693C13.8189 8.56122 13.1222 6.27025 12 4.24799C10.8778 6.27025 10.1811 8.56122 10.0307 11ZM14.29 4.33256C15.2526 6.37407 15.8427 8.62577 15.9727 11H19.9381C19.542 7.8235 17.2836 5.22533 14.29 4.33256Z" /></svg>',
            'description' => 'Website',
            'url' => '',
            'order' => 3
            ],
            // footer-company
            [
            'id' => 10,
            'key' => 'footer-company',
            'type' => 'internal_link',
            'value' => 'About Us',
            'article_id' => 4,
            'order' => 1
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\SiteSetting::updateOrCreate([
                'id' => $setting['id'],
                'key' => $setting['key'],
                'type' => $setting['type'] ?? 'text',
                'value' => $setting['value'],
                'description' => $setting['description'] ?? null,
                'url' => $setting['url'] ?? null,
                'image' => $setting['image'] ?? null,
                'order' => $setting['order'] ?? 0,
                'article_id' => $setting['article_id'] ?? null,
            ]);
        }
    }
}
