<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array('pageTitle' => '注册'));
?>

<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-6">
            <h5 class="card-title mb-4">注册</h5>
            <form action="/register" method="POST" class="mb-3">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="username">用户名</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="name">姓名</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="id">公民身份号码</label>
                        <input type="text" class="form-control" name="id" id="id" placeholder="">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="phone">手机号码</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="credit-card">信用卡</label>
                        <input type="text" class="form-control" name="credit-card" id="credit-card" placeholder="">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck" required>
                            <label class="form-check-label" for="gridCheck">
                                我已阅读并知悉《用户协议》。
                            </label>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">注册</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
    
<?php
    Support::includeView('pageFooter');
?>
