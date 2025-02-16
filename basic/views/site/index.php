<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">База даних судових рішень</h1>
    </div>

    <div class="body-content d-flex align-items-center justify-content-center">
        <p><a class="btn btn-lg btn-success" href="<?= Url::toRoute(['/documents']);?>">Пошук судового рішення</a></p>
    </div>
</div>
