<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;
use Illuminate\Support\Facades\Cache;

/**
 * Controller to fetch data from CSV
 *
 * Class InsuranceController
 * @package App\Http\Controllers
 */
class InsuranceController extends Controller
{
     /**
     * Get insurance list with all details
     * @return json
     */
    public function getInsuranceList()
    {
    	try
    	{
            Cache::pull('insurance_lists');
            //Retrieve all insurance data from the cache
            $minutes = env('SESSION_LIFETIME','60');
            $records = Cache::remember('insurance_lists', $minutes, function() {
                // read file from storage
                $csvFilePath = storage_path('app/transactions.csv'); 
                $csv = Reader::createFromPath($csvFilePath, 'r');
                // set CSV header offset to 0
                $csv->setHeaderOffset(0); 
                // fetch all records start from 0 row
                $aaInsuranceData = $csv->getRecords(); 
                foreach ($aaInsuranceData as $key => $aInsuranceData) 
                {
                    $aInsuranceData['currency'] = strtoupper($aInsuranceData['currency((usd,gbp))']);
                    unset($aInsuranceData['currency((usd,gbp))']);
                    $arrInsuranceData[] = $aInsuranceData;
                }
                return $arrInsuranceData;
            });
            
            $arrResponse =array(
                'status' => 'true',
                'data'   => $records
            );
            
            return response()->json($arrResponse);
    	}
    	catch(\Exception $e)
    	{
	        // return error message with false status
            $arrErrorResponse = array(
                'status' => 'false',
                'errorMsg' => $e->getMessage()
            );
            return response()->json($arrErrorResponse);
        }
    }

     /**
     * Store a newly created insurance detail in csv.
     *
     * @param  array $request
     * @return json
     */
    
    public function addInsurance(Request $request)
    {
        try 
        {
            // read file from storage
            $csvFilePath = storage_path('app/transactions.csv'); 
            $writer = Writer::createFromPath($csvFilePath, 'a+');

            // Get api post data
            $startDate= (isset($request->start_date) && $request->start_date!=''?$request->start_date:'');
            $endDate= (isset($request->end_date) && $request->end_date!=''?$request->end_date:'');
            $firstName= (isset($request->first_name) && $request->first_name!=''?addslashes($request->first_name):'');
            $lastName= (isset($request->last_name) && $request->last_name!=''?addslashes($request->last_name):'');
            $email= (isset($request->email) && $request->email!=''?$request->email:'');
            $telnumber=(isset($request->telnumber) && $request->telnumber!=''?$request->telnumber:'');
            $address1 = (isset($request->address1) && $request->address1!=''?addslashes($request->address1):'');
            $Address2 = (isset($request->Address2) && $request->Address2!=''?addslashes($request->Address2):'');
            $city =  (isset($request->city) && $request->city!=''?$request->city:'');
            $country =  (isset($request->country) && $request->country!=''?$request->country:'');
            $postcode =  (isset($request->postcode) && $request->postcode!=''?$request->postcode:'');
            $productName= (isset($request->product_name) && $request->product_name!=''?addslashes($request->product_name):'');
            $cost = (isset($request->cost) && $request->cost!=''?$request->cost:'');
            $currency = (isset($request->currency) && $request->currency!=''?$request->currency:'');
            $transactionDate = date('d/m/Y');

            $writer->insertOne([$startDate,$endDate,$firstName,$lastName,$email,$telnumber,$address1,$Address2,$city,$country,$postcode,$productName,$cost,$currency,$transactionDate]);
            @chmod($csvFilePath,'777');

            $succResult = array(
                'status' => 'true', 
                'SuccMsg' => 'User updated successfully!'
            );
            return response()->json($succResult);
        } 
        catch (InvalidRowException $e) 
        {
            // will return the invalid data
            $errResult = array(
                'status' => 'false', 
                'errorMsg' => $e->getData()
            );
            return response()->json($errResult);
        }
    }
}
