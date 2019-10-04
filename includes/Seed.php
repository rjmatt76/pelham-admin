<?php

class Seed
{

    private $ID;
    private $PlantName;
    private $Category;

    const TABLENAME = "Seeds";

    function __construct()
    {
        $this->ID = -1;
        $this->PlantName = "";
        $this->Category = "";
    }

/*
    function __construct($ID)
    {
        try{}
        catch(Exception err)
        {
            
        }
    }
*/
    public function GetSeedBySeedID($ID)
    {
        $columns = array("ID", "PlantName", "Category");
        $parameters = array($ID);
        $db = Database::getInstance();

        $con = $db->getConnection();

        $columnValues = Database::Select("SELECT", $columns, $parameters, self::TABLENAME, "WHERE ID = ?");
        

        for ($i = 0; $i < count($columnValues); $i++)
        {
            for ($j = 0; $j < count($columnValues[0]); $j++)
            {
                $this->ID = $columnValues[1][$j];
                $this->PlantName = $columnValues[1][$j];
                $this->Category = $columnValues[1][$j];
            }
        }

        echo "|" . "$this->ID" . " - " . "$this->PlantName";
        return 0;
    }

    public function GetSeedsByCategory($category)
    {
        return 0;
    }

    public function InsertSeed()
    {
        return 0;
    }

}
