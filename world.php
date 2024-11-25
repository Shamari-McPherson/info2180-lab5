<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$dbConnection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$isCitySearch = false;

if (isset($_GET['country'])) {
    $inputValue = $_GET['country'];
    $sanitizedCountry = filter_var($inputValue, FILTER_SANITIZE_STRING);
    $query = "SELECT * FROM countries WHERE name LIKE '%$sanitizedCountry%'";

    if (isset($_GET['lookup'])) {
        $lookupType = $_GET['lookup'];
        $isCitySearch = true;
        $tableHeaders = array("Name", "District", "Population");

        $statement = $dbConnection->query($query);
        $countryData = $statement->fetchAll(PDO::FETCH_ASSOC);

        $countryCode = $countryData[0]['code'];

        $query = "SELECT cities.name, cities.district, cities.population 
                  FROM cities 
                  JOIN countries ON countries.code = cities.country_code 
                  WHERE countries.code LIKE '%$countryCode%'";
    } else {
        $tableHeaders = array("Name", "Continent", "Independence Year", "Head of State");
    }
    $statement = $dbConnection->query($query);
}

$queryResults = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <tr>
        <?php foreach ($tableHeaders as $header): ?>
            <th><?= $header; ?></th>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($queryResults as $row): ?>
        <tr>
            <?php if (!$isCitySearch): ?>
                <td><?= $row['name']; ?></td>
                <td><?= $row['continent']; ?></td>
                <td><?= $row['independence_year']; ?></td>
                <td><?= $row['head_of_state']; ?></td>
            <?php else: ?>
                <td><?= $row['name']; ?></td>
                <td><?= $row['district']; ?></td>
                <td><?= $row['population']; ?></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>