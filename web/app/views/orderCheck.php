<?php
    use \foundation\Support;
    use \app\models\Symbol;
    Support::includeView('pageHeader', array(
        'pageTitle' => '确认订单',
        'activeNavItem' => '订单信息',
    ));
?>

<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">确认订单</h5>
                    <form class="" action="/orderSumbit" method="POST">
                        <input type="hidden" name="ticketCnt" value="<?= count($trainInfo) ?>">
                        <div class="row g-3">
                            <?php foreach ($trainInfo as $key => $oneTrainInfo): ?>
                            <div class="col-2">
                                <label for="trainNum-<?= $key ?>" class="form-label">车次</label>
                                <input type="text" class="form-control" id="trainNum-<?= $key ?>" name="trainNum-<?= $key ?>" value="<?= $oneTrainInfo['trainNum'] ?>" readonly>
                            </div>
                            <div class="col-2">
                                <label for="date-<?= $key ?>" class="form-label">出发日期</label>
                                <input type="text" class="form-control" id="date-<?= $key ?>" name="date-<?= $key ?>" value="<?= $oneTrainInfo['date'] ?>" readonly>
                            </div>
                            <div class="col-2">
                                <label for="depSta-<?= $key ?>" class="form-label">出发站</label>
                                <input type="text" class="form-control" id="depSta-<?= $key ?>" name="depSta-<?= $key ?>" value="<?= $oneTrainInfo['depSta'] ?>" readonly>
                            </div>
                            <div class="col-2">
                                <label for="arrSta-<?= $key ?>" class="form-label">终到站</label>
                                <input type="text" class="form-control" id="arrSta-<?= $key ?>" name="arrSta-<?= $key ?>" value="<?= $oneTrainInfo['arrSta'] ?>" readonly>
                            </div>
                            <div class="col-2">
                                <label for="seatType-<?= $key ?>" class="form-label">坐席</label>
                                <input type="hidden" name="seatType-<?= $key ?>" value="<?= $oneTrainInfo['seatType'] ?>">
                                <input type="text" class="form-control" id="seatType-<?= $key ?>" name="seatTypeShow-<?= $key ?>" value="<?= Symbol::seatType($oneTrainInfo['seatType']) ?>" readonly>
                            </div>
                            <div class="col-2">
                                <label for="price-<?= $key ?>" class="form-label">票价</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="rmb-symbol">￥</span>
                                    <input type="text" class="form-control" id="price-<?= $key ?>" name="price-<?= $key ?>" value="<?= $oneTrainInfo['price'] ?>" readonly>
                                </div>
                            </div>
                            <?php endforeach ?>
                            <div class="col-3">
                                <label for="passengerName" class="form-label">乘车人</label>
                                <input type="text" class="form-control" id="passengerName" name="passengerName" value="<?= $passengerName ?>" readonly>
                            </div>
                            <div class="col-6">
                                <label for="passengerID" class="form-label">证件号码</label>
                                <input type="text" class="form-control" id="passengerID" name="passengerID" value="<?= $passengerID ?>" readonly>
                            </div>
                            <div class="col-3">
                                <label for="totalPrice" class="form-label">总价</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="rmb-symbol">￥</span>
                                    <input type="text" class="form-control" id="totalPrice" name="totalPrice" value="<?= $totalPrice ?>" readonly>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary">提交订单</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer" style="font-size:80%;">
                温馨提示：
                    <ol>
                        <li>一张有效身份证件同一乘车日期同一车次只能购买一张车票，高铁动卧列车除外。</li>

                        <li>购票时可使用的有效身份证件包括：中华人民共和国居民身份证、港澳居民来往内地通行证、台湾居民来往大陆通行证和按规定可使用的有效护照。</li>

                        <li>购买儿童票时，乘车儿童有有效身份证件的，请填写本人有效身份证件信息。乘车儿童没有有效身份证件的，应使用同行成年人的有效身份证件信息；购票时不受第一条限制，但购票后、开车前须办理换票手续方可进站乘车。</li>

                        <li>购买学生票时，须在我的乘车人 中登记乘车人的学生详细信息。学生票乘车时间限为每年的暑假6月1日至9月30日、寒假12月1日至3月31日。购票后、开车前，须办理换票手续方可进站乘车。换票时，新生凭录取通知书，毕业生凭学校书面证明，其他凭学生优惠卡。</li>

                        <li>购买残疾军人（伤残警察）优待票的，须在购票后、开车前办理换票手续方可进站乘车。换票时，不符合规定的减价优待条件，没有有效"中华人民共和国残疾军人证"或"中华人民共和国伤残人民警察证"的，不予换票，所购车票按规定办理退票手续。</li>

                        <li>未尽事宜详见《铁路旅客运输规程》等有关规定和车站公告。</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
    Support::includeView('pageFooter');
?>
