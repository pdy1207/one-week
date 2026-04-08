<?php
    $g_title = '관리자 로그인';
    require '../layout/header.php'; 
    
    // $password = "qwer";
    // $hash = password_hash($password, PASSWORD_DEFAULT);

    // echo "원문: " . $password . "<br>";
    // echo "해시값: " . $hash;

    // if (password_verify("qwer", $hash)) {
    //     echo "<br>결과: 일치합니다!";
    // }

?>
<link rel="stylesheet" href="../css/admin.css">


<main class="login-bg d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="text-center mb-4">
                    <div class="admin-icon-circle mb-3">
                        <i class="bi bi-shield-lock-fill text-primary fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark">2026 MARATHON</h3>
                    <p class="text-decoration-none small text-secondary">로그인 정보는 관리자에게 문의해주시기
                        바랍니다.</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <form id="login_form" action="../api/admin_login_process.php" method="post" autocomplete="off">

                            <div class="form-floating mb-3">
                                <input type="text" name="userid" id="userid" class="form-control border-0 bg-light"
                                    placeholder="ID" required>
                                <label for="userid" class="text-secondary">관리자 아이디</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" name="password" id="password"
                                    class="form-control border-0 bg-light" placeholder="Password" required>
                                <label for="password" class="text-secondary">비밀번호</label>
                            </div>

                            <button type="submit"
                                class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm py-3 mb-3">
                                로그인 <i class="bi bi-box-arrow-in-right ms-2"></i>
                            </button>

                            <div class="text-center">
                                <a href="../" class="text-decoration-none small text-secondary">
                                    <i class="bi bi-house-door me-1"></i> 메인페이지로 돌아가기
                                </a>

                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-5 small">
                    © NDSOFT corp. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</main>



<?php require '../layout/footer.php'; ?>