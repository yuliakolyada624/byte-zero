<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Modules\Transactions\Models\TransactionsModel;
use App\Modules\Orders\Models\OrdersModel;
use App\Modules\User\Models\UserModel;

class TransactionsSeeder extends Seeder
{
    public function run()
    {
        // Load the Faker library
        $faker = \Faker\Factory::create();

        // Instantiate the TransactionsModel
        $transactionsModel = new TransactionsModel();

        // Instantiate other models if needed
        $ordersModel = new OrdersModel();
        $userModel = new UserModel();

        // Get existing user IDs
        $userIds = $userModel->select('id')->findAll();
        $userIds = array_column($userIds, 'id');

        // Get existing order IDs
        $orderIds = $ordersModel->select('id')->findAll();
        $orderIds = array_column($orderIds, 'id');

        // If there are no users or orders, we need to create some
        /*if (empty($userIds)) {
            // Create dummy users
            for ($i = 0; $i < 5; $i++) {
                $userData = [
                    'username' => $faker->userName,
                    'email'    => $faker->email,
                    'password' => password_hash('password', PASSWORD_BCRYPT),
                ];
                $userId = $userModel->insert($userData);
                $userIds[] = $userId;
            }
        }*/

        if (empty($orderIds)) {
            // Create dummy orders
            for ($i = 0; $i < 5; $i++) {
                $orderData = [
                    'order_number'        => $ordersModel->generateUniqueOrderId(),
                    'creater_user_id'     => $faker->randomElement($userIds),
                    'order_status'        => 'completed',
                    'billed_amount'       => $faker->randomFloat(2, 100, 1000),
                    'billed_currency'     => 'USD',
                    'claim_type'          => $faker->randomElement(['body_injury', 'disability_claim', 'nursing_home_negligence', 'workers_compensation']),
                    'report_type'         => $faker->randomElement(['medical_chronology', 'billing_summary', 'medical_chronology_and_billing_summary']),
                    'time_created'        => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                    // Add other required fields as necessary
                ];
                $orderId = $ordersModel->insert($orderData);
                $orderIds[] = $orderId;
            }
        }

        // Now, create 30 transactions
        for ($i = 0; $i < 30; $i++) {
            $data = [
                'transaction_number' => $transactionsModel->generateUniqueTransactionNumber(),
                'user_id'                       => 4, // $faker->randomElement($userIds)
                'order_id'                      => $faker->randomElement($orderIds),
                'checkout_session_id'           => $faker->uuid,
                'gateway_name'                  => $faker->randomElement(['Stripe', 'PayPal', 'Authorize.Net']),
                'authorization_amount'          => $faker->randomFloat(2, 10000, 100000),
                'authorization_currency'        => 'USD',
                'card_type'                     => $faker->randomElement(['Visa', 'MasterCard', 'American Express']),
                'card_ends_in'                  => $faker->numerify('####'),
                'authorization_transaction_token' => $faker->uuid,
                'capture_transaction_token'     => $faker->uuid,
                'capture_gateway_transaction_id' => $faker->uuid,
                'log'                           => $faker->text(200),
                'payment_card_data'             => json_encode([
                    'cardholder_name' => $faker->name,
                    'card_number'     => $faker->creditCardNumber,
                    'expiry_date'     => $faker->creditCardExpirationDateString,
                ]),
                'is_refund'                     => $faker->boolean(20) ? 1 : null, // 20% chance of being a refund
                'created_at'                    => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'updated_at'                    => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ];

            // Insert the transaction with a unique transaction number
            $transactionsModel->insert($data);
        }
    }
}
