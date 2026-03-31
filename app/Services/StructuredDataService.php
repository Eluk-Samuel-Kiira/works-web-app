<?php

namespace App\Services;

class StructuredDataService
{
    public function jobPosting(array $job): array
    {
        $data = [
            '@context'       => 'https://schema.org/',
            '@type'          => 'JobPosting',
            'title'          => $job['job_title'] ?? '',
            'description'    => strip_tags($job['job_description'] ?? ''),
            'datePosted'     => $job['published_at'] ?? $job['created_at'] ?? now()->toAtomString(),
            'validThrough'   => isset($job['deadline'])
                                    ? \Carbon\Carbon::parse($job['deadline'])->endOfDay()->toAtomString()
                                    : null,
            'employmentType' => $this->mapEmploymentType($job['job_type']['slug'] ?? $job['employment_type'] ?? null),
            'url'            => config('api.web_app.url') . '/jobs/' . ($job['slug'] ?? ''),
            'directApply'    => true,

            'identifier' => [
                '@type' => 'PropertyValue',
                'name'  => 'Job ID',
                'value' => $job['id'] ?? null,
            ],

            'hiringOrganization' => [
                '@type'  => 'Organization',
                'name'   => $job['company']['name'] ?? '',
                'sameAs' => $job['company']['website'] ?? null,
                'logo'   => $job['company']['logo_url'] ?? $job['company']['logo'] ?? null,
                'url'    => $job['company']['website'] ?? null,
            ],

            'jobLocation' => [
                '@type'   => 'Place',
                'address' => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => $job['street_address'] ?? $job['duty_station'] ?? null,
                    'addressLocality' => $job['job_location']['district'] ?? $job['duty_station'] ?? null,
                    'addressRegion'   => $job['job_location']['district'] ?? null,
                    'addressCountry'  => $job['job_location']['country'] ?? 'UG',
                    'postalCode'      => $job['job_location']['postal_code'] ?? null,
                ],
            ],
        ];

        // ─── jobLocationType ──────────────────────────────────────────────────
        // Google ONLY accepts 'TELECOMMUTE' for remote jobs.
        // For on-site or hybrid jobs: OMIT the field entirely.
        $locationType = $job['location_type'] ?? null;
        if ($locationType === 'remote') {
            $data['jobLocationType'] = 'TELECOMMUTE';
            // For remote jobs, applicant location requirements are needed
            $data['applicantLocationRequirements'] = [
                '@type' => 'Country',
                'name'  => 'Uganda',
            ];
        }
        // On-site / hybrid / null → do NOT set jobLocationType at all

        // ─── Salary ───────────────────────────────────────────────────────────
        // Priority: 1) explicit salary_amount, 2) salary_range, 3) industry estimate
        if (!empty($job['salary_amount'])) {
            $data['baseSalary'] = [
                '@type'    => 'MonetaryAmount',
                'currency' => $job['currency'] ?? 'UGX',
                'value'    => [
                    '@type'    => 'QuantitativeValue',
                    'value'    => (float) $job['salary_amount'],
                    'unitText' => strtoupper($job['payment_period'] ?? 'MONTH'),
                ],
            ];
        } elseif (!empty($job['salary_range']['min_salary']) || !empty($job['salary_range']['max_salary'])) {
            $data['baseSalary'] = [
                '@type'    => 'MonetaryAmount',
                'currency' => $job['salary_range']['currency'] ?? 'UGX',
                'value'    => [
                    '@type'    => 'QuantitativeValue',
                    'minValue' => (float) ($job['salary_range']['min_salary'] ?? 0),
                    'maxValue' => (float) ($job['salary_range']['max_salary'] ?? 0),
                    'unitText' => 'MONTH',
                ],
            ];
        } elseif (!empty($job['industry']['estimated_salary'])) {
            // Fallback: use industry-level estimated salary as a range hint
            $estimated = (float) $job['industry']['estimated_salary'];
            $data['estimatedSalary'] = [
                '@type'         => 'MonetaryAmountDistribution',
                'name'          => 'base',
                'currency'      => 'UGX',
                'duration'      => 'P1M', // per month (ISO 8601)
                'percentile10'  => round($estimated * 0.7),
                'median'        => $estimated,
                'percentile90'  => round($estimated * 1.3),
            ];
        }
        // If none of the above → baseSalary is simply omitted (warning stays, but it's optional)

        // ─── Experience ───────────────────────────────────────────────────────
        if (!empty($job['experience_level']['min_years'])) {
            $data['experienceRequirements'] = [
                '@type'              => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => (int) $job['experience_level']['min_years'] * 12,
            ];
        }

        // ─── Education ────────────────────────────────────────────────────────
        if (!empty($job['education_level']['name'])) {
            $credentialCategory = $this->mapEducationLevel($job['education_level']['name']);
            if ($credentialCategory) {
                $data['educationRequirements'] = [
                    '@type'              => 'EducationalOccupationalCredential',
                    'credentialCategory' => $credentialCategory,
                ];
            }
        }

        // ─── Category & Industry ──────────────────────────────────────────────
        if (!empty($job['job_category']['name'])) {
            $data['occupationalCategory'] = $job['job_category']['name'];
        }

        if (!empty($job['industry']['name'])) {
            $data['industry'] = $job['industry']['name'];
        }

        // ─── Skills / Responsibilities / Qualifications ───────────────────────
        if (!empty($job['skills'])) {
            $data['skills'] = strip_tags($job['skills']);
        }

        if (!empty($job['responsibilities'])) {
            $data['responsibilities'] = strip_tags($job['responsibilities']);
        }

        if (!empty($job['qualifications'])) {
            $data['qualifications'] = strip_tags($job['qualifications']);
        }

        // ─── Application URL ──────────────────────────────────────────────────
        if (!empty($job['application_procedure'])) {
            preg_match('/(https?:\/\/[^\s]+)/', $job['application_procedure'], $matches);
            if (!empty($matches[0])) {
                $data['applicationUrl'] = $matches[0];
            }
        }

        // ─── Hiring Contact ───────────────────────────────────────────────────
        if (!empty($job['email']) || !empty($job['telephone'])) {
            $data['hiringContact'] = array_filter([
                '@type'             => 'ContactPoint',
                'email'             => $job['email'] ?? null,
                'telephone'         => $job['telephone'] ?? null,
                'contactType'       => 'hiring',
                'availableLanguage' => ['English'],
            ]);
        }

        return array_filter($data, fn($v) => $v !== null && $v !== '' && $v !== []);
    }

    // ─── Mapping Helpers ──────────────────────────────────────────────────────

    private function mapEmploymentType(?string $type): string
    {
        if (!$type) return 'FULL_TIME';

        return match(strtolower($type)) {
            'full-time', 'full_time', 'fulltime'         => 'FULL_TIME',
            'part-time', 'part_time', 'parttime'         => 'PART_TIME',
            'contract', 'contractor', 'freelance'        => 'CONTRACTOR',
            'internship', 'intern'                       => 'INTERN',
            'temporary', 'temp'                          => 'TEMPORARY',
            'volunteer'                                  => 'VOLUNTEER',
            default                                      => 'FULL_TIME',
        };
    }

    private function mapEducationLevel(?string $level): ?string
    {
        $level = strtolower(trim($level ?? ''));

        return match(true) {
            str_contains($level, 'doctorate') || str_contains($level, 'phd')
                => 'doctorate',
            str_contains($level, 'master') || str_contains($level, 'postgraduate') || str_contains($level, 'msc') || str_contains($level, 'mba')
                => 'master_degree',
            str_contains($level, 'bachelor') || str_contains($level, 'degree') || str_contains($level, 'bsc') || str_contains($level, 'ba ')
                => 'bachelor_degree',
            str_contains($level, 'associate') || str_contains($level, 'diploma')
                => 'associate_degree',
            str_contains($level, 'certificate')
                => 'professional_certificate',
            str_contains($level, 'high school') || str_contains($level, 'secondary') || str_contains($level, 'o level') || str_contains($level, 'a level')
                => 'high_school',
            default => null,
        };
    }
}