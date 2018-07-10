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

    public function getCountries(): array
    {
        $sth = $this->pdo->prepare("SELECT * FROM countries");
	    $sth->execute();
	    return $sth->fetchAll();
    }

    public function getCountry($id): array
    {
        $sth = $this->pdo->prepare("SELECT * FROM countries WHERE idCountry=$id");
	    $sth->execute();
	    return $sth->fetch();
    }
}

?>