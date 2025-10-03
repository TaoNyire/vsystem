<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voter;
use Carbon\Carbon;

class VoterSeeder extends Seeder
{
    public function run(): void
    {
        $voters = [
            [
                'voter_registration_number' => 'BIS/23/SS/001',
                'last_name' => 'CHAIMA',
                'first_name' => 'INNOCENT',
                'gender' => 'M',
                'status' => 'Not Registered',
                'registration_date' => Carbon::parse('2025-03-07'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency1 Ward1',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/002',
                'last_name' => 'CHIBALE',
                'first_name' => 'CLIFFORD',
                'gender' => 'M',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-03-26'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency1 Ward2',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/003',
                'last_name' => 'KAPITO',
                'first_name' => 'MARY',
                'gender' => 'F',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-02-15'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency2 Ward1',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/004',
                'last_name' => 'PHIRI',
                'first_name' => 'JAMES',
                'gender' => 'M',
                'status' => 'Not Registered',
                'registration_date' => Carbon::parse('2025-01-30'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency2 Ward2',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/005',
                'last_name' => 'CHIKWAWA',
                'first_name' => 'GRACE',
                'gender' => 'F',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-04-02'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency3 Ward1',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/006',
                'last_name' => 'MWALE',
                'first_name' => 'PETER',
                'gender' => 'M',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-03-18'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency3 Ward2',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/007',
                'last_name' => 'NGOMA',
                'first_name' => 'ANNA',
                'gender' => 'F',
                'status' => 'Not Registered',
                'registration_date' => Carbon::parse('2025-02-20'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency4 Ward1',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/008',
                'last_name' => 'CHITAYO',
                'first_name' => 'DAVID',
                'gender' => 'M',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-03-10'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency4 Ward2',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/009',
                'last_name' => 'MWANZA',
                'first_name' => 'LUCY',
                'gender' => 'F',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-01-25'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency5 Ward1',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/010',
                'last_name' => 'KUNDA',
                'first_name' => 'JOHN',
                'gender' => 'M',
                'status' => 'Not Registered',
                'registration_date' => Carbon::parse('2025-04-05'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency5 Ward2',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/011',
                'last_name' => 'PHIRI',
                'first_name' => 'SARAH',
                'gender' => 'F',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-02-28'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency6 Ward1',
            ],
            [
                'voter_registration_number' => 'BIS/23/SS/012',
                'last_name' => 'KAPANDA',
                'first_name' => 'MICHAEL',
                'gender' => 'M',
                'status' => 'Registered',
                'registration_date' => Carbon::parse('2025-03-15'),
                'categories' => 'VOTERS',
                'constituency_ward' => 'Constituency6 Ward2',
            ],
        ];

        foreach ($voters as $voter) {
            Voter::updateOrCreate(
                ['voter_registration_number' => $voter['voter_registration_number']],
                [
                    'last_name' => $voter['last_name'],
                    'first_name' => $voter['first_name'],
                    'gender' => $voter['gender'],
                    'status' => $voter['status'],
                    'registration_date' => $voter['registration_date'],
                    'categories' => $voter['categories'],
                    'constituency_ward' => $voter['constituency_ward'],
                ]
            );
        }
    }
}
