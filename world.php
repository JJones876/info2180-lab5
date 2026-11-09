<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? '';
$country = "%" . $country . "%";

if ($lookup === 'cities') {
    $stmt = $conn->prepare(
        "SELECT cities.name, cities.district, cities.population
        FROM cities
        JOIN countries
        ON cities.country_code = countries.code
        WHERE countries.name LIKE :country"
    );
} else {
    $stmt = $conn->prepare(
        "SELECT * FROM countries WHERE name LIKE :country"
    );
}

$stmt->execute([
    'country' => $country
]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if (empty($results)): ?>
    <p>No results found.</p>

<?php elseif ($lookup === 'cities'): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['district'] ?? '') ?></td>
                    <td><?= htmlspecialchars((string)$row['population']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <table border="1">
        <thead>
            <tr>
                <th>Country</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['head_of_state'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>