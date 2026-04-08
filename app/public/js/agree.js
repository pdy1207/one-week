$(document).ready(function () {
  const $all = $("#checkAll");
  const $items = $(".agree-item");

  // 전체 동의 클릭
  $all.on("change", function () {
    $items.prop("checked", $(this).is(":checked"));
  });

  // 개별 체크 → 전체동의 자동 체크/해제
  $items.on("change", function () {
    const total = $items.length;
    const checked = $items.filter(":checked").length;

    $all.prop("checked", total === checked);
  });
  // 취소 버튼
  $("#btn_cancel").on("click", function () {
    window.location.href = "./";
  });
  // 가입(참가 정보 입력 이동) 버튼
  // 가입(다음 단계 이동) 버튼
  $("#btn_member").on("click", function () {
    // 1. 필수 체크 (약관 1, 2번)
    if (!$("#check1").is(":checked") || !$("#check2").is(":checked")) {
      alert("필수 약관에 동의해주세요.");
      return false;
    }

    // 2. 체크박스 상태값 준비
    const agree_rally = $("#check1").is(":checked") ? 1 : 0;
    const agree_info = $("#check2").is(":checked") ? 1 : 0;
    const agree_market = $("#check3").is(":checked") ? 1 : 0;

    // 3. URL 파라미터 확인 (id가 있는지)
    const urlParams = new URLSearchParams(window.location.search);
    const courseId = urlParams.get("id");

    if (courseId) {
      // [경로 A] id가 있으면 바로 info.php로 (GET)
      location.href = `./info.php?course=${courseId}&agree_rally=${agree_rally}&agree_info=${agree_info}&agree_market=${agree_market}`;
    } else {
      // [경로 B] id가 없으면 cors.php로 값 실어서 전송 (POST)
      // 전송 전 hidden 필드에 값 세팅 필수!
      $("input[name='agree_rally']").val(agree_rally);
      $("input[name='agree_info']").val(agree_info);
      $("input[name='agree_market']").val(agree_market);

      // 폼 전송
      $("form[name='agree_form']").submit();
    }
  });
});
