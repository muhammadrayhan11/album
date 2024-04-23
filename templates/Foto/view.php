<?php

use Cake\I18n\FrozenTime;
$time = FrozenTime::now();

$likecount = count($foto->likes);

$this->assign('title', __('Foto'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Foto'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-flex flex-align-items-start">
        <div class="flex mr-2">
            <h2 class="card-title"><?= $this->Html->image('foto/'.$foto->lokasi_file, ['style' => 'height: 300px; width: 300px;']) ?></h2>
        </div>
        <div class="flex-grow-1">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <th><?= __('User') ?></th>
                        <td><?= $foto->has('user') ? $this->Html->link($foto->user->username, ['controller' => 'Users', 'action' => 'view', $foto->user->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Album') ?></th>
                        <td><?= $foto->has('album') ? $this->Html->link($foto->album->nama, ['controller' => 'Albums', 'action' => 'view', $foto->album->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Judul') ?></th>
                        <td><?= h($foto->judul) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Tanggal') ?></th>
                        <td><?= h($foto->tanggal_unggah->format('d-m-Y H:i:s'))?></td>
                    </tr>
                    <td>
                        <?php
                        $userLiked = $foto->isLiked($this->Identity->get('id'));
                        if ($userLiked) {
                            echo $this->Form->create(null, [
                                'url' => [
                                    'controller' => 'Likes',
                                    'action' => 'delete',
                                    $userLiked->id
                                ],
                                'type' => 'post'
                            ]);
                            echo $this->Form->button('<i class="fa fa-heart"></i>', [
                                'class' => 'btn btn-danger mr-3',
                                'escapeTitle' => false
                            ]);
                        } else {
                            echo $this->Form->create(null, [
                                'url' => [
                                    'controller' => 'Likes',
                                    'action' => 'add'
                                ],
                                'type' => 'post'
                            ]);
                            echo $this->Form->control('tanggal_like', [
                                'value' => $time->i18nFormat('yyyy-MM-dd HH:mm:ss'),
                                'type' => 'hidden'
                            ]);
                            echo $this->Form->control('user_id', [
                                'type' => 'hidden',
                                'value' => $this->Identity->get('id')
                            ]);
                            echo $this->Form->control('foto_id', [
                                'type' => 'hidden',
                                'value' => $foto->id
                            ]);
                            echo $this->Form->button('<i class="fa fa-heart"></i>', [
                                'class' => 'btn btn-outline-secondary mr-3',
                                'escapeTitle' => false
                            ]);
                        }
                        echo $likecount;
                        echo $this->Form->end();
                        ?>
                    </td>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex">
        <div class="mr-auto">
        <?php if ($this->Identity->get('id') === $foto->user_id) : ?>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $foto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $foto->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="mr-2">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $foto->id], ['class' => 'btn btn-secondary']) ?>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="view text card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Deskripsi') ?></h3>
    </div>
    <div class="card-body">
        <?= $this->Text->autoParagraph(h($foto->deskripsi)); ?>
    </div>
</div>

<!-- kolom Komentar -->

<div class="related related-komentar view card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Nama') ?></th>
                <th><?= __('Isi Komentar') ?></th>
                <th><?= __('Tanggal Komentar') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (empty($foto->komentar)) : ?>
                <tr>
                    <td colspan="6" class="text-muted">
                        <?= __('Komentar record not found!') ?>
                    </td>
                </tr>
            <?php else : ?>
                <?php foreach ($foto->komentar as $komentar) : ?>
                    <tr>
                        <td class="users"><?= h($users[$komentar->user_id])?></td>
                        <td><?= h($komentar->isi_komentar) ?></td>
                        <td><?= h($komentar->tanggal_komentar) ?></td>
                        <td class="actions">
                            <?php if ($this->Identity->get('id') === $komentar->user_id) : ?>
                                <?= $this->Form->postLink(('View'), ['controller' => 'Komentar', 'action' => 'view', $komentar->id], ['class' => 'btn btn-xs btn-outline-primary', 'confirm' => __('Are you sure you want to delete # {0}?', $komentar->id)]) ?>
                                <!-- <?= $this->Form->postLink(('Edit'), ['controller' => 'Komentar', 'action' => 'edit', $komentar->id], ['class' => 'btn btn-xs btn-outline-warning', 'confirm' => __('Are you sure you want to delete # {0}?', $komentar->id)]) ?> -->
                                <?= $this->Form->postLink(('Delete'), ['controller' => 'Komentar', 'action' => 'delete', $komentar->id], ['class' => 'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $komentar->id)]) ?>
                            <?php endif; ?>
                        </td>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <?= $this->Form->create(null, ['url' => ['controller'=>'Komentar', 'action' =>'add'],'role'=>'form']) ?>
        <div class="card-body">
            <?= $this->Form->control('foto_id', ['value' => $foto->id,'type' => 'hidden','options' => $foto, 'class' => 'form-control']) ?>
            <?= $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->Identity->get('id'), 'class' => 'form-control']) ?>
            <?= $this->Form->control('isi_komentar', ['type' => 'textarea']) ?>
            <?= $this->Form->control('tanggal_komentar', ['value' => $time->i18nFormat('yyyy-MM-dd HH:mm:ss'), 'type' => 'hidden']) ?>
        </div>
        <div class="card-footer d-flex">
            <div class="ml-auto">
                <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>