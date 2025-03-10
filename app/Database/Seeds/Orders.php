<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Orders extends Seeder
{
    public function run()
    {
        // Initialize Faker
        $faker = Factory::create();

        // Example variable for creater_user_id
        $createrUserId = 4; // This value can be dynamic

        // Loop to insert 10 records
        for ($i = 0; $i < 50; $i++) {
            $data = [
                'creater_user_id' => $createrUserId,
                'checkout_session_id' => $faker->uuid,
                'order_number' => 'ORD' . $faker->unique()->randomNumber(5),
                'order_status' => $faker->randomElement(['draft', 'ai_processing', 'ai_processed', 'reviewed', 'approved', 'shared']),
                'billed_amount' => $faker->optional()->randomFloat(2, 100, 1000), // Random amount between $100 and $1000
                'billed_currency' => $faker->randomElement(['USD', 'EUR']),
                'claim_type' => $faker->randomElement(['bodily_injury', 'disability_claim', 'nursing_home_negligence', 'workers_compensation']),
                'report_type' => $faker->randomElement(['medical_chronology', 'billing_summary', 'medical_chronology_and_billing_summary']),
                'claim_number' => 'CLM' . $faker->unique()->randomNumber(5),
                'case_name' => $faker->sentence(3),
                'plaintiff_first_name' => $faker->firstName,
                'plaintiff_last_name' => $faker->lastName,
                'plaintiff_dob' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d H:i:s'), // Between 18 and 60 years old
                'plaintiff_gender' => $faker->randomElement(['male', 'female']),
                'defendant_first_name' => $faker->firstName,
                'defendant_last_name' => $faker->lastName,
                'defendant_company_name' => $faker->company,
                'date_of_incident' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'),
                'location_of_accident' => $faker->city . ', ' . $faker->state,
                'injury_areas' => implode(',', $faker->randomElements([
                    'head_and_neck', 
                    'upper_extremity', 
                    'torso', 
                    'back', 
                    'lower_extremity', 
                    'internal_organs', 
                    'skin', 
                    'circulatory_and_nervous_systems'
                ], $faker->numberBetween(1, 3))),
                'exhibit_count' => $faker->numberBetween(1, 10),
                'page_count' => $faker->numberBetween(10, 100),
                'time_created' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'time_paid' => $faker->optional() ? $faker->dateTimeThisYear()->format('Y-m-d H:i:s') : null,
                'time_ml_processed' => $faker->optional() ? $faker->dateTimeThisYear()->format('Y-m-d H:i:s') : null,
                'reviewer_user_id' => $faker->optional()->randomDigitNotNull,
                'time_fully_reviewed' => $faker->optional() ? $faker->dateTimeThisYear()->format('Y-m-d H:i:s') : null,
                'fully_reviewed' => $faker->boolean,
                'approver_user_id' => $faker->optional()->randomDigitNotNull,
                'time_approval' => $faker->optional() ? $faker->dateTimeThisYear()->format('Y-m-d H:i:s') : null,
                'approved' => $faker->boolean,
                'approval_notice_for_reviewer' => $faker->optional()->text(50),
                'time_due' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s'),
                'number_of_downloads' => $faker->numberBetween(0, 20),
                'time_last_download' => $faker->optional() ? $faker->dateTimeThisYear()->format('Y-m-d H:i:s') : null,
            ];

            // Insert the generated data into the 'orders' table
            $this->db->table('orders')->insert($data);
        }
    }
}
