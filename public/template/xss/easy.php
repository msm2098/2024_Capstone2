<?php
require_once(__DIR__ . '/../../../User/config/database.php');
?>
<head>
    <title>XSS - Easy</title>
</head>
<body>
<?php
require_once (__DIR__ . '/../../../User/views/nav.php');

// 테이블 초기 데이터
$rows = [
    ['name' => 'Kim', 'address' => 'Seoul'],
    ['name' => 'Lee', 'address' => 'Incheon'],
    ['name' => 'Park', 'address' => 'Busan']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 사용자 입력값 받기
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    // XSS가 작동하면 이름과 주소를 특정 값으로 변경
    if (strpos($name, '<script>') !== false) {
        $rows[] = [
            'name' => '<a href="/index.php?controller='.$_SESSION['session_value'].'&action=submit&type=xss&difficulty=easy">FLAG</a>',
            'address' => 'Congratulations!'
        ];
    } else {
        // 일반적으로 입력값을 추가
        $rows[] = ['name' => $name, 'address' => $address];
    }
}
?>
<section class="align-items-center py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <h1 class="text-center mb-4">XSS - Easy</h1>
                <p>To succeed, inject JavaScript and trigger the flag row in the table!</p>

                <!-- 데이터 추가 폼 -->
                <form method="POST" action="" class="mb-4">
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Enter name..." required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="address" class="form-control" placeholder="Enter address..." required>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary">Add to Table</button>
                </form>

                <!-- 테이블 표시 -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['address']; ?></td>
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
