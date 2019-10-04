<?php
require_once('../includes/Database.php');
require_once('Seed.php');

function printCategoryDropDown()
{
    $db = Database::getInstance();
    $con = $db->getConnection();

    //one column named Category
    $columns = array("Category");

    //one parameter is the empty string
    $parameters = array(" ");
    
    //takes the value at $_POST['category']
    $filteredCategoryPost = (string)filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        
    //fill columns array with the results of the query
    $columnValues = Database::Select("SELECT DISTINCT ", $columns, $parameters, "Seeds", "WHERE Category <> ? ORDER BY Category");

    echo "<select name=\"category\">\n";
    echo "<option value=\"All\">All</option>\n";

    for ($i = 0; $i < count($columnValues); $i++)
    {
        if ($columnValues[$i][0] == "")
        {
            $strA = "All";
            $strB = "All";
        }
        else
        {
            $strA = $columnValues[$i][0];
        }
        $strB = $strA;
        echo "<option value=\"$strA\"";

        if (($filteredCategoryPost == $strA || ($filteredCategoryPost == "" && $columnValues[$i][0] == "")))
        {
            echo " selected=\"selected\"";
        }
        
        echo ">$strB</option>\n";
    }
    echo "</select>\n";
}

function setRecordsPerPage()
{
    $recordsPerPage = $_POST['recordsPerPage'];

    if (!is_numeric($recordsPerPage) || $recordsPerPage <= 0)
    {
        $recordsPerPage = 50;
    }
}

function printSeedRecordsSTMT()
{
    $db = Database::getInstance();
    if (!$db->getConnection())
    {
        echo "<tr><td>Database error.</td></tr>";
        return;
    }

    $columns = array("ID", "PlantName", "Category");
    $category = (string)filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    try
    {
        $where = "";
        if ($category != "All")
        {
            $where = 'WHERE Category = ?';
            $parameters = array($category);
        }
        else
        {
            $parameters = array();
        }

        $columnValues = Database::Select("SELECT ", $columns, $parameters, "Seeds", $where);

        echo '<tr>';
        echo '<th>SeedID</th><th>PlantName</th><th>Category</th>';
        echo '</tr>';

        if (count($columnValues) < 1)
        {
            echo "<tr><td>No rows returned.</td></tr>";
        }
        for ($i = 0; $i < count($columnValues); $i++)
        {
            echo '<tr>';
            for ($j = 0; $j < count($columnValues[0]); $j++)
            {
                if ($j == 0)
                    echo "<td><a href=\"DisplaySeedRecord.php?SeedID=" . $columnValues[$i][$j] . "\">" . $columnValues[$i][$j] . "</a></td>";
                else
                    echo '<td>' . $columnValues[$i][$j] . '</td>';
            }
            echo '</tr>';
        }
    }
    catch (Exception $err)
    {
        echo 'ERROR: ' . $err->getMessage();
    }
}
?>
<div id="data_table_title">
    <h2>Seed List</h2>
</div>

<div id="data_table">
    <?php
    echo
    '<form action="index.php?seedlist&do=submit" method="POST">
		<table>
		<tr><td colspan=4 align="center">Filters: </td></tr>
		<tr><td align="right">Category:</td><td>';
    printCategoryDropDown();
    echo '</td></tr>

		<tr><td align="right"><input type="submit" value="Search"></td><td></td></tr>';

    if (isset($_GET['do']) && $_GET['do'] == 'submit')
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            printSeedRecordsSTMT();
        }
    }
    echo '</table>';
    ?>
</form>
</div>
