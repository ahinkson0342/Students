<?php

//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Student List</h1>";

require_once $_SERVER['DOCUMENT_ROOT'].'/../config.php';

try
{
    //Instantiate our PDO DB object
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    echo 'Connected to database!';
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}

//SELECT MULTIPLE ROWS QUERY
//1. Define the Query
$sql = "SELECT * FROM student";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Bind the parameters (none here)

//4. Execute the statement
$statement->execute();

//Process the result
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
echo "<ol>";
foreach ($result as $row)
{
    echo "<li>".$row['last'].", ".$row['first']."</li>";
}
echo "</ol>";

//PDO
//1. Define the query
$sql = 'INSERT INTO student (sid, last, first, birthdate, advisor)
VALUES (:sid, :last, :first, :birthdate, :advisor)';

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Bind the parameters
$sid = '253-867-5309';
$last = 'Doe';
$first = 'John';
$birthdate = '2003-02-10';
$advisor = '1';
$statement->bindParam(':sid', $sid);
$statement->bindParam(':last', $last);
$statement->bindParam(':first', $first);
$statement->bindParam(':birthdate', $birthdate);
$statement->bindParam(':advisor', $advisor);

//4. Execute the query
$statement->execute();

//5. Process the results (if any)
$id = $dbh->lastInsertId();
echo "<p>Student $sid was inserted successfully!</p>";
