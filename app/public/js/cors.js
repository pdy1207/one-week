function updatePrice() {
  const selected = $('input[name="course"]:checked');

  if (selected.length === 0) {
    $("#total_price").text("0원");
    return;
  }

  const price = parseInt(selected.data("price")) || 0;
  $("#total_price").text(price.toLocaleString() + "원");
}
$(function () {
  // 코스 변경 시
  $('input[name="course"]').on("change", updatePrice);

  // 다음 버튼 클릭
  $("#btn_next").on("click", function () {
    const selected = $('input[name="course"]:checked');

    if (selected.length === 0) {
      alert("코스를 선택해주세요.");
      return;
    }

    $("#f_course").submit();
  });

  // 비활성 클릭 방지
  $("input:disabled").on("click", function () {
    alert("접수 마감된 코스입니다.");
  });

  // 최초 1회 실행
  updatePrice();
});
