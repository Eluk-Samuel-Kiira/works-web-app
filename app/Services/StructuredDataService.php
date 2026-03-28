<?php

namespace App\Services;

class StructuredDataService
{
    public function jobPosting(array $job): array
    {
        $data = [
            '@context' => 'https://schema.org/',
            '@type' => 'JobPosting',
            'title' => $job['job_title'] ?? '',
            'description' => strip_tags($job['job_description'] ?? ''),
            'datePosted' => $job['created_at'] ?? now()->toAtomString(),
            'validThrough' => $job['deadline'] ?? null,
            'employmentType' => $this->mapEmploymentType($job['employment_type'] ?? 'full-time'),
            'jobLocationType' => $job['location_type'] === 'remote' ? 'TELECOMMUTE' : null,
            'url' => config('app.url') . '/jobs/' . ($job['slug'] ?? ''),
            
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => $job['company']['name'] ?? '',
                'sameAs' => $job['company']['website'] ?? null,
                'logo' => $job['company']['logo'] ?? null,
            ],
            
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job['job_location']['district'] ?? $job['duty_station'] ?? '',
                    'addressCountry' => $job['job_location']['country'] ?? 'UG',
                ],
            ],
        ];
        
        // Add salary if available
        if (!empty($job['salary_amount'])) {
            $data['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => $job['currency'] ?? 'UGX',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'value' => (float) $job['salary_amount'],
                    'unitText' => strtoupper($job['payment_period'] ?? 'MONTH'),
                ],
            ];
        }
        
        // Add experience requirements
        if (!empty($job['experience_level']['min_years'])) {
            $data['experienceRequirements'] = [
                '@type' => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => $job['experience_level']['min_years'] * 12,
            ];
        }
        
        // Add education requirements
        if (!empty($job['education_level']['name'])) {
            $data['educationRequirements'] = [
                '@type' => 'EducationalOccupationalCredential',
                'credentialCategory' => $job['education_level']['name'],
            ];
        }
        
        // Add skills
        if (!empty($job['skills'])) {
            $data['skills'] = strip_tags($job['skills']);
        }
        
        return array_filter($data);
    }
    
    private function mapEmploymentType(?string $type): string
    {
        return match($type) {
            'full-time' => 'FULL_TIME',
            'part-time' => 'PART_TIME',
            'contract' => 'CONTRACTOR',
            'internship' => 'INTERN',
            'temporary' => 'TEMPORARY',
            'volunteer' => 'VOLUNTEER',
            default => 'FULL_TIME',
        };
    }
}