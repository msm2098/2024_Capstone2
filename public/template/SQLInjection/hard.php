<?php
require_once(__DIR__ . '/../../../User/config/database.php');
?>
<head>
    <title>SQL Injection - Hard</title>
</head>
<body>
<?php
require_once (__DIR__ . '/../../../User/views/nav.php');


$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$query = "SELECT * FROM users_2 WHERE name != 'FLAG'";
$searchError = false;
$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'];


    if (preg_match('/[\';"=]/', $search)) {
        $searchError = true;
    } else {
        $stmt = $db->prepare("SELECT * FROM users_2 WHERE name LIKE CONCAT('%', ?, '%') AND name != 'FLAG'");
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $searchResults = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
} else {
    $result = $db->query($query);
    if ($result) {
        $searchResults = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<section class="align-items-center py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <h1 class="text-center mb-4">SQL Injection - Hard</h1>
                <p>Can you bypass our security to find the hidden flag?</p>


                <form method="POST" action="" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for users..." required>
                        <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                </form>


                <?php if ($searchError): ?>
                    <div class="alert alert-danger" role="alert">
                        Invalid input detected. Please try again.
                    </div>
                <?php endif; ?>


                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($searchResults)): ?>
                            <?php foreach ($searchResults as $user): ?>
                                <tr>
                                    <td>
                                        <?php if ($user['name'] === 'FLAG' && $user['address'] === 'FLAG'): ?>
                                            <a href="/index.php?controller=<?php echo urlencode($_SESSION['session_value']); ?>&action=submit&type=sqlinjection&difficulty=hard">
                                                <?php echo htmlspecialchars($user['name']); ?>
                                            </a>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($user['name']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
