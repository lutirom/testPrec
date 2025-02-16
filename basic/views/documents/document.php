<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\DocType;
use yii\bootstrap5\LinkPager;
use yii\helpers\BaseVarDumper;

$this->title = 'Спарва номер '.$doc->num_litigation;
// BaseVarDumper::dump($doc);
$this->params['breadcrumbs'][] = ['label'=> 'Список документів', 'url'=> '/documents/index'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="doc-wrapper">
    <div class="d-flex p-2 justify-content-between align-items-center border rounded-2">
        <h1><?= Html::encode($this->title) ?></h1>
        <a href="<?= Url::toRoute(['/documents'])?>" class="btn btn-primary m-0">Назад</a>
    </div>
    <p class=" border-start border-2 mt-4 p-2 pl-4 border-success fw-bold"><?= DocType::getType($doc->decision_id) ?></p>
    <h3 class="text-center"><?=$doc->doc_header?></h3>
    <div class="w-100 d-flex justify-content-center">
        <div class='border-bottom border-black w-50 my-4'></div>
    </div>
    <p class="text-center"><?=$doc->decision?></p>
</div>

<style>
    .head-doc {
        text-align: center;
    }
</style>