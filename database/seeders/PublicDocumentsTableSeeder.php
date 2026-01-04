<?php

namespace Database\Seeders;

use App\Models\PublicDocument;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PublicDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first();
        
        if (!$admin) {
            $this->command->warn('Please seed admins first!');
            return;
        }

        $documents = [
            [
                'title' => 'Village Development Plan 2024',
                'description' => 'Comprehensive development plan for the village covering infrastructure, education, and healthcare.',
                'document_upload_type' => 'url',
                'document_url' => 'https://example.com/documents/development-plan.pdf',
                'uploaded_by' => $admin->id,
                'uploaded_date' => Carbon::now()->subMonths(2),
                'status' => 1,
            ],
            [
                'title' => 'Annual Budget Report',
                'description' => 'Detailed budget report for the current financial year.',
                'document_upload_type' => 'url',
                'document_url' => 'https://example.com/documents/budget-report.pdf',
                'uploaded_by' => $admin->id,
                'uploaded_date' => Carbon::now()->subMonths(1),
                'status' => 1,
            ],
            [
                'title' => 'Meeting Minutes - January 2024',
                'description' => 'Minutes from the village committee meeting held in January.',
                'document_upload_type' => 'url',
                'document_url' => 'https://example.com/documents/meeting-minutes-jan.pdf',
                'uploaded_by' => $admin->id,
                'uploaded_date' => Carbon::now()->subDays(15),
                'status' => 1,
            ],
            [
                'title' => 'Health Survey Report',
                'description' => 'Report on health conditions and facilities in the village.',
                'document_upload_type' => 'url',
                'document_url' => 'https://example.com/documents/health-survey.pdf',
                'uploaded_by' => $admin->id,
                'uploaded_date' => Carbon::now()->subDays(10),
                'status' => 1,
            ],
            [
                'title' => 'Education Statistics',
                'description' => 'Statistics on education levels and school enrollment in the village.',
                'document_upload_type' => 'url',
                'document_url' => 'https://example.com/documents/education-stats.pdf',
                'uploaded_by' => $admin->id,
                'uploaded_date' => Carbon::now()->subDays(5),
                'status' => 1,
            ],
        ];

        foreach ($documents as $document) {
            PublicDocument::create($document);
        }
    }
}

