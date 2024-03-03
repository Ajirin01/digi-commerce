<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WithdrawalController extends Controller
{
    public function verifyAccount(Request $request){
        // Get the account number and bank code from the request
        $accountNumber = $request->input('account_number');
        $bankCode = $request->input('bank_name');

        // Initialize Guzzle HTTP client
        $client = new Client();

        // Make a request to the Paystack API
        try {
            $response = $client->request('GET', 'https://api.paystack.co/bank/resolve?account_number='.$accountNumber.'&bank_code='.$bankCode, [
                'headers' => [
                    'Authorization' => 'Bearer '. env('PAYSTACK_SECRET_KEY'),
                    'Accept' => 'application/json',
                ],
            ]);

            // Decode the response JSON
            $data = json_decode($response->getBody(), true);

            // Check if the account details were resolved successfully
            if ($response->getStatusCode() == 200 && $data['status'] == true) {
                // Account details are valid
                $accountInformation = $data['data'];
                // Proceed with further processing or return the account name to the client
                return response()->json(['account_information' => $accountInformation]);
            } else {
                // Account details are invalid
                return response()->json(['error' => 'Invalid account details'], 400);
            }
        } catch (\Exception $e) {
            // Handle any errors that occur during the request
            return response()->json(['error' => 'Failed to verify account details'], 500);
        }
    }
}
