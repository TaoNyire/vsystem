<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voter;
use App\Models\Candidate;
use App\Models\Position;
use Carbon\Carbon;

class CandidatesAndVotersManualSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure positions exist
        $positionsMap = [
            'President' => Position::firstOrCreate(['name' => 'President'])->id,
            'MP' => Position::firstOrCreate(['name' => 'MP'])->id,
            'Councilors' => Position::firstOrCreate(['name' => 'Councilors'])->id,
        ];

        $rows = [
            // [vrn, last, first, gender, status, date, extra]
            ['BIT/23/ME/069', 'NGUWO', 'GRACIOUS', 'M', 'Registered', '7-May-25', ''],
            ['BIT/24/ME/014', 'PHIRI', 'THANDIWE', 'F', 'Not Registered', '19-Feb-25', ''],
            // CANDIDATES and VOTERS
            ['BIT/24/ME/015', 'SAMBAKUSI', 'MICHEAL', 'M', 'Registered', '21-Feb-25', 'PRESIDENTS'],
            ['MSE/21/SS/001', 'AFFONSO', 'CHISOMO', 'M', 'Registered', '5-Mar-25', ''],
            ['MSE/23/ME/002', 'CHAKWANIRA', 'ALEX', 'M', 'Not Registered', '18-Feb-25', ''],
            ['MSE/21/SS/004', 'CHIKANAMOYO', 'MELVIN', 'M', 'Registered', '5-Mar-25', ''],
            ['MSE/23/ME/004', 'Juma', 'Juwadu', 'M', 'Registered', '25-Feb-25', ''],
            ['MSE/21/SS/016', 'KALULU', 'WATIPA', 'F', 'Registered', '6-Mar-25', ''],
            ["MSE/21/SS/017", "KAM'BWEMBA", 'ANGEL', 'F', 'Registered', '5-Mar-25', ''],
            ['MSE/19/SS/014', 'KAMANGA', 'MCNAIR', 'M', 'Registered', '5-Mar-25', ''],
            ['MSE/21/SS/020', 'KUMILAMBE', 'ALINAFE', 'F', 'Not Registered', '2-Mar-25', ''],
            ["MSE/21/SS/022", 'KWAITANA', 'SHARON', 'F', 'Registered', '19-Feb-25', "MP's Constituency1"],
            ['MSE/21/SS/023', 'MAGWAZA', 'JENIFER', 'F', 'Registered', '6-Mar-25', ''],
            ['MSE/21/SS/026', 'MASUNGU', 'HAJRA', 'F', 'Registered', '6-Mar-25', ''],
            ['MSE/21/SS/029', 'MHONE', 'PYPHIAS', 'M', 'Registered', '5-Mar-25', 'Constuency 2'],
            ['MSE/21/SS/035', 'MWAKASUNGULA', 'FRANK', 'M', 'Not Registered', '5-Mar-25', ''],
            ['MSE/21/SS/040', 'NSINI', 'VYSON', 'M', 'Registered', '6-Mar-25', ''],
            ['MSE/21/SS/045', 'PHIRI', 'INNOCENT', 'M', 'Registered', '6-Mar-25', 'Councilors Ward 1 Constuency1'],
            ['MSE/21/SS/047', 'PHIRI', 'SINOYA', 'M', 'Registered', '6-Mar-25', ''],
            ['MSE/21/SS/046', 'PHIRI', 'RICHARD', 'M', 'Registered', '6-Mar-25', ''],
            ['MSE/20/SS/033', 'SINJONJO', 'SAYNAT', 'F', 'Not Registered', '5-Mar-25', 'Ward1 Constuency2'],
            ['MSE/20/SS/035', 'TEMBO', 'RABECCA', 'F', 'Registered', '12-Mar-25', ''],
            ['BIT/24/ME/012', 'MKANDAWIRE', 'KENNEDY', 'M', 'Registered', '18-Feb-25', ''],
        ];

        foreach ($rows as $r) {
            [$vrn, $last, $first, $gender, $status, $dateStr, $extra] = $r;

            $regDate = $this->parseDate($dateStr);

            $constituencyWard = null;
            if ($extra) {
                // Capture any constituency/ward note as-is to store for the voter
                if (stripos($extra, 'constituency') !== false || stripos($extra, 'constuency') !== false) {
                    $constituencyWard = trim($extra);
                } elseif (stripos($extra, 'ward') !== false) {
                    $constituencyWard = trim($extra);
                }
            }

            // Upsert voter
            Voter::updateOrCreate(
                ['voter_registration_number' => $vrn],
                [
                    'last_name' => $last,
                    'first_name' => $first,
                    'gender' => strtoupper($gender) === 'F' ? 'F' : 'M',
                    'status' => $status === 'Not Registered' ? 'Not Registered' : 'Registered',
                    'registration_date' => $regDate,
                    'categories' => 'VOTERS',
                    'constituency_ward' => $constituencyWard,
                ]
            );

            // Detect candidate position from the extra field
            $candidatePosition = $this->detectPosition($extra);
            if ($candidatePosition && isset($positionsMap[$candidatePosition])) {
                Candidate::firstOrCreate(
                    [
                        'first_name' => $first,
                        'last_name' => $last,
                        'position_id' => $positionsMap[$candidatePosition],
                    ],
                    [
                        'party_id' => null,
                        'status' => ($status === 'Not Registered') ? 'Not Registered' : 'Registered',
                    ]
                );
            }
        }
    }

    private function parseDate(string $dateStr): string
    {
        try {
            return Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Throwable $e) {
            return now()->toDateString();
        }
    }

    private function detectPosition(?string $extra): ?string
    {
        if (!$extra) return null;
        $e = strtolower($extra);
        if (str_contains($e, 'president')) {
            return 'President';
        }
        if (str_contains($e, "mp")) { // covers "MP", "MP's"
            return 'MP';
        }
        if (str_contains($e, 'councilor') || str_contains($e, 'councillor') || str_contains($e, 'councilors')) {
            return 'Councilors';
        }
        return null;
    }
}
