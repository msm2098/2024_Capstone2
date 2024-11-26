<?php
require_once(__DIR__ . '/../../../User/config/database.php');
?>
<head>
    <title>SQL Injection Medium</title>
</head>
<body>
<?php
require_once (__DIR__ . '/../../../User/views/nav.php');

// 데이터베이스 연결
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// 기본적으로 모든 품목 표시
$query = "SELECT * FROM products WHERE name != 'Flag'";
$searchError = false;
$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'];
    $userQuery = "SELECT * FROM products WHERE name LIKE '%$search%' AND name != 'Flag'";

    // SQL 실행 및 오류 처리

    $result = $db->query($userQuery);
    if ($result) {
        $searchResults = $result->fetch_all(MYSQLI_ASSOC);
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
                <h1 class="text-center mb-4">SQL Injection - Medium</h1>
                <p>Use SQL to find the hidden flag!</p>

                <!-- 검색 폼 -->
                <form method="POST" action="" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for products..." required>
                        <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                </form>

                <!-- 에러 메시지 -->
                <?php if ($searchError): ?>
                    <div class="alert alert-danger" role="alert">
                        An error occurred. Please check your input.
                    </div>
                <?php endif; ?>

                <!-- 검색 결과 표시 -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($searchResults)): ?>
                            <?php foreach ($searchResults as $product): ?>
                                <tr>
                                    <td>
                                        <?php if ($product['name'] === 'Flag'): ?>
                                            <a href="/index.php?controller=<?php echo urlencode($_SESSION['session_value']); ?>&action=submit&type=sqlinjection&difficulty=medium">
                                                <?php echo htmlspecialchars($product['name']); ?>
                                            </a>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No products found.</td>
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
