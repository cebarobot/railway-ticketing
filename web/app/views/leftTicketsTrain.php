<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array(
        'pageTitle' => '车次查询',
        'activeNavItem' => '车次查询',
    ));

    $curDate = $curDate ?? (new DateTime())->format('Y-m-d');
    $dateList = array();
    $dateLinkBase = "/leftTickets/{$type}?trainNum={$trainNum}&depSta={$depSta}";
    for ($var_i = 0; $var_i < 7; $var_i ++) {
        $date = new DateTime();
        $date->modify("+$var_i day");
        $dateStr = $date->format('Y-m-d');
        $dateList []= array(
            'date' => $dateStr,
            'week' => Support::getWeekStr($date->format('w')),
            'link' => $dateLinkBase . "&date={$dateStr}",
        );
    }
?>

<main class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3 align-items-center">
                        <div class="col-6 col-lg-3" >
                            <label class="visually-hidden" for="trainNum">车次</label>
                            <div class="input-group">
                                <div class="input-group-text">车次</div>
                                <input type="text" class="form-control" id="trainNum" name="trainNum" value="<?= $trainNum ?>">
                            </div>
                        </div>
                        <div class="col-6 col-lg-3" >
                            <label class="visually-hidden" for="depSta">出发站</label>
                            <div class="input-group">
                                <div class="input-group-text">出发站</div>
                                <input type="text" class="form-control" id="depSta" name="depSta" value="<?= $depSta ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3" >
                            <label class="visually-hidden" for="date">日期</label>
                            <div class="input-group">
                                <div class="input-group-text">日期</div>
                                <input type="date" class="form-control" id="date" name="date" value="<?= $curDate ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 btn-group">
                            <button class="btn btn-primary" formaction="/leftTickets/Train"><i class="bi bi-search"></i> 查找</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2 f-sm">
            <h5>筛选（未实装）</h5>
            <div class="border-bottom mb-2">
                <h6>车次类型</h6>
                <div class="nav nav-pills flex-column">
                    <a class="nav-link active" href="#">高速动车组（G）</a>
                    <a class="nav-link" href="#">城际动车组（C）</a>
                    <a class="nav-link" href="#">普通动车组（D）</a>
                    <a class="nav-link" href="#">直达特快列车（Z）</a>
                    <a class="nav-link" href="#">特快列车（T）</a>
                    <a class="nav-link" href="#">快速列车（K）</a>
                    <a class="nav-link" href="#">普通列车</a>
                    <a class="nav-link" href="#">旅游列车（Y）</a>
                    <a class="nav-link" href="#">市郊列车（S）</a>
                </div>
            </div>
            <div class="border-bottom mb-2">
                <h6>出发车站</h6>
                <div class="nav nav-pills flex-column">
                    <a class="nav-link" href="#">北京</a>
                    <a class="nav-link" href="#">北京西</a>
                    <a class="nav-link" href="#">北京北</a>
                    <a class="nav-link active" href="#">北京南</a>
                    <a class="nav-link" href="#">北京东</a>
                </div>
            </div>
            <div class="border-bottom mb-2">
                <h6>到达车站</h6>
                <div class="nav nav-pills flex-column">
                    <a class="nav-link" href="#">上海</a>
                    <a class="nav-link" href="#">上海南</a>
                    <a class="nav-link active" href="#">上海虹桥</a>
                    <a class="nav-link" href="#">北京西</a>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <ul class="nav nav-tabs text-center f-sm">
                <?php foreach ($dateList as $oneDate): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $oneDate['date'] == $curDate? 'active' : '' ?>" href="<?= $oneDate['link'] ?>">
                            <?= $oneDate['date'] ?><br>
                            <?= $oneDate['week'] ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
            <div class="ticket-list-box p-4">
                <div class="row row-cols-auto mb-4">
                    <div class="fw-bold"><?= $trainNum ?></div>
                    <div class=""><span class="fw-bold"><?= $depSta ?></span> <small>站出发</small></div>
                    <div class="ms-3"><small class="text-secondary">(找到 <?= count($ticketList) ?> 条结果)</small></div>
                </div>
                <div class="mt-4">
                    <div class="row ticket-res-header py-2">
                        <div class="ticket-no">车次</div>
                        <div class="ticket-dep">出发</div>
                        <div class="ticket-du">历时</div>
                        <div class="ticket-arr">到达</div>
                        <div class="ticket-price">票价</div>
                        <div class="ticket-btn"></div>
                    </div>
                    <?php foreach ($ticketList as $ticketItem): ?>
                        <div class="ticket-res-item py-3">
                            <?php foreach ($ticketItem->singleTickets as $singleTicketItem): ?>
                                <div class="row ticket-info">
                                    <div class="ticket-no"><?= $singleTicketItem->trainNum ?></div>
                                    <div class="ticket-dep">
                                        <div class="ticket-time"><?= $singleTicketItem->depTime ?></div>
                                        <div class="ticket-sta"><?= $singleTicketItem->depSta ?></div>
                                    </div>
                                    <div class="ticket-du"><?= $singleTicketItem->travelTime ?></div>
                                    <div class="ticket-arr">
                                        <div class="ticket-time"><?= $singleTicketItem->arrTime ?></div>
                                        <div class="ticket-sta"><?= $singleTicketItem->arrSta ?></div>
                                    </div>
                                    <div class="ticket-buy">
                                        <?php foreach ($singleTicketItem->seats as $seatKey => $seatItem): ?>
                                            <div class="ticket-buy-item row my-1">
                                                <div class="ticket-buy-type">
                                                    <?= $seatItem['seatType'] ?>
                                                </div>
                                                <div class="ticket-buy-price">
                                                    ￥<?= $seatItem['price'] ?>
                                                </div>
                                                <div class="ticket-buy-btn">
                                                    <form action="/orderCheck" method="POST">
                                                        <input type="hidden" name="trainInfo" value="<?= $ticketItem->getTrainInfoJson() ?>">
                                                        <input type="hidden" name="seatInfo-0" value="<?= $singleTicketItem->getSeatInfoJson($seatKey) ?>">
                                                        <button class="btn btn-warning btn-sm">
                                                            购买
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
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
