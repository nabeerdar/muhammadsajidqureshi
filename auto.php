<?php
require_once "configPDO.php";

// define variables and set to empty values
$makeErr = $yearErr = $mileageErr = ""; 
$make = $year = $mileage = "";
$year_not_numeric = $mileage_not_numeric = "";


if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {

    if ($_POST['make'] == "") {
        $makeErr = "Make is required";
    } 
    elseif ($_POST['year'] == "") {
        $yearErr = "Year is required";
    }
    elseif ($_POST['mileage'] == "") {
        $mileageErr = "Mileage is required";
    }
    elseif (!intval($_POST['year']) && $_POST['year'] != '') {
        $year_not_numeric = "year is not numeric";
    }
    elseif (!intval($_POST['mileage']) && $_POST['mileage'] != '') {
        $mileage_not_numeric = "mileage is not numeric";
    }

    elseif (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
        $stmt = $pdo->prepare('INSERT INTO autos
            (make, year, mileage) VALUES ( :mk, :yr, :mi)');
            
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
        );

        echo "<p style='color: green'>Record inserted</p>";
    } 

}   


if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    // echo "<pre>\n$sql\n</pre>\n";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
}

$stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<html lang="en">

    <head>

        <title>Muhammad Sajid Qureshi</title>

        <style>
            .error{
                color: #FF0000;
            }
        </style>    
    </head>

    <body>

        <p>Add New Auto</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <br> 

                <div>
                    Make: <input type="text" name="make" size="40">
                    <span class="error"> <?php echo $makeErr;?></span>
                </div>

            <br>

                <div>
                    Year: <input type="text" name="year">
                    <span class="error"> <?php echo $yearErr;?></span>
                </div>

                <div>
                <?php echo $year_not_numeric;?>
                </div>

            <br>

           

                <div>
                    Mileage: <input type="text" name="mileage">
                    <span class="error"> <?php echo $mileageErr;?></span>
                    <br>
                </div>

                <div>
                    <?php echo $mileage_not_numeric;?>
                </div>

            <br>

           
            
            <p><input type="submit" value="Add"/></p>
            
        </form>

        <table border="1">
            <?php
            foreach ( $rows as $row ) {
                echo "<tr><td>";
                echo($row['make']);
                echo("</td><td>");
                echo($row['year']);
                echo("</td><td style='text-align: center; font-weight: bold'>");
                echo  $row['mileage'] ;
                echo("</td><td ");
                echo('<form method="post"><input type="hidden" ');
                echo('name="auto_id" value="'.$row['auto_id'].'">'."\n");
                echo('<input type="submit" value="Del" name="delete">');
                echo("\n</form>\n");
                echo("</td>
                </tr>\n");
            }
            ?>

        </table>
    </body>
</html>