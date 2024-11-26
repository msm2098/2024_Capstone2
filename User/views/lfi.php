<head>
    <title>CSRF</title>
    <script>
        var username = "<?php echo $_SESSION['username']; ?>";
        var sessionValue = "<?php echo $_SESSION['session_value']; ?>";
    </script>
</head>
<body id="lfi">
<?php
require_once ('nav.php');
?>
<section class="align-items-center">
    <div class="container py-5">

        <div class="row d-flex justify-content-center ">

            <div class="col-12 col-md-8 col-sm-6 col-xl-5 text-left" style="max-width: 330px">
                <div class="border-dark mb-3" style="max-width: 100rem;">
                    <div class="card-header">
                        Brute Force
                    </div>
                    <div class="card-body">
                        <!-- 난이도 선택 버튼 -->
                        <form method="post" id="difficultyForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <!-- 쉬움 버튼 -->
                                <button type="submit" name="difficulty" value="easy" class="btn btn-outline-secondary w-100 mb-2">
                                    파이썬 코드
                                </button>
                                <!-- 중간 버튼 -->
                                <button type="submit" name="difficulty" value="medium" class="btn btn-outline-secondary w-100 mb-2">
                                    실습 영상
                                </button>
                                <!-- 어려움 버튼 -->
                                <button type="submit" name="difficulty" value="hard" class="btn btn-outline-secondary w-100">
                                    이동하기
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
<?php include 'footer.php';?>

<script >
    document.querySelectorAll('button[name="difficulty"]').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // 기본 폼 제출 동작 방지

            var difficulty = this.value; // 클릭한 버튼의 value 가져오기
            var type = document.body.id; // body 태그의 ID 값 가져오기

            if (difficulty) {
                var url = "index.php?controller=" + sessionValue + "&action=problem&type=" + type + "&difficulty=" + difficulty;
                window.location.href = url; // 선택한 URL로 리다이렉트
            } else {
                alert("난이도를 선택해주세요.");
            }
        });
    });

</script>

</body>
