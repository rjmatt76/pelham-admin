<?php
require('config/config.php');
require('util/utils.php');

function ShowHarvestRecords($PickedStartDate, $PickedEndDate, $InputMode)	
{

        $conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

        if($conn == false)
             die("Unable to select database");

	$strQuery = "select ID, DatePicked, Market, Quantity, Price, UnitType FROM "; 
	$strQuery = $strQuery."HarvestRecords HR ";
	$strQuery = $strQuery."WHERE DatePicked Between '".$PickedStartDate."' AND '".$PickedEndDate."'";
	$strQuery = $strQuery." ORDER BY DatePicked";
	$rsrcResult = mysqli_query($conn, $strQuery);

	echo "<table>";
	echo "<tr>";
	echo "<th>ID</th>";
	echo "<th>DatePicked</th>";
	echo "<th>Market</th>";
	echo "<th>Quantity</th>";
	echo "<th>Price</th>";
	echo "<th>UnitType</th>";
	echo "</tr>";

	while($arrayRow = mysqli_fetch_array($rsrcResult)) 
	{
		echo "<tr>";
		echo "<td>".$arrayRow['ID']."</td>";
		echo "<td>".$arrayRow['DatePicked']."</td>";
		echo "<td>".$arrayRow['Market']."</td>";
		echo "<td>".$arrayRow['Quantity']."</td>";
		echo "<td>".$arrayRow['Price']."</td>";
		echo "<td>".$arrayRow['UnitType']."</td>";	
		echo "</tr>";
	}
	mysqli_close();

	echo "</table>";

}

function ShowHarvestRecordsTotal($PickedStartDate, $PickedEndDate, $InputMode)	
{

        $conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

        if($conn == false)
             die("Unable to select database");

	$strQuery = "SELECT Vegetable, UnitType, SUM(Quantity) as Quantity, SUM(Quantity * Price) as Total FROM "; 
	$strQuery = $strQuery."HarvestRecords ";
	$strQuery = $strQuery."WHERE DatePicked Between '".$PickedStartDate."' AND '".$PickedEndDate."'";
	$strQuery = $strQuery." GROUP BY Vegetable, UnitType";
	$strQuery = $strQuery." UNION ";
	$strQuery = $strQuery."SELECT 'Total' AS Vegetable, 'All' As UnitType, SUM(Quantity) as Quantity, SUM(Quantity * Price) as Total FROM "; 
	$strQuery = $strQuery."HarvestRecords ";
	$strQuery = $strQuery."WHERE DatePicked Between '".$PickedStartDate."' AND '".$PickedEndDate."'";

	$rsrcResult = mysqli_query($conn, $strQuery);

	echo "<table>";
	echo "<tr>";
	echo "<th>Vegetable</th>";
	echo "<th>UnitType</th>";
	echo "<th>Quantity</th>";
	echo "<th>Total</th>";
	echo "</tr>";

	while($arrayRow = mysqli_fetch_array($rsrcResult)) 
	{
		echo "<tr>";
		echo "<td>".$arrayRow['Vegetable']."</td>";
		echo "<td>".$arrayRow['UnitType']."</td>";
		echo "<td>".$arrayRow['Quantity']."</td>";
		echo "<td>".$arrayRow['Total']."</td>";
		echo "</tr>";
	}
	mysqli_close();

	echo "</table>";
}

?>

		<div id="data_table_title">
			<h2>Harvest Records</h2>
		</div>
			
		<div id="data_table">

					<form name="frmMain" method="post" action="index.php?harvestrecords">
					<table id="SelectionTable">
					<tr>
					<td>Picked Start Date</td>
					<td><input type="text" name="PickedStartDate" value="<?php echo $_POST['PickedStartDate'] ?>" size="15" maxlength="10"> 
					<input class=button type="button" name="cmdCal" value="Launch Calendar" onClick='javascript:window.open("calendar.php?form=frmMain&field=PickedStartDate","","top=50,left=400,width=175,height=140,menubar=no,toolbar=no,scrollbars=no,resizable=no,status=no"); return false;'> </td>
					</tr>
					<tr>
					<td>Picked End Date</td>
					<?php echo "<td><input type=\"text\" name=\"PickedEndDate\" value=\"".$_POST['PickedEndDate']."\" size=\"15\" maxlength=\"10\"> "; ?>
					<input class=button type="button" name="cmdCal" value="Launch Calendar" onClick='javascript:window.open("calendar.php?form=frmMain&field=PickedEndDate","","top=50,left=400,width=175,height=140,menubar=no,toolbar=no,scrollbars=no,resizable=no,status=no"); return false;'> </td>
					</tr>
					<tr>
					<td>
					<input class=button type="submit" name="action" value="Show Harvest Records"></td>
					</tr>
					<!-- <tr><td> -->
					<?php 
					
						/*echo '<input type="checkbox" name="InputModeCheckbox" value="';
						if(isset($_POST['InputModeCheckbox']) && ($_POST['InputModeCheckbox'] == 'true'))
							echo 'true" checked="true';
						else
							echo 'false" checked="false';
						echo '">Input Mode</td>';
					
						echo '</td>';*/
					?>
					<!-- </tr> -->
					</table>
					<?php 
					// value="yyyy-mm-dd"
					switch($_POST['action'])
					{
						case 'edit':
							break;
						case 'delete':
							break;
						case 'Save':
							//InsertAppliedMaterialsDB($_POST['MaterialName'],$_POST['Manufacturer'],$_POST['DateApplied'],$_POST['MaterialType'],$_POST['Reason']);
							break;
						case 'Show Harvest Records':
							//ShowHarvestRecords($_POST['PickedStartDate'], $_POST['PickedEndDate'], false); 
							ShowHarvestRecordsTotal($_POST['PickedStartDate'], $_POST['PickedEndDate'], false); 
							break;
					}


					?>
					</form>
				</div>


