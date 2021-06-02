<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array('pageTitle' => '管理'));

    $isInvalidStr = isset($isInvalid) ? 'is-invalid' : '';
    $userNameValue = isset($loginUserName) ? "value=\"$loginUserName\"" : '';
?>

<main class="container mt-4">
    <div class="row mt-3">
        <div class="col-md-2 f-sm">
            <div class="nav nav-pills flex-column">
                <a class="nav-link active" href="#basic">基本信息</a>
                <a class="nav-link" href="#hot">热点车次</a>
                <a class="nav-link" href="#users">注册用户</a>
                <a class="nav-link" href="#initSeats">放票</a>
                <a class="nav-link" href="/admin/orderList">订单</a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="my-3" id="basic">
                <h4>基本信息</h4>
                <ul>
                    <li>总订单数：<?= $totalOrderCnt ?></li>
                    <li>总票价：<?= $totalPrice ?></li>
                </ul>
            </div>
            <div class="my-3" id="hot">
                <h4>热点车次</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">车次</th>
                            <th scope="col">车票数</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hotTrain->list as $key => $oneTrain): ?>
                            <tr>
                                <th scope="row"><?= $key + 1 ?></th>
                                <td><?= $oneTrain[strtolower('trainNum')] ?></td>
                                <td><?= $oneTrain[strtolower('ticketCnt')] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="my-3" id="users">
                <h4>注册用户</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">用户名</th>
                            <th scope="col">姓名</th>
                            <th scope="col">身份证号</th>
                            <th scope="col">手机号</th>
                            <th scope="col">信用卡</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userList as $oneUser): ?>
                            <tr>
                                <td><?= $oneUser[strtolower('userName')] ?></td>
                                <td><?= $oneUser[strtolower('name')] ?></td>
                                <td><?= $oneUser[strtolower('id')] ?></td>
                                <td><?= $oneUser[strtolower('phoneNum')] ?></td>
                                <td><?= $oneUser[strtolower('creditCard')] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="my-3" id="initSeats">
                <h4>放票</h4>
                <form class="row row-cols-lg-auto g-3 align-items-center" action="/admin/initSeat" method="GET">
                    <div class="col-12">
                        <label class="visually-hidden" for="initSeatDate">日期</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-calendar-date"></i></div>
                            <input type="date" class="form-control" id="initSeatDate" name="date">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
    
<?php
    Support::includeView('pageFooter');
?>
