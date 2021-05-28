<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array('pageTitle' => '首页'));
?>
<main>
    <div class="position-relative">
        <div id="carouselExampleIndicators" class="carousel slide index-slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner h-100">
                <div class="carousel-item h-100 active">
                    <img src="/images/banner2.jpg" class="d-block h-100" alt="...">
                </div>
                <div class="carousel-item h-100">
                    <img src="/images/banner5.jpg" class="d-block h-100" alt="...">
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <h5>单程</h5>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="出发地">
                                <button class="btn btn-warning"><i class="bi bi-arrow-left-right"></i></button>
                                <!-- <span class="input-group-text">@</span> -->
                                <input type="text" class="form-control" placeholder="到达地">
                                <input type="text" class="form-control" placeholder="出发日期">
                                <button class="btn btn-warning">查询</button>
                            </div>
                        </form>
                    </div>
                    <div class="mb-2">
                    <h5>车次</h5>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="出发地">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-pin-angle"></i></span>
                                <input type="text" class="form-control" placeholder="车次">
                                <input type="text" class="form-control" placeholder="出发日期">
                                <button class="btn btn-warning">查询</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
    
<?php
    Support::includeView('pageFooter');
?>
