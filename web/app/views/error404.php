<?php
    use \foundation\Support;
    Support::includeView('pageHeader', array('pageTitle' => '首页'));
?>

<main class="container mt-3">
    <h1>404</h1>
    <p>似乎没有找到您访问的页面……</p>
</main>
    
<?php
    Support::includeView('pageFooter');
?>
