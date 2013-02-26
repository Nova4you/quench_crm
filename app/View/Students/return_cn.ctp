<?php 
	echo $this->Html->script('ajax_utils/utils_students',false); 
?>
<div class="flat_area grid_16">
	<h2>我的归国资料管理</h2>
</div>
<div class="box grid_16">
	<h2 class="box_head grad_blue">
		申请资料进展
		<?php echo ($this->Session->read('application_data')==1 && $phase_id==PHASE_APPLY)?': 您申请阶段的资料已准备完毕并提交外方后台，请耐心等待外方机构的岗位安置。':''; ?>
	</h2>
		<a href="#" class="grabber"></a>
		<a href="#" class="toggle"></a>
		<div class="toggle_container">
				<?php 
					if (isset($msg_type)) {
						echo $this->Msg->output( $msg_type,$this->Session->flash() );
					}
				?>
				<div class="block">
				<table class="static"> 
					<thead> 
						<tr> 
							<th>要求的文件</th>
							<th>最后提交的文件</th>
							<th>上次提交日期</th>
							<th>审核结果</th> 
							<th>老师留言</th> 
							<th>操作</th>
						</tr> 
					</thead> 
					<tbody>
						<?php 
						foreach ($data as $value){
							?>
							<tr>
								<td><?php echo (strlen($value['DownloadFile']['title'])==0)?$value['DownloadFile']['file_name']:$value['DownloadFile']['title']; ?></td>
								<td><?php 
									echo is_null($value['ApplicantFile']['file_name'])
										?'未提交文件'
										:$this->Html->link(
											$value['ApplicantFile']['file_name'],
											array('controller'=>'ApplicantFiles','action'=>'download',$value['ApplicantFile']['id'])
										); 
								?></td>
								<td><?php 
									echo is_null($value['ApplicantFile']['modified'])?'无':$value['ApplicantFile']['modified']; 
								?></td>
								<td>
								<?php echo ($value['ApplicantFile']['is_passed']==1)?'<b style="color:green">通过</b>':'<b style="color:red">未通过</b>'; ?>
								</td>
								<td>
								<?php echo is_null($value['ApplicantFile']['latest_comments'])?'没有留言':$value['ApplicantFile']['latest_comments']; ?>
								</td>
								<td>
								<?php 
									if($value['ApplicantFile']['is_passed']!=1){
										?>
										<a class="applicant_submit_file_btn" id="<?php echo $value['DownloadFile']['id']; ?>" href="#applicant_submit_file_form">文件上传</a>&nbsp;&nbsp;&nbsp;
										<?php
									}
									if ($phase_id!=PHASE_SETTLE) {
										if (strlen($value['DownloadFile']['file_name'])==0)  {
											echo '没有模版，请直接上传';
										}else{
											echo $this->Html->link('下载文件模板',array('controller'=>'DownloadFiles','action'=>'download',$value['DownloadFile']['id']));
										}
									}else{
										if (is_null($value['ApplicantFile']['file_name'])) {
											echo '您的Offer还未到';;
										}else{
											echo $this->Html->link(
												'下载我的Offer',
												array('controller'=>'ApplicantFiles','action'=>'download',$value['ApplicantFile']['id'])
											);
										}
									}
								?>
								</td>
							</tr>
							<?php
							}
						?>
					</tbody>
				</table>
				</div>
		</div>		
</div>

<?php //归国阶段，加入填写申请人行程单的表格 ?>
	<div class="box grid_16">
		<h2 class="box_head grad_navy">请填写您的行程单</h2>
		<div class="toggle_container">
		<?php echo $this->element('applicant_phases/phase_return_student'); 
		//必须要设定一个app的id	
		echo $this->Form->input('Applicant.id',array('type'=>'hidden','value'=>$this->Session->read('applicant_id')));
		?>
		</div>
	</div>

<div style="display:none">
	<div id="applicant_submit_file_form" style="width:500px;height:300px;overflow:auto;">
		<h2 style="margin-top: 10px;">
		上传我的资料
		</h2>
		<?php 
			echo $this->Form->create(NULL,array('type'=>'file','url'=>'/Students/upload')); 
			echo $this->Form->input('ApplicationFile.applicant_id',array('type'=>'hidden','value'=>$this->Session->read('applicant_id')));
			echo $this->Form->input('ApplicationFile.download_file_id',array('type'=>'hidden','value'=>''));
			echo $this->Form->input('ApplicationFile.phase_id',array('type'=>'hidden','value'=>$phase_id));
		?>
		<fieldset class="label_side">
			<label>选择文件</label>
				<div>
					<?php echo $this->Form->file('Applicant.application_form',array('class'=>'uniform','id'=>'fileupload','type'=>'file')); ?>
				</div>
		</fieldset>
		<input type="submit" class="short_message_btn" value="上传我的资料" />
		<?php echo $this->Form->end();?>
	</div>
</div>
