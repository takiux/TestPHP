<?php
namespace DB;
use PDO;

class Country 
{
    private $pdo;

    public function __construct($host, $dbName, $userName, $password, $charset)
    {
        try 
        {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password);
        }
        catch (PDOException $e) 
        {
            echo 'Error: ' . $e->getMessage();
            exit();
        }        
    }

    /**
	 * getCountries
     * 
     * Returns a list of all countries with thier interest rate
     * 
     * @return array
     */

    public function getCountries(): array
    {
        $sth = $this->pdo->prepare("SELECT * FROM countries");
	    $sth->execute();
	    return $sth->fetchAll();
    }

    /**
	 * getCountries
     * 
     * Returns a specific country with its interest rate
     * @param $id
     * @return array
     */

    public function getCountry(int $id): array
    {
        $sth = $this->pdo->prepare("SELECT * FROM countries WHERE idCountry=:id");
        $sth->bindParam(":id", $id);
        $sth->execute();
        
	    return $sth->fetch();
    }
}

?>