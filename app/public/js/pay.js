$(document).ready(function () {
  $("#btn_pay").on("click", function () {
    // 버튼 숨기고 로딩 표시
    $("#btn_pay").prop("disabled", true);
    $("#result").text("");
    $("#loading").removeClass("d-none");

    // 2~3초 랜덤 지연
    const delay = Math.floor(Math.random() * 2000) + 1000;

    setTimeout(function () {
      // 10% 확률 실패
      const isFail = Math.random() < 0.1;

      $("#loading").addClass("d-none");

      if (isFail) {
        $("#result")
          .text("❌ 결제 승인 실패. 다시 시도해주세요.")
          .css("color", "red");

        $("#btn_pay").prop("disabled", false);
      } else {
        // 성공 → 참가번호 생성
        const code = generateCode();

        $("#result")
          .html("✅ 결제 완료!<br>참가번호: <b>" + code + "</b>")
          .css("color", "green");

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
          success: function (res) {
            if (res.data && res.data.status === 409) {
              alert("잘못된 요청입니다.");
              $("#result").text(res.data.message).css("color", "red");
              $("#btn_pay").prop("disabled", false);
              return;
            }
            if (res.data && res.data.status === 400) {
              $("#result").text(res.data.message).css("color", "red");
              $("#btn_pay").prop("disabled", false);
              return;
            }
            console.log(res);
            // // 정상 저장
            // console.log("DB 저장 완료", res);
          },
          error: function (xhr) {
            console.log("통신 실패", xhr);
          },
        });

        // 버튼 유지 (재결제 방지)
        $("#btn_pay").remove();
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
