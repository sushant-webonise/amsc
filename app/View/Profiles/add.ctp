<div class="profiles form">
<?php echo $this->Form->create('Profile');?>
	<fieldset>
		<legend><?php echo __('Add Profile'); ?></legend>
	<?php
		echo $this->Form->input('profile_type');
		echo $this->Form->input('email');
		echo $this->Form->input('education');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Profiles'), array('action' => 'index'));?></li>
	</ul>
</div>
