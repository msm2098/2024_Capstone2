<?php
require_once(__DIR__ . '/../../../User/config/database.php');
?>
<head>
    <title>XSS - Medium</title>
</head>
<body>
<?php
require_once (__DIR__ . '/../../../User/views/nav.php');

// 테이블 초기 데이터
$rows = [
    ['name' => 'Alice', 'address' => 'New York'],
    ['name' => 'Bob', 'address' => 'Los Angeles'],
    ['name' => 'Charlie', 'address' => 'Chicago']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    // 필터링: '<', '>'만 제거
    $name = str_replace(['<', '>'], '', $name);
    $address = str_replace(['<', '>'], '', $address);

    // 입력값 추가
    $rows[] = ['name' => $name, 'address' => $address];
}
?>
<section class="align-items-center py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <h1 class="text-center mb-4">XSS - Medium</h1>
                <p>Inject JavaScript and bypass the filters!</p>

                <!-- 입력 폼 -->
                <form method="POST" action="" class="mb-4">
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Enter name..." required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="address" class="form-control" placeholder="Enter address..." required>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary">Add to Table</button>
                </form>

                <!-- 테이블 -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>

                            <th>Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td <?php echo $row['name']; ?>>Address: <?php echo $row['address']; ?></td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
