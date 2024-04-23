<?php
use Cake\I18n\FrozenTime;
$time = FrozenTime::now();

$this->assign('title', __('Edit Foto'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Foto'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $foto->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($foto,['type'=>'file']) ?>
    <div class="card-body">
        <?= $this->Form->control('judul') ?>
        <?= $this->Form->control('deskripsi') ?>
        <?= $this->Form->control('tanggal_unggah',['type' => 'hidden','value'=>$time->I18nFormat('yyyy-MM-dd HH:mm:ss'),'readonly'=>true]) ?>
        <?= $this->Html->image('foto/'.$foto->lokasi_file,['height'=>'100px']) ?>
        <?= $this->Form->control('lokasi_file',['type'=>'hidden']) ?>
        <?= $this->Form->control('images',['type'=>'file']) ?>
        <?= $this->Form->control('album_id', ['options' => $album, 'class' => 'form-control']) ?>
        <?= $this->Form->control('user_id', ['type' => 'hidden','value'=> $this->Identity->get('id'), 'class' => 'form-control']) ?>
    </div>
    <div class="card-footer d-flex">
        <div class="mr-auto">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $foto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $foto->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index', $foto->id], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>