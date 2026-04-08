$(document).ready(function () {
  const $list = $("#course_list");
  const $total = $("#total_price");

  function loadCourses() {
    $.ajax({
      url: "/api/courses.php",
      type: "GET",
      dataType: "json",
      success: function (res) {
        let html = "";

        res.data.forEach((c) => {
          const remaining = c.max_participants - c.registered;
          const isFull = remaining <= 0;

          // 코스별 강조 색상 결정
          let themeColor = "primary";
          if (c.description?.includes("가족")) themeColor = "success";
          else if (c.description?.includes("Half")) themeColor = "warning";
          else if (c.description?.includes("Full")) themeColor = "danger";

          html += `
            <div class="col-md-6">
              <input type="radio" 
                    class="btn-check course-radio" 
                    name="course" 
                    id="course${c.id}" 
                    value="${c.id}" 
                    data-price="${c.price}" 
                    ${isFull ? "disabled" : ""}>
              
              <label class="btn btn-outline-${themeColor} w-100 p-4 rounded-4 shadow-sm text-start position-relative h-100 d-flex flex-column justify-content-center" 
                    for="course${c.id}">
                
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h5 class="fw-bold mb-0">${c.name}</h5>
                  ${c.description ? `<span class="badge bg-${themeColor}">${c.description}</span>` : ""}
                </div>

                <div class="mt-1">
                  <div class="small opacity-75">참가비: <strong>${Number(c.price).toLocaleString()}원</strong></div>
                  <div class="small opacity-75">잔여: ${remaining} / ${c.max_participants}</div>
                </div>

                ${isFull ? `<div class="position-absolute top-50 start-50 translate-middle w-100 h-100 bg-white bg-opacity-75 d-flex align-items-center justify-content-center rounded-4"><span class="badge bg-secondary fs-6">접수 마감</span></div>` : ""}
                
                <i class="bi bi-check-circle-fill position-absolute end-0 bottom-0 m-3 fs-4 d-none checked-icon"></i>
              </label>
            </div>
          `;
        });

        $list.html(html);
      },
    });
  }

  // 가격 업데이트
  function updatePrice() {
    let price = 0;

    const selected = $(".course-radio:checked");

    if (selected.length > 0) {
      price = parseInt(selected.data("price"));
    }

    $total.text(price.toLocaleString() + "원");
  }

  $(document).on("change", ".course-radio", function () {
    updatePrice();
  });

  $("#btn_next").on("click", function () {
    const selected = $(".course-radio:checked");

    if (selected.length === 0) {
      alert("코스를 선택해주세요.");
      return;
    }

    $("#f_course").submit();
  });

  $("#btn_cancel").on("click", function () {
    window.location.href = "./";
  });

  loadCourses();
});
