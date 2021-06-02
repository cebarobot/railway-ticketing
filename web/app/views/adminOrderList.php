<?php
    use \foundation\Support;
    use \app\models\Symbol;
    Support::includeView('pageHeader', array('pageTitle' => '管理'));

    $isInvalidStr = isset($isInvalid) ? 'is-invalid' : '';
    $userNameValue = isset($loginUserName) ? "value=\"$loginUserName\"" : '';
?>

<main class="container mt-4">
    <div class="row mt-3">
        <div class="col-md-2 f-sm">
            <div class="nav nav-pills flex-column">
                <a class="nav-link" href="/admin#basic">基本信息</a>
                <a class="nav-link" href="/admin#hot">热点车次</a>
                <a class="nav-link" href="/admin#users">注册用户</a>
                <a class="nav-link" href="/admin#initSeats">放票</a>
                <a class="nav-link active" href="#orders">订单</a>
            </div>
        </div>
        <div class="col-md-10">
            <form class="row row-cols-lg-auto g-3 align-items-center" method="GET">
                <div class="col-12">
                    <label class="visually-hidden" for="userName">用户名</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="bi bi-person-circle"></i></div>
                        <input type="text" class="form-control" id="userName" name="userName" value="<?= $_GET['userName'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div class="order-list-box p-4">
                <div class="">
                    <div class="row order-list-header py-2">
                        <div class="order-train">车次信息</div>
                        <div class="order-passenger">旅客</div>
                        <div class="order-seat">席位</div>
                        <div class="order-price">票价</div>
                        <div class="order-status">车票状态</div>
                    </div>
                    <?php foreach ($orderList as $orderItem): ?>
                        <div class="order-item">
                            <div class="row order-item-header">
                                <i class="bi bi-card-heading"></i>
                                <div>
                                    <span>订票时间：</span>
                                    <span><?= $orderItem->orderTime ?></span>
                                </div>
                                <div>
                                    <span>订单号：</span>
                                    <span><?= $orderItem->orderID ?></span>
                                </div>
                            </div>
                            <?php foreach ($orderItem->ticketList as $ticketItem): ?>
                                <div class="row order-item-body">
                                    <div class="order-train">
                                        <div>
                                            <span><?= $ticketItem->trainNum ?></span>
                                            <span><?= $ticketItem->depSta ?></span>
                                            <i class="bi bi-arrow-right"></i>
                                            <span><?= $ticketItem->arrSta ?></span>
                                        </div>
                                        <div>
                                            <span><?= $ticketItem->date ?></span>
                                            <span><?= $ticketItem->depTime ?></span>
                                            <span>开</span>
                                        </div>
                                    </div>
                                    <div class="order-passenger">
                                        <div><?= $orderItem->userName ?></div>
                                        <div>中国居民身份证</div>
                                    </div>
                                    <div class="order-seat"><?= Symbol::seatType($ticketItem->seatType) ?></div>
                                    <div class="order-price">￥<?= $ticketItem->price ?></div>
                                    <div class="order-status">
                                        <div><?= Symbol::status($orderItem->status) ?></div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <div class="row order-item-footer">
                                <div class="col text-end">
                                    <form method="GET">
                                        <input type="hidden" name="orderID" value="<?= $orderItem->orderID ?>">
                                        <?php if ($orderItem->status == 'reserved'): ?>
                                        <button formaction="/orderPrint" class="btn btn-primary btn-sm">打印行程信息</button>
                                        <button formaction="/orderCancel" class="btn btn-warning btn-sm">取消订单</button>
                                        <?php endif ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</main>
    
<?php
    Support::includeView('pageFooter');
?>
