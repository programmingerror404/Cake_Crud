<div class="users form large-7 medium-5 columns content">
	<?= $this->Form->create() ?>
	    <fieldset>
	        <legend><?= __('Please enter your username and password') ?></legend>
	        <?= $this->Form->control('email') ?>
	        <?= $this->Form->control('password') ?>
	    </fieldset>
	<?= $this->Form->button(__('Login')); ?>
	<?= $this->Form->end() ?>
</div>