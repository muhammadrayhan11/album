<?php

use Cake\I18n\FrozenTime;
$time = FrozenTime::now();

$this->assign('title', __('Edit Album'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Album'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $album->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($album) ?>
    <div class="card-body">
        <?= $this->Form->control('nama') ?>
        <?= $this->Form->control('deskripsi') ?>
        <?= $this->Form->control('tanggal_dibuat',['type'=>'hidden','value'=>$time->I18nFormat('yyyy-MM-dd'),'readonly'=>true]) ?>
        <?= $this->Form->control('user_id', ['type' => 'hidden','value'=> $this->Identity->get('id'), 'class' => 'form-control']) ?>
    </div>
    <div class="card-footer d-flex">
        <div class="mr-auto">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $album->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $album->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'view', $album->id], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>