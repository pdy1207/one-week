<?php
require './controller/exit.php';
$js_array = ['./js/agree.js'];

$g_title = '회원 약관 및 개인정보 취급방침 동의';
$menu_code = 'agree';

require './layout/header.php';

?>

<main class="container ">

    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <h4 class="mb-3">대회 참가 유의사항 <span class="text-danger">(필수)</span></h4>

            <div class="border rounded p-3 bg-light"
                style="height:200px; overflow-y:auto; font-size:14px; line-height:1.6;">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum iure omnis perferendis vitae
                doloremque sequi molestias dignissimos repudiandae blanditiis facilis repellendus ab debitis praesentium
                est, harum iste soluta? Iste, dignissimos.
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.
            </div>

            <div class="form-check mt-3">
                <input class="form-check-input agree-item" type="checkbox" id="check1">
                <label class="form-check-label fw-bold" for="check1">
                    위 유의사항에 동의합니다.
                </label>
            </div>

        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <h4 class="mb-3">개인정보 수집 및 이용 <span class="text-danger">(필수)</span></h4>

            <div class="border rounded p-3 bg-light"
                style="height:200px; overflow-y:auto; font-size:14px; line-height:1.6;">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.
            </div>

            <div class="form-check mt-3">
                <input class="form-check-input agree-item" type="checkbox" id="check2">
                <label class="form-check-label fw-bold" for="check2">
                    개인정보 수집 및 이용에 동의합니다.
                </label>
            </div>

        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <h4 class="mb-3">마케팅 정보 수신 <span class="text-muted">(선택)</span></h4>

            <div class="border rounded p-3 bg-light"
                style="height:200px; overflow-y:auto; font-size:14px; line-height:1.6;">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum iure omnis perferendis vitae
                doloremque sequi molestias dignissimos repudiandae blanditiis facilis repellendus ab debitis praesentium
                est, harum iste soluta? Iste, dignissimos.
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                At beatae quae culpa atque repudiandae
                accusamus repellat? Necessitatibus, nesciunt. Dolores accusamus, doloremque nobis aliquam corporis
                dolorem omnis aperiam maxime recusandae iure.
            </div>

            <div class="form-check mt-3">
                <input class="form-check-input agree-item" type="checkbox" id="check3">
                <label class="form-check-label" for="check3">
                    이메일 / 문자 수신에 동의합니다.
                </label>
            </div>

        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4 border-primary">
        <div class="card-body p-4">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkAll">
                <label class="form-check-label fw-bold fs-5" for="checkAll">
                    전체 약관에 동의합니다
                </label>
            </div>

        </div>
    </div>

    <div class="d-flex gap-3 mt-4">
        <button class="btn btn-primary w-50 py-2 fw-bold" id="btn_member">
            약관 동의하고 계속
        </button>

        <button id="btn_cancel" class="btn btn-outline-secondary w-50 py-2">
            취소
        </button>
    </div>
    <form action="./cors.php" name="agree_form" method="post" style="display:none;">
        <input type="hidden" name="agree_rally" id="agree_rally" value="0">
        <input type="hidden" name="agree_info" id="agree_info" value="0">
        <input type="hidden" name="agree_market" id="agree_market" value="0">
    </form>
</main>

<?php require './layout/footer.php'; ?>