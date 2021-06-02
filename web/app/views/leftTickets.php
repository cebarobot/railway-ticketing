<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array(
        'pageTitle' => '购买车票',
        'activeNavItem' => '购买车票',
    ));

    $curDate = $curDate ?? (new DateTime())->format('Y-m-d');
    $dateList = array();
    for ($var_i = 0; $var_i < 7; $var_i ++) {
        $date = new DateTime();
        $date->add(new DateInterval("P{$var_i}D"));
        $dateList []= array(
            'date' => $date->format('Y-m-d'),
            'week' => Support::getWeekStr($date->format('w')),
        );
    }
?>

<main class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3 align-items-center">
                        <div class="col-5 col-lg-3" >
                            <label class="visually-hidden" for="inlineFormInputGroupUsername">Username</label>
                            <div class="input-group">
                                <div class="input-group-text">出发地</div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="北京">
                            </div>
                        </div>
                        <div class="col-2 col-lg-1 text-center">
                            <button class="btn btn-warning"><i class="bi bi-arrow-left-right"></i></button>
                        </div>
                        <div class="col-5 col-sm-5 col-lg-3" >
                            <label class="visually-hidden" for="inlineFormInputGroupUsername">Username</label>
                            <div class="input-group">
                                <div class="input-group-text">目的地</div>
                                <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="上海">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3" >
                            <label class="visually-hidden" for="inlineFormInputGroupUsername">Username</label>
                            <div class="input-group">
                                <div class="input-group-text">日期</div>
                                <input type="date" class="form-control" id="inlineFormInputGroupUsername">
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 btn-group">
                            <button class="btn btn-warning"><i class="bi bi-search"></i> 查找</button>
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
                        <a class="nav-link <?= $oneDate['date'] == $curDate? 'active' : '' ?>" href="#">
                            <?= $oneDate['date'] ?><br>
                            <?= $oneDate['week'] ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
            <div class="ticket-list-box p-4">
                <div class="row row-cols-auto mb-4">
                    <div class="fw-bold"><?= $fromCity ?> <i class="bi bi-arrow-right"></i> <?= $toCity ?></div>
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
                        <div class="row ticket-res-item py-4">
                            <div class="ticket-info">
                                <div class="row ticket-info-item my-3">
                                    <div class="ticket-info-no"><?= $ticketItem['trainNum'] ?></div>
                                    <div class="ticket-info-dep">
                                        <div class="ticket-time"><?= $ticketItem['depTime'] ?></div>
                                        <div class="ticket-sta"><?= $ticketItem['depSta'] ?></div>
                                    </div>
                                    <div class="ticket-info-du"><?= $ticketItem['duration'] ?></div>
                                    <div class="ticket-info-arr">
                                        <div class="ticket-time"><?= $ticketItem['arrTime'] ?></div>
                                        <div class="ticket-sta"><?= $ticketItem['arrSta'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ticket-buy">
                                <?php foreach ($ticketItem['seatList'] as $seatItem): ?>
                                    <div class="ticket-buy-item row my-1">
                                        <div class="ticket-buy-type">
                                            <?= $seatItem['seatType'] ?>
                                        </div>
                                        <div class="ticket-buy-price">
                                            ￥<?= $seatItem['price'] ?>
                                        </div>
                                        <div class="ticket-buy-btn">
                                            <button class="btn btn-warning btn-sm">
                                                购买
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
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
