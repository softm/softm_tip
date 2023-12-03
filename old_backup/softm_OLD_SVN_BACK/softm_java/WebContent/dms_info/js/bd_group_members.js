function onInit(args) {
	fList();
}


function fList() {
	call('JSON', "info/group_members", {},
			function(json) {
				if( json['return'] == '200') {
					$("#member_list1").empty();
					$("#member_list2").empty();
					var items1 = [];
					var items2 = [];
					var items3 = [];
					var list1 = json.list1;
					var list2 = json.list2;
					var list33 = json.list3;
					
					items1.push('<table width="730" border="0" cellspacing="0" cellpadding="0">\n');
					for ( var i=0;i<json.list1.length;i++) {
						var item = list1[i];
						if(i == 0) {
							items1.push('<tr>\n');
						} else if((i%2) == 0) {
							items1.push('</tr>\n');
							items1.push('<tr>\n');
						}
						items1.push('	<td width="365" align="center" valign="top" >\n');
						items1.push('		<table width="360" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">\n');
						items1.push('		<tr>\n');
						items1.push('			<td width="120" align="center" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items1.push('				<table width="110" border="0" cellspacing="0" cellpadding="0">\n');
						items1.push('				<tr>\n');
						items1.push('					<td><img src="' + item.member_photo + '"></td>\n');
						items1.push('				</tr>\n');
						items1.push('				</table>\n');
						items1.push('			</td>\n');
						items1.push('			<td width="226" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items1.push("<b>" + item.ko_name + " " + item.bd_position + " / " + item.group_position + "</b><br>");
	
						var list3 = item.academic_list;
						
						if(list3 != undefined && list3 != "") {
							for(var j=0; j < list3.length; j++) {
								var item3 = list3[j];
								items1.push(item3.school_name + " " + item3.school_department + "<br>");
							}
						}
						
						var list4 = item.career_list;
						
						if(list4 != undefined && list4 != "") {
							for(var j=0; j < list4.length; j++) {
								var item4 = list4[j];
								items1.push(item4.job_name + " " + item4.position + "<br>");
							}
						}
						
						items1.push('			</td>\n');
						items1.push('		</tr>\n');
						items1.push('		</table>\n');
						items1.push('	</td>\n');
					}
					
					if((json.list1.length%2) != 0) {
						items1.push('	<td width="365" align="center" valign="top" >\n');
						items1.push('		<table width="360" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">\n');
						items1.push('		<tr>\n');
						items1.push('			<td width="120" align="center" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items1.push('				<table width="110" border="0" cellspacing="0" cellpadding="0">\n');
						items1.push('				<tr>\n');
						items1.push('					<td>&nbsp;</td>\n');
						items1.push('				</tr>\n');
						items1.push('				</table>\n');
						items1.push('			</td>\n');
						items1.push('			<td width="226" bgcolor="#FFFFFF" style="padding:5px;">&nbsp;</td>\n');
						items1.push('		</tr>\n');
						items1.push('		</table>\n');
						items1.push('	</td>\n');
					}
					items1.push('</tr>\n');
					items1.push('</table>\n');
					
					items2.push('<table width="730" border="0" cellspacing="0" cellpadding="0">\n');
					for ( var i=0;i<json.list2.length;i++) {
						var item = list2[i];
						if(i == 0) {
							items2.push('<tr>\n');
						} else if((i%2) == 0) {
							items2.push('</tr>\n');
							items2.push('<tr>\n');
						}
						items2.push('	<td width="365" align="center" valign="top" >\n');
						items2.push('		<table width="360" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">\n');
						items2.push('		<tr>\n');
						items2.push('			<td width="120" align="center" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items2.push('				<table width="110" border="0" cellspacing="0" cellpadding="0">\n');
						items2.push('				<tr>\n');
						items2.push('					<td><img src="' + item.member_photo + '"></td>\n');
						items2.push('				</tr>\n');
						items2.push('				</table>\n');
						items2.push('			</td>\n');
						items2.push('			<td width="226" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items2.push("<b>" + item.ko_name + " " + item.bd_position + " / " + item.group_position + "</b><br>");
	
						var list3 = item.academic_list;
						
						if(list3 != undefined && list3 != "") {
							for(var j=0; j < list3.length; j++) {
								var item3 = list3[j];
								items2.push(item3.school_name + " " + item3.school_department + "<br>");
							}
						}
						
						var list4 = item.career_list;
						
						if(list4 != undefined && list4 != "") {
							for(var j=0; j < list4.length; j++) {
								var item4 = list4[j];
								items2.push(item4.job_name + " " + item4.position + "<br>");
							}
						}
						
						items2.push('			</td>\n');
						items2.push('		</tr>\n');
						items2.push('		</table>\n');
						items2.push('	</td>\n');
					}
					
					if((json.list2.length%2) != 0) {
						items2.push('	<td width="365" align="center" valign="top" >\n');
						items2.push('		<table width="360" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">\n');
						items2.push('		<tr>\n');
						items2.push('			<td width="120" align="center" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items2.push('				<table width="110" border="0" cellspacing="0" cellpadding="0">\n');
						items2.push('				<tr>\n');
						items2.push('					<td>&nbsp;</td>\n');
						items2.push('				</tr>\n');
						items2.push('				</table>\n');
						items2.push('			</td>\n');
						items2.push('			<td width="226" bgcolor="#FFFFFF" style="padding:5px;">&nbsp;</td>\n');
						items2.push('		</tr>\n');
						items2.push('		</table>\n');
						items2.push('	</td>\n');
					}
					items2.push('</tr>\n');
					items2.push('</table>\n');
					
					items3.push('<table width="730" border="0" cellspacing="0" cellpadding="0">\n');
					for ( var i=0;i<json.list3.length;i++) {
						var item = list33[i];
						if(i == 0) {
							items3.push('<tr>\n');
						} else if((i%2) == 0) {
							items3.push('</tr>\n');
							items3.push('<tr>\n');
						}
						items3.push('	<td width="365" align="center" valign="top" >\n');
						items3.push('		<table width="360" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">\n');
						items3.push('		<tr>\n');
						items3.push('			<td width="120" align="center" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items3.push('				<table width="110" border="0" cellspacing="0" cellpadding="0">\n');
						items3.push('				<tr>\n');
						items3.push('					<td><img src="' + item.member_photo + '"></td>\n');
						items3.push('				</tr>\n');
						items3.push('				</table>\n');
						items3.push('			</td>\n');
						items3.push('			<td width="226" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items3.push("<b>" + item.ko_name + " " + item.bd_position + " / " + item.group_position + "</b><br>");
	
						var list3 = item.academic_list;
						
						if(list3 != undefined && list3 != "") {
							for(var j=0; j < list3.length; j++) {
								var item3 = list3[j];
								items3.push(item3.school_name + " " + item3.school_department + "<br>");
							}
						}
						
						var list4 = item.career_list;
						
						if(list4 != undefined && list4 != "") {
							for(var j=0; j < list4.length; j++) {
								var item4 = list4[j];
								items3.push(item4.job_name + " " + item4.position + "<br>");
							}
						}
						
						items3.push('			</td>\n');
						items3.push('		</tr>\n');
						items3.push('		</table>\n');
						items3.push('	</td>\n');
					}
					
					if((json.list3.length%2) != 0) {
						items3.push('	<td width="365" align="center" valign="top" >\n');
						items3.push('		<table width="360" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">\n');
						items3.push('		<tr>\n');
						items3.push('			<td width="120" align="center" bgcolor="#FFFFFF" style="padding:5px;">\n');
						items3.push('				<table width="110" border="0" cellspacing="0" cellpadding="0">\n');
						items3.push('				<tr>\n');
						items3.push('					<td>&nbsp;</td>\n');
						items3.push('				</tr>\n');
						items3.push('				</table>\n');
						items3.push('			</td>\n');
						items3.push('			<td width="226" bgcolor="#FFFFFF" style="padding:5px;">&nbsp;</td>\n');
						items3.push('		</tr>\n');
						items3.push('		</table>\n');
						items3.push('	</td>\n');
					}
					
					items3.push('</tr>\n');
					items3.push('</table>\n');
					
					$("#member_list1").html(items1.join(''));
					$("#member_list2").html(items2.join(''));
					$("#member_list3").html(items3.join(''));
				} else {
					alert(json.message); // error
				}	
			}
		);
		
		return false;
}

