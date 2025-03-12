<?php

/** @var yii\web\View $this */

$this->title = 'Книги';
?>
<div class="site-index">

<div class="container">
        <div class="blocl-articles">
            <div class="row">
                <?php foreach($books as $key => $item):?>
                    <div class="col-md-3">
                    <div class="title-articles"><?=$item["title"]?></div>
                        <div class="block-table-contents">
                        <img src="/images/<?=$item["photo"]?>" height="100%"/>
                        </div>
                        <p class="text-center"><a class="btn-introduction btn-introduction-green" data-id="<?=$item["id"]?>"></a></p>
                        <div class="block-buy-article">
                            <div class="cost-article">Дата выхода книги <?= date('d.m.Y', strtotime($item["year_release"]))?></div>
                            <div class="btn-buy"><a class="btn-pay btn-pay-dark" href="#" type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="После оплаты статья будет доступна для чтения и скачивания в личном кабинете"></a></div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
