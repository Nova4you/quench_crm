<div class="box grid_16">
	<?php
		echo $this->Form->create('ClientSocial');
		foreach ($social_fields as $key=>$value) {
			?>
			<fieldset class="label_side">
				<label><?php echo $value?> </label>
				<div>
				<?php
				echo $this->Form->input($key,array('label'=>'','div'=>false,'placeholder'=>$value));
				?>
				</div>
			</fieldset>
			<?php
		}
	?>
	<fieldset class="label_top">
		<p>&nbsp; </p>
		<div class="clearfix">
			<button class="green text_only has_text" id="save_social_ajax">
				<span>Save Now</span>
			</button>
		</div>
	</fieldset>
	<?php echo $this->Form->end();?>
</div>