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
    public function getAnnualInterestRateByCountry(int $countryIds): string;
    public function calculateInterest(int $countryId, int $amount, int $duration): array;
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
     * @param int $countryId
     * @param float @amount
     * @param int $duration
     * 
     * @return array
     */
    public function calculateInterest($countryId, $amount, $duration): array{
        try{
            $country = $this->country->getCountry($countryId);

            $interest = ($amount * $country['annualInterestRate'] / 100) / $duration;
            $result = [$country['name'] => $amount + $interest];
            return $result;
        }
        catch (Exception $e) 
        {
            return ['Error: ' =>  $e->getMessage()];
            exit();
        }        
    }
}