$(document).ready(function () {
  const $all = $("#checkAll");
  const $items = $(".agree-item");

  // ✅ 전체 동의 클릭
  $all.on("change", function () {
    $items.prop("checked", $(this).is(":checked"));
  });

  // ✅ 개별 체크 → 전체동의 자동 체크/해제
  $items.on("change", function () {
    const total = $items.length;
    const checked = $items.filter(":checked").length;

    $all.prop("checked", total === checked);
  });

  // ✅ 가입 버튼
  $("#btn_member").on("click", function () {
    // 필수 체크 (1,2번)
    if (!$("#check1").is(":checked") || !$("#check2").is(":checked")) {
      alert("필수 약관에 동의해주세요.");
      return false;
    }

    // 통과 → 폼 전송
    $('form[name="stipluation_form"]').submit();
  });
});
