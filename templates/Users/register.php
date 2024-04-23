<?php
/**
 * @var \App\View\AppView $this
 */

$this->layout = 'CakeLte.login';
?>
<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg"><?= __('Daftar Pengguna Baru') ?></p>
        <?= $this->Form->create($user, ['valueSources' => ['query', 'context']]) ?>
        
        <?= $this->Form->control('nama_lengkap', [
            'placeholder' => __('Nama Lengkap'),
            'label' => false,
            'append' => '<i class="fas fa-id-card"></i>',
        ]) ?>
        <?= $this->Form->control('username', [
            'placeholder' => __('Username'),
            'label' => false,
            'append' => '<i class="fas fa-user"></i>',
        ]) ?>
        <?= $this->Form->control('password', [
            'placeholder' => __('Password'),
            'label' => false,
            'append' => '<i class="fas fa-lock"></i>',
        ]) ?>
        <?= $this->Form->control('email', [
            'placeholder' => __('Email'),
            'label' => false,
            'append' => '<i class="fas fa-envelope"></i>',
        ]) ?>
        <?= $this->Form->control('alamat', [
            'placeholder' => __('Alamat Rumah'),
            'label' => false,
            'append' => '<i class="fas fa-map"></i>',
        ]) ?>

        <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4">
                <?= $this->Form->control(__('Daftar'), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary btn-block',
                ]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <?= $this->Html->link(__('Sudah Punya akun'), ['action' => 'login']) ?>
    </div>
    <!-- /.register-card-body -->
</div>
