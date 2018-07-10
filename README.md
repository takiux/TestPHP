# Exercise 1

2 found in the manager class : 
  - in getAnnualInterestRates function : unnecessary semicolon in the array.
  - the error function should be public ( like in the interface ).
1 found in index.php :
  - a typo in the function call.

# Exercise 2

  - Database created.
  - Class DB was created to handle the database connection and holds the CRUD functions.
  - Call for the function getCountries() in stead of harcoding the values.

# Exercise 3

  - Added a function to the Manager class : public function calculateInterest(int $countryId, int $amount, int $duration): array
  - call calculateInterest() in getResult.php ( for the lack of a router ) with an Ajax request upon form submission.
