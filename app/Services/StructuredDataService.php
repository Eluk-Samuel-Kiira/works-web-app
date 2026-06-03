<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class StructuredDataService
{
    // =========================================================
    // MAIN ENTRY POINT
    // =========================================================
    public function jobPosting(array $job): array
    {
        // Log the job location data for debugging
        // Log::info('StructuredDataService: Generating schema for job', [
        //     'job_id' => $job['id'] ?? null,
        //     'job_title' => $job['job_title'] ?? null,
        //     'country' => $job['job_location']['country'] ?? null,
        //     'district' => $job['job_location']['district'] ?? null,
        // ]);
        
        $data = [
            '@context'       => 'https://schema.org/',
            '@type'          => 'JobPosting',
            'title'          => $job['job_title'] ?? '',
            'description'    => $this->buildDescription($job),
            'datePosted'     => isset($job['published_at'])
                                    ? \Carbon\Carbon::parse($job['published_at'])->toAtomString()
                                    : (isset($job['created_at'])
                                        ? \Carbon\Carbon::parse($job['created_at'])->toAtomString()
                                        : now()->toAtomString()),
            'validThrough'   => isset($job['deadline'])
                                    ? \Carbon\Carbon::parse($job['deadline'])->endOfDay()->toAtomString()
                                    : now()->addWeeks(4)->endOfDay()->toAtomString(),
            'employmentType' => $this->mapEmploymentType(
                                    $job['job_type']['slug'] ?? $job['employment_type'] ?? null
                                ),
            'url'            => $this->getJobUrl($job),
            'directApply'    => true,

            'identifier' => [
                '@type' => 'PropertyValue',
                'name'  => 'Job ID',
                'value' => (string) ($job['id'] ?? ''),
            ],

            'hiringOrganization' => array_filter([
                '@type'  => 'Organization',
                'name'   => $job['company']['name'] ?? '',
                'sameAs' => $job['company']['website'] ?? null,
                'logo'   => $job['company']['logo_url'] ?? $job['company']['logo'] ?? null,
                'url'    => $job['company']['website'] ?? null,
            ], fn($v) => $v !== null && $v !== ''),

            // ⭐ COUNTRY-SPECIFIC JOB LOCATION
            'jobLocation' => $this->buildJobLocation($job),
        ];

        // ⭐ JOB LOCATION TYPE
        if (($job['location_type'] ?? null) === 'remote') {
            $data['jobLocationType'] = 'TELECOMMUTE';
            $data['applicantLocationRequirements'] = [
                '@type' => 'Country',
                'name'  => $this->getCountryNameFromJob($job),
            ];
        }

        // ⭐ SALARY
        $data['baseSalary'] = $this->buildSalary($job);

        // ⭐ EXPERIENCE REQUIREMENTS
        if (!empty($job['experience_level']['min_years'])) {
            $data['experienceRequirements'] = [
                '@type'              => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => (int) $job['experience_level']['min_years'] * 12,
            ];
        }

        // ⭐ EDUCATION REQUIREMENTS
        $credentialCategory = $this->mapEducationLevel($job['education_level']['name'] ?? null);
        if ($credentialCategory) {
            $data['educationRequirements'] = [
                '@type'              => 'EducationalOccupationalCredential',
                'credentialCategory' => $credentialCategory,
            ];
        }

        // ⭐ CATEGORY & INDUSTRY
        if (!empty($job['job_category']['name'])) {
            $data['occupationalCategory'] = $job['job_category']['name'];
        }
        if (!empty($job['industry']['name'])) {
            $data['industry'] = $job['industry']['name'];
        }

        // ⭐ SKILLS / RESPONSIBILITIES / QUALIFICATIONS
        if (!empty($job['skills'])) {
            $data['skills'] = strip_tags($job['skills']);
        }
        if (!empty($job['responsibilities'])) {
            $data['responsibilities'] = strip_tags($job['responsibilities']);
        }
        if (!empty($job['qualifications'])) {
            $data['qualifications'] = strip_tags($job['qualifications']);
        }

        // ⭐ APPLICATION URL
        if (!empty($job['application_procedure'])) {
            preg_match('/(https?:\/\/[^\s]+)/', $job['application_procedure'], $matches);
            if (!empty($matches[0])) {
                $data['applicationUrl'] = $matches[0];
            }
        }

        // ⭐ HIRING CONTACT
        if (!empty($job['email']) || !empty($job['telephone'])) {
            $data['hiringContact'] = array_filter([
                '@type'             => 'ContactPoint',
                'email'             => $job['email'] ?? null,
                'telephone'         => $job['telephone'] ?? null,
                'contactType'       => 'hiring',
                'availableLanguage' => ['English'],
            ], fn($v) => $v !== null && $v !== '');
        }

        Log::info('StructuredDataService: Schema generated', [
            'job_id' => $job['id'] ?? null,
            'has_location' => isset($data['jobLocation']),
            'country_in_schema' => $data['jobLocation']['address']['addressCountry'] ?? null,
        ]);

        return array_filter($data, fn($v) => $v !== null && $v !== '' && $v !== []);
    }

    // =========================================================
    // JOB URL BUILDER (Country-specific)
    // =========================================================
    private function getJobUrl(array $job): string
    {
        $webUrl = rtrim(config('api.web_app.url'), '/');
        $slug = $job['slug'] ?? '';
        
        // Get country code from job location
        $countryCode = $this->getCountryCodeFromJob($job);
        
        if ($countryCode && $countryCode !== 'ug') {
            // Country-specific URL: /ke/jobs/{slug}
            return $webUrl . '/' . strtolower($countryCode) . '/jobs/' . $slug;
        }
        
        // Default URL
        return $webUrl . '/jobs/' . $slug;
    }
    
    // =========================================================
    // GET COUNTRY CODE FROM JOB
    // =========================================================
    private function getCountryCodeFromJob(array $job): ?string
    {
        // Check if job has location with country
        if (!empty($job['job_location']['country'])) {
            return strtolower($job['job_location']['country']);
        }
        
        // Fallback to Uganda
        return 'ug';
    }
    
    // =========================================================
    // GET COUNTRY NAME FROM JOB
    // =========================================================
    private function getCountryNameFromJob(array $job): string
    {
        $countryNames = [
            'UG' => 'Uganda',
            'KE' => 'Kenya',
            'TZ' => 'Tanzania',
            'RW' => 'Rwanda',
            'BI' => 'Burundi',
            'SS' => 'South Sudan',
            'CD' => 'DR Congo',
            'NG' => 'Nigeria',
            'ZA' => 'South Africa',
            'GH' => 'Ghana',
            'ET' => 'Ethiopia',
            'EG' => 'Egypt',
        ];
        
        $countryCode = $this->getCountryCodeFromJob($job);
        
        return $countryNames[strtoupper($countryCode)] ?? 'Uganda';
    }

    // =========================================================
    // DESCRIPTION BUILDER
    // =========================================================
    private function buildDescription(array $job): string
    {
        $parts = [];

        if (!empty($job['job_description'])) {
            $parts[] = strip_tags($job['job_description']);
        }
        if (!empty($job['responsibilities'])) {
            $parts[] = 'Key Responsibilities: ' . strip_tags($job['responsibilities']);
        }
        if (!empty($job['qualifications'])) {
            $parts[] = 'Qualifications: ' . strip_tags($job['qualifications']);
        }

        $combined = implode("\n\n", array_filter($parts));

        if (empty($combined)) {
            $combined = ($job['job_title'] ?? 'Job Opportunity')
                      . ' at ' . ($job['company']['name'] ?? 'a company')
                      . ' in ' . $this->getCountryNameFromJob($job) . '.';
        }

        return $combined;
    }

    // =========================================================
    // JOB LOCATION BUILDER (Country-specific)
    // =========================================================
    private function buildJobLocation(array $job): array
    {
        // Get location data
        $location = $job['job_location'] ?? [];
        $countryCode = $location['country'] ?? 'UG';
        $countryName = $this->getCountryNameFromJob($job);
        $district = $location['district'] ?? $job['duty_station'] ?? 'Kampala';
        $streetAddress = $job['street_address'] ?? $job['duty_station'] ?? null;
        
        // Log location data for debugging
        Log::info('Building job location for schema', [
            'job_id' => $job['id'] ?? null,
            'country_code' => $countryCode,
            'country_name' => $countryName,
            'district' => $district,
        ]);
        
        $address = array_filter([
            '@type'           => 'PostalAddress',
            'streetAddress'   => $streetAddress,
            'addressLocality' => $district,
            'addressRegion'   => $district,
            'addressCountry'  => $countryName,
            'postalCode'      => $this->guessPostalCode($district),
        ], fn($v) => $v !== null && $v !== '');

        $address['@type'] = 'PostalAddress';

        return [
            '@type'   => 'Place',
            'address' => $address,
        ];
    }

    // =========================================================
    // POSTAL CODE GUESSER
    // =========================================================
    private function guessPostalCode(string $locality): string
    {
        $map = [
            'kampala'     => '10101',
            'entebbe'     => '10108',
            'jinja'       => '20101',
            'mbarara'     => '30101',
            'gulu'        => '40101',
            'lira'        => '40201',
            'mbale'       => '20201',
            'masaka'      => '30201',
            'fort portal' => '30301',
            'kabale'      => '30401',
            'arua'        => '40301',
            'soroti'      => '20301',
            'tororo'      => '20401',
            'nairobi'     => '00100',
            'mombasa'     => '80100',
            'kisumu'      => '40100',
            'dar es salaam' => '11101',
            'arusha'      => '23101',
            'kigali'      => '00000',
        ];

        $lower = strtolower(trim($locality));

        foreach ($map as $city => $code) {
            if (str_contains($lower, $city)) {
                return $code;
            }
        }

        return '10101';
    }

    // =========================================================
    // SALARY BUILDER
    // =========================================================
    private function buildSalary(array $job): array
    {
        $currency = $job['currency'] ?? $job['salary_range']['currency'] ?? 'UGX';
        $period = strtoupper($job['payment_period'] ?? 'MONTH');

        // 1. Explicit salary amount
        if (!empty($job['salary_amount']) && (float) $job['salary_amount'] > 0) {
            return [
                '@type'    => 'MonetaryAmount',
                'currency' => $currency,
                'value'    => [
                    '@type'    => 'QuantitativeValue',
                    'value'    => (float) $job['salary_amount'],
                    'unitText' => $period,
                ],
            ];
        }

        // 2. Salary range object
        if (!empty($job['salary_range']['min_salary']) || !empty($job['salary_range']['max_salary'])) {
            return [
                '@type'    => 'MonetaryAmount',
                'currency' => $currency,
                'value'    => [
                    '@type'    => 'QuantitativeValue',
                    'minValue' => (float) ($job['salary_range']['min_salary'] ?? 0),
                    'maxValue' => (float) ($job['salary_range']['max_salary'] ?? 0),
                    'unitText' => 'MONTH',
                ],
            ];
        }

        // 3. Industry estimate or fallback
        $countryCode = $this->getCountryCodeFromJob($job);
        $isKenya = $countryCode === 'ke';
        $isTanzania = $countryCode === 'tz';
        
        $experienceName = strtolower($job['experience_level']['name'] ?? 'entry level');
        
        if ($isKenya) {
            // Kenya market rates (KES)
            [$min, $max] = match(true) {
                str_contains($experienceName, 'executive') => [150_000, 500_000],
                str_contains($experienceName, 'senior')    => [80_000,  200_000],
                str_contains($experienceName, 'mid')       => [50_000,  100_000],
                str_contains($experienceName, 'junior')    => [25_000,   50_000],
                default                                    => [15_000,   35_000],
            };
            $currency = 'KES';
        } elseif ($isTanzania) {
            // Tanzania market rates (TZS)
            [$min, $max] = match(true) {
                str_contains($experienceName, 'executive') => [1_500_000, 5_000_000],
                str_contains($experienceName, 'senior')    => [800_000,   2_000_000],
                str_contains($experienceName, 'mid')       => [400_000,   1_000_000],
                str_contains($experienceName, 'junior')    => [200_000,    500_000],
                default                                    => [100_000,    300_000],
            };
            $currency = 'TZS';
        } else {
            // Uganda market rates (UGX)
            [$min, $max] = match(true) {
                str_contains($experienceName, 'executive') => [5_000_000, 15_000_000],
                str_contains($experienceName, 'senior')    => [2_500_000,  7_000_000],
                str_contains($experienceName, 'mid')       => [1_200_000,  3_500_000],
                str_contains($experienceName, 'junior')    => [600_000,    1_500_000],
                default                                    => [300_000,    800_000],
            };
            $currency = 'UGX';
        }

        return [
            '@type'    => 'MonetaryAmount',
            'currency' => $currency,
            'value'    => [
                '@type'    => 'QuantitativeValue',
                'minValue' => $min,
                'maxValue' => $max,
                'unitText' => 'MONTH',
            ],
        ];
    }

    // =========================================================
    // EMPLOYMENT TYPE MAPPER
    // =========================================================
    private function mapEmploymentType(?string $type): string
    {
        if (!$type) return 'FULL_TIME';

        return match(strtolower($type)) {
            'full-time', 'full_time', 'fulltime'  => 'FULL_TIME',
            'part-time', 'part_time', 'parttime'  => 'PART_TIME',
            'contract', 'contractor', 'freelance' => 'CONTRACTOR',
            'internship', 'intern'                => 'INTERN',
            'temporary', 'temp'                   => 'TEMPORARY',
            'volunteer'                           => 'VOLUNTEER',
            default                               => 'FULL_TIME',
        };
    }

    // =========================================================
    // EDUCATION LEVEL MAPPER
    // =========================================================
    private function mapEducationLevel(?string $level): ?string
    {
        if (!$level) return null;

        $l = strtolower(trim($level));

        return match(true) {
            str_contains($l, 'phd') || str_contains($l, 'doctorate')
                => 'doctoral degree',

            str_contains($l, 'master') || str_contains($l, 'msc')
                || str_contains($l, 'mba') || str_contains($l, 'postgraduate')
                => 'master degree',

            str_contains($l, 'bachelor') || str_contains($l, 'degree')
                || str_contains($l, 'bsc') || str_contains($l, 'b.a')
                => 'bachelor degree',

            str_contains($l, 'associate') || str_contains($l, 'diploma')
                => 'associate degree',

            str_contains($l, 'high school') || str_contains($l, 'secondary')
                || str_contains($l, 'o level') || str_contains($l, 'a level')
                => 'high school',

            str_contains($l, 'certificate') => 'associate degree',

            default => null,
        };
    }
}