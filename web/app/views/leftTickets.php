<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array(
        'pageTitle' => '首页',
        'activeNavItem' => '购买车票',
    ));
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
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h5>筛选</h5>   
                </div>
                <ul class="list-group list-group-flush f-sm">
                    <li class="list-group-item">
                        <h6>车次类型</h6>
                        <ul>
                            <li>高速动车组列车（G）</li>
                            <li>城际动车组列车（C）</li>
                            <li>普通动车组列车（D）</li>
                            <li>直达特快列车（Z）</li>
                            <li>特快列车（T）</li>
                            <li>快速列车（K）</li>
                            <li>普通列车</li>
                            <li>旅游列车（Y）</li>
                            <li>市郊列车（S）</li>
                        </ul>
                    </li>
                    <li class="list-group-item">
                        <h6>出发车站</h6>
                        <ul>
                            <li>北京</li>
                            <li>北京西</li>
                            <li>北京北</li>
                            <li>北京南</li>
                            <li>北京东</li>
                        </ul>
                    </li>
                    <li class="list-group-item">
                        <h6>到达车站</h6>
                        <ul>
                            <li>北京</li>
                            <li>北京西</li>
                            <li>北京北</li>
                            <li>北京南</li>
                            <li>北京东</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-10">
            <ul class="nav nav-tabs text-center f-sm">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">2021-05-31<br>周一</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">2021-06-01<br>周二</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">2021-06-02<br>周三</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">2021-06-03<br>周四</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">2021-06-04<br>周五</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">2021-06-05<br>周六</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">2021-06-06<br>周日</a>
                </li>
            </ul>
            <div class="ticket-list-box p-4">
                <div class="row row-cols-auto mb-4">
                    <div class="fw-bold">北京 <i class="bi bi-arrow-right"></i> 上海</div>
                    <div class="ms-3"><small class="text-secondary">(找到 3 条结果)</small></div>
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
                    <div class="row ticket-res-item py-4">
                        <div class="ticket-no">G1</div>
                        <div class="ticket-dep">
                            <div class="ticket-time">09:00</div>
                            <div class="ticket-sta">北京南</div>
                        </div>
                        <div class="ticket-du">4 小时 28 分钟</div>
                        <div class="ticket-arr">
                            <div class="ticket-time">14:49</div>
                            <div class="ticket-sta">上海虹桥</div>
                        </div>
                        <div class="ticket-buy">
                            <div class="ticket-buy-item row my-1">
                                <div class="ticket-buy-type">
                                    商务座
                                </div>
                                <div class="ticket-buy-price">
                                    ￥1873
                                </div>
                                <div class="ticket-buy-btn">
                                    <button class="btn btn-warning btn-sm">
                                        购买
                                    </button>
                                </div>
                            </div>
                            <div class="ticket-buy-item row my-1">
                                <div class="ticket-buy-type">
                                    一等座
                                </div>
                                <div class="ticket-buy-price">
                                    ￥1006
                                </div>
                                <div class="ticket-buy-btn">
                                    <button class="btn btn-warning btn-sm">
                                        购买
                                    </button>
                                </div>
                            </div>
                            <div class="ticket-buy-item row my-1">
                                <div class="ticket-buy-type">
                                    二等座
                                </div>
                                <div class="ticket-buy-price">
                                    ￥598
                                </div>
                                <div class="ticket-buy-btn">
                                    <button class="btn btn-warning btn-sm">
                                        购买
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
    Support::includeView('pageFooter');
?>
