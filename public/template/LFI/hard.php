<?php
require_once(__DIR__ . '/../../../User/config/database.php');
?>
<head>
    <title>Brute Force - Easy</title>
</head>
<body>
<?php
require_once (__DIR__ . '/../../../User/views/nav.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        echo "<script>
alert('로그인 성공');
window.location.href = 'index.php?controller=" . $_SESSION['session_value'] . "&action=submit&type=sqlinjection&difficulty=easy';
</script>";


    } else {
        echo "<script>alert('로그인 실패')</script>";
    }}?>
<section class="align-items-center">
    <div class="container py-5">

        <div class="row d-flex justify-content-center ">

            <div class="col-12 col-md-8 col-sm-6 col-xl-5 text-left" style="max-width: 330px">
                <div class=" border-dark mb-3" style="max-width: 100rem;">
                    <div class="card-header">
                        <h2>Brute Force</h2>
                        <p>Password Guess</p>
                    </div>

                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-floating mb-4">
                                <input type="text" name="username" id="username" class="form-control form-control-sm" placeholder="ID"  required>
                                <label class="form-label" for="user_id">아이디</label>

                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name = "password" id="password" class="form-control form-control-sm" placeholder="PW" aria-describedby="checkpw" required>
                                <label class="form-label" for="user_id">비밀번호</label>

                            </div>


                            <input type="submit" class="btn btn-outline-secondary w-100" value="로그인">

                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>
</body>
<script>

</script>