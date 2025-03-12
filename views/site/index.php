<?php

/** @var yii\web\View $this */

$this->title = 'Книги';
?>
<div class="site-index">

<div class="container">
        <div class="blocl-articles">
            <div class="row">
                <?php foreach($books as $key => $item):?>
                    <div class="col-md-4">
                    <div class="title-articles"><?=$item["title"]?></div>
                        <div class="block-table-contents">
                        <img src="/images/<?=$item["photo"]?>" height="100%"/>
                        </div>
                        <p class="text-center"><a class="btn-introduction btn-introduction-green" data-id="<?=$item["id"]?>">Описание &raquo;</a></p>
                        <div class="block-buy-article">
                            <div class="cost-article"><?=1000?> &#8381;</div>
                            <div class="btn-buy"><a class="btn-pay btn-pay-dark" href="#" type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="После оплаты статья будет доступна для чтения и скачивания в личном кабинете">Купить</a></div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
