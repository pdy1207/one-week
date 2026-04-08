$(document).ready(function () {
  const desc = $("#course_des").val();
  const $desc = $("#course_des");
  console.log(desc);
  if (desc.includes("가족 러닝")) {
    $desc.addClass("bg-success");
  } else if (desc.includes("일반 코스")) {
    $desc.addClass("bg-primary");
  } else if (desc.includes("Full 코스")) {
    $desc.addClass("bg-danger");
  } else if (desc.includes("Half 코스")) {
    $desc.addClass("bg-warning");
  }
  $("#btn_pay").on("click", function () {
    // // 버튼 숨기고 로딩 표시
    // $("#btn_pay").prop("disabled", true);
    // $("#result").text("");
    // $("#loading").removeClass("d-none");

    // // 2~3초 랜덤 지연
    // const delay = Math.floor(Math.random() * 2000) + 1000;
    const $btn = $(this);

    // 버튼 스피너로 변경
    $btn.prop("disabled", true);
    $btn.html(`
      <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
      
      결제 진행 중
    `);

    $("#result").text("");

    // 2~3초 랜덤 지연
    const delay = Math.floor(Math.random() * 2000) + 1000;

    setTimeout(function () {
      // 10% 확률 실패
      const isFail = Math.random() < 0.1;

      $("#loading").addClass("d-none");

      if (isFail) {
        $("#result")
          .text("결제 승인 실패 다시 시도해주세요.")
          .css("color", "red");

        $btn.prop("disabled", false);
        $btn.html("결제하기");
      } else {
        const code = generateCode();

        $("#result")
          .html(
            `
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden mt-5 animate__animated animate__fadeInUp">
            <div style="height: 6px; background: linear-gradient(90deg, #198754, #20c997);"></div>
            
            <div class="card-body p-5 text-center">
              <div class="mb-4 text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                  <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                  <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                </svg>
              </div>

              <h2 class="fw-bold mb-2">결제가 완료되었습니다!</h2>
              <p class="text-secondary mb-4">마라톤 대회 참가가 정상적으로 접수되었습니다.</p>
              
              <div class="bg-light p-4 rounded-3 border mb-4">
                <small class="text-uppercase fw-bold text-muted d-block mb-1">나의 참가번호</small>
                <span class="display-6 fw-bold text-primary" style="letter-spacing: 2px;">${code}</span>
              </div>

              <div class="mt-4 pt-3 border-top">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="small text-muted">잠시 후 메인 화면으로 이동합니다.</span>
                  <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                    <span id="countdown_num">10</span>초 남음
                  </span>
                </div>
                <div class="progress" style="height: 6px;">
                  <div id="countdown_bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                       role="progressbar" style="width: 100%"></div>
                </div>
              </div>

              <div class="mt-4">
                <a href="./" class="btn btn-outline-secondary btn-sm px-4 rounded-pill">지금 바로 이동하기</a>
              </div>
            </div>
          </div>
        `,
          )
          .css("color", "inherit");

        // 3. AJAX 데이터 전송
        $.ajax({
          url: "/api/registration.php",
          type: "POST",
          contentType: "application/json",
          data: JSON.stringify({
            course_id: $("input[name='course']").val(),
            name: $("input[name='name']").val(),
            birth: $("input[name='birth']").val(),
            gender: $("input[name='gender']").val(),
            phone: $("input[name='phone']").val().replace(/-/g, ""),
            email: $("input[name='email']").val(),
            size: $("input[name='tshirt_size']").val(),
            agree_rally: $("input[name='agree_rally']").val(),
            agree_info: $("input[name='agree_info']").val(),
            agree_market: $("input[name='agree_market']").val(),
            code: code,
            zipcode: $("input[name='zipcode']").val(),
            addr1: $("input[name='f_adress']").val(),
            addr2: $("input[name='f_adress2']").val(),
          }),
          // success: function (res) {},
        });

        let count = 300;
        const timer = setInterval(function () {
          count--;
          $("#countdown_num").text(count);

          const percent = (count / 300) * 100;
          $("#countdown_bar").css("width", percent + "%");

          if (count <= 0) {
            clearInterval(timer);
            window.location.href = "./";
          }
        }, 1000);

        $btn.remove();
      }
    }, delay);
  });

  // 참가번호 생성 함수
  function generateCode() {
    const prefix = "SPR"; // 고정 prefix

    const year = new Date().getFullYear().toString().slice(-2); // 26

    const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    let random = "";
    for (let i = 0; i < 6; i++) {
      random += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    return `${prefix}${year}-${random}`;
  }
});
