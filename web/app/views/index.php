<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array('pageTitle', $pageTitle));
?>
<!-- <main>
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style="height: 500px;">
            <div class="carousel-item active">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>Example headline.</h1>
                        <p>Some representative placeholder content for the first slide of the carousel.</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

                <div class="container">
                    <div class="carousel-caption">
                        <h1>Another example headline.</h1>
                        <p>Some representative placeholder content for the second slide of the carousel.</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>One more for good measure.</h1>
                        <p>Some representative placeholder content for the third slide of this carousel.</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

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

</main>
    
<?php
    Support::includeView('pageFooter');
?>
