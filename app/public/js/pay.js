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
