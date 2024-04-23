<?php

use Cake\I18n\FrozenTime;
$time = FrozenTime::now();

$this->assign('title', __('Foto'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Foto')],
]);
?>
<div class="card card-primary card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title">
            <?= __('Kumpulan Foto') ?>
        </h2>
        <div class="d-flex ml-auto">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control form-control-sm',
                'templates' => ['inputContainer' => '{{content}}']
            ]) ?>
            <?= $this->Html->link(__('New Foto'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm ml-2']) ?>
        </div>
    </div>

    <style>
        .foto-card {
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .foto-card .foto-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 8px;
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        .foto-card .foto-overlay .date {
            font-size: 12px;
        }

        .foto-card img {
            width: 300px;
            height: 300px;
            transition: transform 0.3s ease;
            display: block;
        }

        .foto-card:hover img {
            transform: scale(1.05);
        }

    </style>

    <div class="container mt-4">
        <div class="row">
            <?php foreach ($foto as $fotoItem): ?>
                <div class="col-md-4 mb-4">
                    <div class="card foto-card">
                        <a href="<?= $this->Url->build(['action' => 'view', $fotoItem->id]) ?>">
                            <div class="foto-overlay">
                                <span class="username"><?= h($fotoItem->has('users') ? $fotoItem->users->username : '') ?></span>
                                <span class="tanggal_unggah"><?= h($fotoItem->date) ?></span>
                            </div>
                            <img src="<?= 'img/foto/' . $fotoItem->lokasi_file ?>" class="card-img" alt="<?= h($fotoItem->lokasi_file) ?>">
                        </a>
                        <!-- <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                <?= $this->Form->create(null, ['url' => ['controller'=>'Likes', 'action' =>'add'],'role'=>'form']) ?>
                                <?= $this->Form->control('foto_id', ['value' => $fotoItem->id,'type' => 'hidden','options' => $fotoItem->id, 'class' => 'form-control']) ?>
                                <?= $this->Form->control('user_id', ['value' => $this->Identity->get('id'),'type' => 'hidden','options' => $foto, 'class' => 'form-control']) ?>
                                <?= $this->Form->control('tanggal_like', [ 'type'=>'hidden', 'value' => $time->i18nFormat('yyyy-MM-dd HH:mm:ss'),]) ?>
                                <?= $this->Form->button((''), ['class' => 'fa fa-heart danger']) ?>
                                <?= $this->Form->end() ?>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card-footer d-flex flex-column flex-md-row">
        <div class="text-muted">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </div>
        <ul class="pagination pagination-sm mb-0 ml-auto">
            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
</div>
