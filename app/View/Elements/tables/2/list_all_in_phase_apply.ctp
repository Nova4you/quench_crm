<table class="static"> 
					<thead> 
						<tr> 
							<th>
								<?php 
								echo $this->Form->checkbox('select_all');//js会响应它的事件
								?>
							</th>
							<th>姓名</th>
							<th>负责老师</th>
							<th>学校</th> 
							<th>当前阶段</th>
							<th>机构</th> 
							<th>已提交申请资料</th> 
							<th>未提交申请资料</th> 
							<th>提交外方</th>
							<th>操作</th>
						</tr> 
					</thead> 
					<tbody>
						<?php 
							$applicant_files_status = array(0=>'未完成',1=>'已完成，等待外方安置',2=>'外方已通过');
							foreach ($data as $value) {
								echo '<tr><td>',
									$this->Form->checkbox('select_item_'.$value['Enquiry']['id'],
										array('class'=>'select_itmes',
											'title'=>$value['Enquiry']['mobile'],
											'style'=>'height:11px;line-height:0px;margin:0px;')),
									'</td>';
								echo '<td id="e_name'.$value['Enquiry']['id'].'">',$value['Enquiry']['name'],'</td>';
								echo '<td>',$value['User']['name'],'</td>';
								echo '<td>',$value['Enquiry']['school'],'</td>';
								echo '<td>',$value['Phase']['name'],($value['Applicant']['status']==WAS_CANCELED)?'(<b style="color:red">退出</b>)':'','</td>';
								echo '<td>CHI</td>';
								//已提交的申请资料列表
								$temp = array();
								for ($i = 0; $i < count($value['ApplicantFile']); $i++) {
									if (isset($total_file_needed[$value['ApplicantFile'][$i]['download_file_id']])) {
										$txt = $total_file_needed[$value['ApplicantFile'][$i]['download_file_id']];
										if ($value['ApplicantFile'][$i]['is_passed']==1){
											$txt .= ' ->已通过';
										}else{
											if ($value['ApplicantFile'][$i]['is_readed']==1) {
												$txt .= ' ->已审核';
											}else{
												$txt .= ' ->未审核';
											}
										}
										$temp[]=$txt;
										unset($total_file_needed[$value['ApplicantFile'][$i]['download_file_id']]);
									}
								}
								echo '<td>',$this->Form->input('temp',array('options'=>$temp,'label'=>FALSE,'div'=>FALSE)),'</td>';
								if (count($total_file_needed)==0) {
									echo '<td>已全部提交</td>';
								}else{
									echo '<td>',$this->Form->input('temp',array('options'=>$total_file_needed,'label'=>FALSE,'div'=>FALSE)),'</td>';
								}
								echo '<td>',$applicant_files_status[$value['Applicant']['application_data']],'</td>';
								echo '<td style="display:none"><div id="email_addr_'.$value['Enquiry']['id'].'">',$value['Enquiry']['email'],'</div></td>';
								echo '<td style="display:none"><div id="mobile_nb_'.$value['Enquiry']['id'].'">',$value['Enquiry']['mobile'],'</div></td>';//给手机号一个特定的id，便于发短信的时候提取用
								echo '<td><div class="action_trigger" name="'.$value['Enquiry']['id'].'">更多操作</div></td></tr>';
							}
						?>
					</tbody>
				</table>