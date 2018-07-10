<?php

namespace TestManager;
require 'DB.class.php';

use DB\Country;

interface TestInterface {

    /*
     * error
	 * Returns error code and message in JSON format
     * @param int $code
     * @param string $error
     * @return string
     */
    
    public function error(int $code, string $error): string; 
}

/**
 * Test Manager
 * @author Nicolas Parodi <np@techbanx.com>
 * @copyright (c) 2018, Techbanx
 */
class Manager implements TestInterface
{   
    private $country;
    protected $countries;

    public function __construct(){
        // initialize the database connectio upon the instantiation
        $this->country = new Country('localhost', 'techBanx', 'root', '', 'UTF-8');
    }

    public function getCountries(): array{
        try{
        
            $countries = $this->country->getCountries();
            
            return $countries;
        }
        catch (Exception $e) 
        {
            return ['Error: ' =>  $e->getMessage()];
            exit();
        }        
    }
    
	/**
	 * getAnnualInterestRatesByCountry
     * @param array $countryIds
     * @return string
     */
	public function getAnnualInterestRateByCountry($countryIds): string{
        try{
        
            $this->countries = $this->getCountries();
            
            $response = [];
            foreach($countryIds as $countryId){
                $response[] = [
                    $this->countries[$countryId]['name'] => $this->countries[$countryId]['annualInterestRate'] . '%' //  no semicolumn in an array entry
                ];
            }
            
            return json_encode($response);
        }
        catch (Exception $e) 
        {
            return $this->error(400, 'Error: ' .  $e->getMessage());
            exit();
        }        
	}
	
	/**
	 * returnError
     * @param int $code
     * @param string $error
     * @return string
     */
	public function error(int $code, string $error): string{ //  must be public
		return json_encode([$code => $error]);
    }
    
    /**
	 * calculateInterest
     * 
     * Returns the result in an array format so it can be used byt other functions, 
     * 
     * @param int $countryId
     * @param float @amount
     * @param int $duration
     * 
     * @return array 
     */
    public function calculateInterest(int $countryId, float $amount, int $duration): array{
        try{
            // fetch the country from the database
            $country = $this->country->getCountry($countryId);

            // calculate the interest
            $interest = ($amount * $country['annualInterestRate'] / 100) / $duration;

            $result = [$country['name'] => $amount + $interest];

            // return the result
            return $result;
        }
        catch (Exception $e) 
        {
            return ['Error: ' =>  $e->getMessage()];
            exit();
        }        
    }
}