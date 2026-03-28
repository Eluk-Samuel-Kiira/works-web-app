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
            'jobLocationType' => ($job['location_type'] ?? '') === 'remote' ? 'TELECOMMUTE' : ($job['location_type'] ?? null),
            'url' => config('app.url') . '/jobs/' . ($job['slug'] ?? ''),
            'directApply' => true,
            
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
                    'streetAddress' => $job['street_address'] ?? $job['duty_station'] ?? null,
                    'addressLocality' => $job['job_location']['district'] ?? $job['duty_station'] ?? null,
                    'addressRegion' => $job['job_location']['district'] ?? null,
                    'addressCountry' => $job['job_location']['country'] ?? 'UG',
                    'postalCode' => $job['job_location']['postal_code'] ?? null,
                ],
            ],
        ];
        
        // Add salary (baseSalary) - FIX #1
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
        } elseif (!empty($job['salary_range'])) {
            $data['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => $job['salary_range']['currency'] ?? 'UGX',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => (float) ($job['salary_range']['min'] ?? 0),
                    'maxValue' => (float) ($job['salary_range']['max'] ?? 0),
                    'unitText' => 'MONTH',
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
        
        // Add responsibilities
        if (!empty($job['responsibilities'])) {
            $data['responsibilities'] = strip_tags($job['responsibilities']);
        }
        
        // Add qualifications
        if (!empty($job['qualifications'])) {
            $data['qualifications'] = strip_tags($job['qualifications']);
        }
        
        // Add application URL if exists
        if (!empty($job['application_procedure'])) {
            $urlMatch = preg_match('/(https?:\/\/[^\s]+)/', $job['application_procedure'], $matches);
            if ($urlMatch) {
                $data['applicationUrl'] = $matches[0];
            }
        }
        
        // Add hiring contact
        if (!empty($job['email']) || !empty($job['telephone'])) {
            $data['hiringContact'] = [
                '@type' => 'ContactPoint',
                'email' => $job['email'] ?? null,
                'telephone' => $job['telephone'] ?? null,
                'contactType' => 'hiring',
                'availableLanguage' => ['English'],
            ];
        }
        
        return array_filter($data, fn($v) => $v !== null);
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