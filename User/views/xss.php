<head>
    <title>XSS</title>
    <script>
        var username = "<?php echo $_SESSION['username']; ?>";
        var sessionValue = "<?php echo $_SESSION['session_value']; ?>";
    </script>
</head>
<body id="xss">
<?php
require_once ('nav.php');
?>
<section class="align-items-center">
    <div class="container py-5">

        <div class="row d-flex justify-content-center ">

            <div class="col-12 col-md-8 col-sm-6 col-xl-5 text-left" style="max-width: 330px">
                <div class="border-dark mb-3" style="max-width: 100rem;">
                    <div class="card-header">
                        XSS
                    </div>
                    <div class="card-body">
                        <form method="post" id="difficultyForm" class="needs-validation" novalidate>
                            <div class="form-floating mb-4">
                                <div class="mb-3">
                                    <label class="form-label">난이도 선택</label><br>

                                    <!-- 라디오 버튼으로 난이도 선택 -->
                                    <div>
                                        <input type="radio" id="easy" name="difficulty" value="easy">
                                        <label for="easy">쉬움</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="medium" name="difficulty" value="medium">
                                        <label for="medium">중간</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="hard" name="difficulty" value="hard">
                                        <label for="hard">어려움</label>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-outline-secondary w-100" value="선택">
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
<?php include 'footer.php';?>

<script src="/public/js/difficulty.js"></script>

</body>
