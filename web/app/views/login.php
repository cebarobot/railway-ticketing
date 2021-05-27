<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array('pageTitle' => '首页'));

    $isInvalidStr = isset($isInvalid) ? 'is-invalid' : '';
    $userNameValue = isset($loginUserName) ? "value=\"$loginUserName\"" : '';
?>

<main class="container">
    <div class="">
        <div class="">
            <!-- <img src="https://www.12306.cn/en/images/pic/login-banner1.jpg"> -->
        </div>
        <div class="card login-card">
            <div class="card-body">
                <h5 class="card-title mb-4">登录</h5>
                <form action="/login" method="POST" class="mb-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?= $isInvalidStr ?>" name="username" id="username" placeholder="" <?= $userNameValue ?>>
                        <label for="username"><i class="bi bi-person-fill"></i> 用户名</label>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">登录</button>
                    </div>
                </form>
                <p class="card-text text-middle">没有账号？<a href="/register">立即注册</a>！</p>
            </div>
            <div class="card-footer" style="font-size:80%;">
                CR 12307 每日 05:00 ~ 23:30 提供购票、改签、变更到站业务办理，全天均可办理退票等其他服务。
            </div>
        </div>
    </div>
</main>
    
<?php
    Support::includeView('pageFooter');
?>
