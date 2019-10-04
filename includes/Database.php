<?php

require_once('../config/config.php');

class Database
{

    private $conn;
    private static $db;

    protected function __construct()
    {
        $this->createConnection();
    }

    private function createConnection()
    {
        /* connection values are specified in the config.php file */
        $this->conn = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
 
        if ($this->conn->connect_errno)
        {
            throw new Exception("Failed to connect to MySQL: " . $this->conn->connect_error);
        }
    }

    public static function getInstance()
    {
        if (!self::$db)
        {
            self::$db = new self();
        }
        return self::$db;
    }

    public function getConnection()
    {
        if ($this->conn == null)
            $this->createConnection();
        return $this->conn;
    }

    /*
     * $statementType - should be a string with the SELECT statement and DISTINCT if applicable
     * $columns - needs to contain the column names as stored in the MYSQL database
     * $parameters - should contain the appropriate number of parameters for the prepared statement 
     *     as contained in the SQL sent to the server with marker "?"
     * $tablename - name of the datatable in the query.
     * $whereclause - where clause combined with any order statements.
     */

    public static function Select($statementType, $columns, $parameters, $tablename, $whereclause)
    {
        try
        {
            $sql = $statementType . " ";

            for ($i = 0; $i < count($columns); $i++)
            {
                $sql = " " . $sql . $columns[$i] . "";
                if ($i != count($columns) - 1)
                    $sql = $sql . ", ";
            }
            $sql = $sql . " FROM " . $tablename . " " . $whereclause;
            echo "$sql";

            /* activate reporting */
            $driver = new mysqli_driver();
            $driver->report_mode = (MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

            $stmt = Database::getInstance()->getConnection()->stmt_init();

            if (($stmt->prepare($sql)) != false)
            {
                if (count($parameters) > 0)
                {
                    $param_type_str = "";
                    /* s for string, i for int */
                    for ($i = 0; $i < count($parameters); $i++)
                    {
                        $param_type_str = $param_type_str . "s";
                    }
                    $stmt->bind_param($param_type_str, ...$parameters);
                }

                $stmt->execute();

                $stmt->bind_result(...$columns);

                $columnValues = array();

                /* loop through the results and copy the values to $columnValues so that 
                 * the results stored in $columns can be freed.
                 */
                $i = 0;
                while ($stmt->fetch())
                {
                    for ($j = 0; $j < count($columns); $j++)
                    {
                        $columnValues[$i][$j] = $columns[$j];
                    }
                    $i++;
                }

                mysqli_stmt_free_result($stmt);
                $stmt->close();
                return $columnValues;
            }
            else
            {
                return false;
            }
        }
        catch (Exception $err)
        {
            throw new Exception("Error in Database.php/Select: " . $err->getMessage());
        }
    }

}
