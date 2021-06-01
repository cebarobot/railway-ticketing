<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array(
        'pageTitle' => '确认订单',
        'activeNavItem' => '订单信息',
    ));
?>

<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">确认订单</h5>
                    <form class="">
                        <div class="row g-3">
                            <div class="col-3">
                                <label for="trainNum" class="form-label">车次</label>
                                <input type="text" class="form-control" id="trainNum" name="trainNum" value="S512" readonly>
                            </div>
                            <div class="col-3">
                                <label for="depSta" class="form-label">出发站</label>
                                <input type="text" class="form-control" id="depSta" name="depSta" value="北京北" readonly>
                            </div>
                            <div class="col-3">
                                <label for="arrSta" class="form-label">终到站</label>
                                <input type="text" class="form-control" id="arrSta" name="arrSta" value="怀柔北" readonly>
                            </div>
                            <div class="col-3">
                                <label for="depDate" class="form-label">出发日期</label>
                                <input type="text" class="form-control" id="depDate" name="depDate" value="2021-06-02" readonly>
                            </div>
                            <div class="col-2">
                                <label for="passengerName" class="form-label">乘车人</label>
                                <input type="text" class="form-control" id="passengerName" name="passengerName" value="林云" readonly>
                            </div>
                            <div class="col-4">
                                <label for="passengerID" class="form-label">公民身份号码</label>
                                <input type="text" class="form-control" id="passengerID" name="passengerID" value="100101200001010011" readonly>
                            </div>
                            <div class="col-3">
                                <label for="seatType" class="form-label">坐席</label>
                                <input type="text" class="form-control" id="seatType" name="seatType" value="二等座" readonly>
                            </div>
                            <div class="col-3">
                                <label for="price" class="form-label">票价</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="rmb-symbol">￥</span>
                                    <input type="text" class="form-control" id="price" name="price" value="120" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        我已阅读并同意服务协议。
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary">提交订单</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
    Support::includeView('pageFooter');
?>
