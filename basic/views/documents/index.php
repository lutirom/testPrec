<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\DocType;
use yii\bootstrap5\LinkPager;
use yii\helpers\BaseVarDumper;

$this->title = 'Документи';
// BaseVarDumper::dump($models);
$this->params['breadcrumbs'][] = $this->title;

$paginationBlock = LinkPager::widget([
    'pagination' => $pages,
]);
?>
<div class="helloworld h-100">
    
    <div class="head row py-2 justify-content-between align-items-center">
        <h1 class="col"><?= Html::encode($this->title) ?></h1>
        <div class="col-12 col-md-6 ">
            <div class="position-relative">
                <input type="text" class="form-control search-bar" id="search" placeholder="Пошук за номером справи" data-url="<?= Url::toRoute(['getDocument'])?>">
                <div id="search-list" class="search-list d-none position-absolute top-100 w-100 border bg-white rounded-1">
                    <p class="mb-0 p-2">Не знайдено</p>
                </div>
            </div>
            
        </div>
    </div>
    <div class="filters d-flex gap-2">
        <p>Cортувати за:</p>
        <?php if (Yii::$app->getRequest()->getQueryParam('sort') === 'judgment'):?>
            <a class="text-decoration-none" href="<?= Url::toRoute(['/documents'])?>">Замовченням(id)</a>
            <p class="text-muted text-decoration-underline">Типом судочинства</p>
        <?php else:?>
            <p class="text-muted text-decoration-underline">Замовченням(id)</p>
            <a class="text-decoration-none" href="<?= Url::toRoute(['/documents', 'sort' => 'judgment'])?>">Типом судочинства</a>
        <?php endif; ?>
    </div>

        <div>
            <div class="table-header bg-secondary text-white">
                <div class="row gx-0">
                    <div class="number col-4 col-md-3 p-2 d-flex align-items-center justify-content-center col">
                        <p class="m-0">Номер справи</p>
                    </div>
                    <div class="name col-4 col-md-3 p-2 d-flex align-items-center justify-content-center col">
                        <p class="m-0">Судочинство</p>
                    </div>
                    <div class="date col-4 col-md-3 p-2 d-flex align-items-center justify-content-center col">
                        <p class="m-0">Дата</p>
                    </div>
                    <div class="more d-none d-md-block col-md-3 p-2 d-flex align-items-center justify-content-center col">

                    </div>
                </div>
            </div>
            <div class="table-body">
                <?php foreach ($documents as $doc): ?>
                    <div class="row border-bottom border-black gx-0">
                        <div class="number p-2 d-flex align-items-center justify-content-start col col-md-3">
                            <p class="m-0"><?= Html::encode($doc->num_litigation)?></p>
                        </div>
                        <div class="name p-2 d-flex align-items-center justify-content-center col col-md-3">
                        <p class="m-0"><?= DocType::getJudgmentType($doc->justice_id)?></p>
                        </div>
                        <div class="date p-2 d-flex align-items-center justify-content-center col col-md-3">
                            <p class="m-0"><?= Html::encode($doc->a_day.'/'.$doc->a_month.'/'.$doc->a_year)?></p>
                        </div>
                        <div class="more p-2 d-flex align-items-center justify-content-center col-12 col-md-3">
                            <a href=<?= $url = Url::toRoute(['document', 'id' => $doc->a_id]);?> class="btn btn-outline-primary w-100">
                                Переглянути
                            </a>
                        </div>
                    </div>
                
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="pagination-block mt-5">
        <?= $paginationBlock ?>
    </div>
</div>

<style>
    .pagination-block .pagination {
        justify-content: center;
    }

    .list-phrase:hover {
        background-color: #ced3ff; 
    }
</style>

<script>
    const searchBar = document.getElementById('search')
    const searchListElement = document.getElementById('search-list');

    document.addEventListener('click', function(e) {
        if (!e.target.classList.contains('search-list') && !e.target.classList.contains('search-bar'))
            searchListElement.classList.add('d-none');
    })

    searchBar.addEventListener('keyup', async function(e) {
        if(e.target.value.length > 1) {
            const list = await getData(e.target);
            updateList(list, e.target.value);
            return;
        }

        updateList();
    })

    searchBar.addEventListener('focus', function(){
        if (searchListElement.classList.contains('d-none') && searchBar.value.length > 1) {
            searchListElement.classList.remove('d-none');
        }
    });

    async function getData(form) {
        const string = form.value;

        const dataString ={
            'strings' : string,
        };

        const json = JSON.stringify(dataString);

        const req = await fetch(`${form.dataset.url}?line=${form.value}`, {
            method: 'GET',
        });

        const res = await req.json();

        const rawList = res.docList;

        return rawList;
    }

    function updateList(rawList = null, searchedPhrase) {

        if (rawList === null) {
            searchListElement.classList.add('d-none')
            return;
        }

        if (rawList.length > 0) {
            
            searchListElement.classList.remove('d-none');

            let newList = '';

            const regex = new RegExp(`(${searchedPhrase})`);

            rawList.map(item => {
                let newPhrase = '';
                const splitArray = item.num_litigation.split(regex);

                splitArray.map(phrase => {
                    
                    if (phrase === searchedPhrase) {
                        newPhrase += `<span class=bg-warning>${phrase}</span>`
                        return;
                    }
                    newPhrase += `<span>${phrase}</span>`
                }) 

                newList += `<a href='/documents/document?id=${item.a_id}' class="d-flex justify-content-between list-phrase m-0 p-2 text-decoration-none text-black">
                                <p class="m-0">Справа номер: ${newPhrase}</p>
                                <p class="m-0 text-primary text-underline">Переглянути</p>
                            </a>`
            });
            console.log("🚀 ~ updateList ~ newList:", newList)
            
            searchListElement.innerHTML = newList;
        } else {
            searchListElement.innerHTML = ` <p class="m-0 p-2">No results</p>`;
        }
    }
        
</script>
