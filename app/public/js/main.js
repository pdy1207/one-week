$(document).ready(function () {
  $.ajax({
    url: "/api/courses.php",
    type: "GET",
    dataType: "json",
    success: function (res) {
      const courses = res.data;
      let html = "";

      courses.forEach((c) => {
        const percent = (c.registered / c.max_participants) * 100;
        const remaining = c.max_participants - c.registered;
        const isFull = remaining <= 0;

        let badgeColor = "success";
        if (c.description.includes("Full")) badgeColor = "danger";
        else if (c.description.includes("Half")) badgeColor = "warning";
        else if (c.description.includes("일반")) badgeColor = "primary";

        html += `
          <div class="mb-4 ${isFull ? "opacity-50" : ""}">

            <div class="d-flex justify-content-between">
              <strong>${c.name}</strong>

              ${
                isFull
                  ? `<span class="badge bg-danger">마감</span>`
                  : `<span class="text-muted">
                      현재: ${Number(c.registered).toLocaleString()} / ${Number(c.max_participants).toLocaleString()}
                    </span>`
              }
            </div>

            <div class="small text-muted mb-1">
              💰 참가비: ${Number(c.price).toLocaleString()}원
              | <span class="badge bg-${badgeColor}">
                ${c.description}
              </span>
            </div>

            <div class="small text-muted mb-1">
              ${
                isFull
                  ? `<span class="text-danger fw-bold">🚫 마감되었습니다</span>`
                  : `🎯 잔여 인원: ${Number(remaining).toLocaleString()}명`
              }
            </div>

            <div class="progress">
              <div class="progress-bar ${isFull ? "bg-danger" : "bg-primary"}" 
                  style="width: ${percent}%">
              </div>
            </div>

          </div>
        `;
      });

      $("#course_list").html(html);
    },
  });
});
