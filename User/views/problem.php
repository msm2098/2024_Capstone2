<head>
    <title>Problem List</title>
</head>
<body>

<?php
include ('nav.php');
?>
<div class="container my-5">
    <div class="row p-4   align-items-center rounded-3 border shadow-lg ">
        <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 class="display-5 fw-bold lh-1 text-body-emphasis">Find out vulnerabilities!</h1>
            <p class="lead text-body-secondary">각 항목의 취약점을 찾아 공격을 시도하고 플래그를 획득하여 점수를 획득하세요.각 문제는 총 세 가지의 난이도로 구성되어 있습니다.</p>
        </div>
        <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden ">
            <img class="rounded-lg-3" src="/public/resources/Main.png" alt="" width="360">
        </div>
    </div>
</div>




<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3  justify-content-center">

            <div class="col d-flex justify-content-center">
                <a href="/index.php?controller=<?php echo $_SESSION['session_value']?>&action=problem&type=sqlinjection" class="text-decoration-none">
                    <div class="card shadow-sm" style="Width:15rem;">
                        <img src="/public/resources/FAF7BE63-55A9-4E68-9A37-6BD45F7B5591_1_201_a.jpeg" class="card-img-top" alt="CSRF" width="100%" height="225">

                        <div class="card-body">
                            <p class="card-text text-center">SQL Injection</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 카드 2 -->
            <div class="col d-flex justify-content-center">
                <a href="/index.php?controller=<?php echo $_SESSION['session_value']?>&action=problem&type=xss" class="text-decoration-none">
                    <div class="card shadow-sm" style="Width:15rem;">
                       <img src="/public/resources/scripting.png" class="card-img-top" alt="CSRF" width="100%" height="225">

                        <div class="card-body">
                            <p class="card-text text-center">XSS</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col d-flex justify-content-center">
                <a href="/index.php?controller=<?php echo $_SESSION['session_value']?>&action=problem&type=lfi" class="text-decoration-none">
                    <div class="card shadow-sm" style="Width:15rem;">
                        <img src="/public/resources/brute-force.png" class="card-img-top" alt="CSRF" width="100%" height="225">
                        <div class="card-body">
                            <p class="card-text text-center">Brute Force</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php';?>
</body>

