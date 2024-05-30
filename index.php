<?php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Student List</h1>";

require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

try {
    // Instantiate our PDO DB object
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    echo 'Connected to database!';
} catch (PDOException $e) {
    die($e->getMessage());
}

// SELECT MULTIPLE ROWS QUERY
// 1. Define the Query
$sql = "SELECT * FROM student";

// 2. Prepare the statement
$statement = $dbh->prepare($sql);

// 3. Execute the statement
$statement->execute();

// Process the result
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
echo "<ol>";
foreach ($result as $row) {
    echo "<li>".$row['last'].", ".$row['first']."</li>";
}
echo "</ol>";

// ADD NEW STUDENT FORM
echo "<h1>Add New Student</h1>";
echo '<form action="#" method="POST">
    <div>
        <label for="SID">SID</label>
        <input type="text" id="SID" name="SID" placeholder="Enter SID">
    </div>
    <div>
        <label for="lName">Last Name</label>
        <input type="text" id="lName" name="lName" placeholder="Enter Last Name">
    </div>
    <div>
        <label for="fName">First Name</label>
        <input type="text" id="fName" name="fName" placeholder="Enter First Name">
    </div>
    <div>
        <label for="DoB">Date of Birth</label>
        <input type="text" id="DoB" name="DoB" placeholder="Enter Birth Date YYYY-MM-DD">
    </div>
    <div>
        <label for="GPA">GPA</label>
        <input type="text" id="GPA" name="GPA" placeholder="Enter GPA">
    </div>
    <div>
        <label for="advisor">Advisor</label>
        <input type="text" id="advisor" name="advisor" placeholder="Enter Advisor">
    </div>
    <div class="form-group col-sm-4 flex-column d-flex">
        <button type="submit">Submit</button>
    </div>
</form>';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $SID = $_POST['SID'];
    $lName = $_POST['lName'];
    $fName = $_POST['fName'];
    $DoB = $_POST['DoB'];
    $GPA = $_POST['GPA'];
    $advisor = $_POST['advisor'];

    if (isset($SID) && isset($lName) && isset($fName)) {
        // PDO
        // 1. Define the query
        $sql = 'INSERT INTO student (sid, last, first, birthdate, advisor)
                VALUES (:sid, :last, :first, :birthdate, :advisor)';

        // 2. Prepare the statement
        $statement = $dbh->prepare($sql);

        // 3. Bind the parameters
        $statement->bindParam(':sid', $SID);
        $statement->bindParam(':last', $lName);
        $statement->bindParam(':first', $fName);
        $statement->bindParam(':birthdate', $DoB);
        $statement->bindParam(':advisor', $advisor);

        // 4. Execute the query
        $statement->execute();

        // 5. Process the results (if any)
        echo "<p>Student $SID was inserted successfully! $fName $lName $DoB $advisor</p>";
    }
}
?>