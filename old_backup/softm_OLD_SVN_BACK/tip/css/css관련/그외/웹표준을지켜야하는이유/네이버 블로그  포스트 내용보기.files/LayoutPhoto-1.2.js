
/**
 * �� ��ũ �Լ�
 * 
*/
function uploadChange(url)
{
	if(editor.thumbnailList.imageCount > 0)
	{
		if (confirm('���� �߰��� �������� ����� �� �����ϴ�.\n\n��� �����Ͻðڽ��ϱ�?'))
		{
		    location.href = url;
		}
	}
	else
	{
		location.href = url;
	}
}


var layout_type_selected = ""; // ���� ���̾ƿ����� Ÿ��.
var max_layout_free_type_count = 6; // ������ ����Ÿ�� ��ü����

/**
 * ���̾ƿ� ���ε� ó��.
 * 
 */
function uploadProc()
{
	if (editor.thumbnailList.imageCount == 0)
	{
		alert("������ ÷�� ���ּ���!");
		return;
	}

	if(layout_type_selected == "")
	{
		alert("Ÿ���� ���� �ؾ� �մϴ�.");
		return;	
	}
	
	var need_image_count;
	var sort_thunmbnail_type;
	var free_size_info;
	var select_layout_type = 0;
	var temp_col_size = 0;
	var temp_row_size = 0;
	if(layout_type_selected == "free")
	{
		select_layout_type = getFreeLayoutSubTypeCheck();
		need_image_count = getFreeLayoutTypeNeedCountInfo(select_layout_type);
		free_size_info = getFreeLayoutTypeSizeInfo(need_image_count, select_layout_type);
	}
	else if(layout_type_selected == "sort")
	{
		temp_col_size = document.getElementById("col_size").value; // alert(temp_col_size.value);
		temp_row_size = document.getElementById("row_size").value; // alert(temp_row_size.value);
		need_image_count = getSortLayoutPhotoMaxImageCount(temp_col_size, temp_row_size);
		sort_thunmbnail_type = CheckSortThunbnailSize(temp_col_size);
	}

	if(editor.thumbnailList.imageCount < need_image_count)
	{
		alert("���� Ÿ���� �ּ� "+need_image_count+"������ ���ε� �ؾ� �մϴ�.");
		return;	
	}
	
	var onimgcount = need_image_count;
	var uidx = 0;
	var ImageLinkInfo = new Array(onimgcount);
	
	var j = 0;
	var temp_image_url = "";
	for(i = 0; i < onimgcount; i++) // �̹��� ������ū for �� ���� �ȴ�.
	{
		var temp_img = document.getElementById("srcImg" + i);
		
		temp_image_url = temp_img.src; //alert( temp_image_url );
		temp_image_url = temp_image_url.replace(thumbnail_url, attach_url); //alert( temp_image_url2 );
		temp_image_url = temp_image_url.replace("?type=s1", ""); //alert( temp_image_url2 );
				
		ImageLinkInfo[i] = temp_image_url;
//		alert(ImageLinkInfo[i]);
	}

//	var result_html = LayoutPhotoMakeHTML(layout_type_selected, select_layout_type, temp_col_size.value, temp_row_size.value, ImageLinkInfo);
//	opener.SetValueMosaicImg(result_html);
	opener.setLayoutPhoto2Editor(layout_type_selected, select_layout_type, temp_col_size, temp_row_size, ImageLinkInfo.join('|'));
	
	self.close();
}

/**
 * ���� ���̾ƿ����� html ����.
 * 
 * layout_type : ���̾ƿ� Ÿ�� ����
 * free_layout_num : ������ ����Ÿ�� ����
 * sort_col_size : ������ ������ ����
 * sort_row_size : ������ �ٰ��� ����
 * imagelink : �̹��� ��ũ ���� �迭
 */
//function LayoutPhotoMakeHTML(layout_type, free_layout_num, sort_col_size, sort_row_size, imagelink)
//{
//	var result_html = "";
//	var div_id = parseInt((Math.random()*10000000)) + "_div";
//
//	if(layout_type == "free")
//	{
//		var temp_object = document.getElementById("free_layout" + free_layout_num);
//		if(temp_object)
//			result_html = temp_object.innerHTML;
//	}
//	else	if(layout_type == "sort")
//		result_html = document.getElementById("sort_layout").innerHTML;
//	
//	result_html = "<span id='" + div_id + "'>\r\n<table border='0' align='center' valign='middle' cellspacing=0 style='padding : 0 0 0 0'>\r\n" + result_html.replaceAll('div_id', "onClick='photo.doPhotoClick(this, \"" + div_id + "\")'") + "\r\n</table>\r\n</span>";
//	return result_html;
//}

/**
 * ��� ���̾ƿ� ���� �̹��� ���̾� �ʱ�ȭ.
 * 
 * max_layout_item_count : �ִ� �̹��� ����.
 */
function imageTypeLayerItemAllClear(max_layout_item_count)
{
	for(var i = 1; i <= max_layout_item_count; i++)
	{
		var temp_div1;
		for(var j = 1; j <= max_layout_free_type_count; j++)
		{
			temp_div1 = document.getElementById("free_layout" + j + "_item" + i);
			if(temp_div1 != null) temp_div1.innerHTML = "";
		}
		var temp_div2 = document.getElementById("sort_layout_item" + i);
		if(temp_div2 != null) temp_div2.innerHTML = "";
	}
}

/**
 * ��� ���̾� ����ó��.
 * 
 */
function imageTypeLayerAllHidden()
{
	var temp_div1;
	for(var i = 1; i <= max_layout_free_type_count; i++)
	{
		temp_div1 = document.getElementById("free_layout" + i);
		if(temp_div1 != null) temp_div1.style.display = "none";
		
		document.getElementById("lay" + i).src = image_url + "img_lay0" + i + ".gif";
	}
	var temp_div2 = document.getElementById("sort_layout");
	if(temp_div2 != null) temp_div2.style.display = "none";
}

/**
 * �̸����� ȭ�� - ���� ���̾� ���� ���
 * 
 * ty1 : ���� ���̾ƿ��� ���� Ÿ�� ��ȣ
 * ty2 : ���� ���η��̾ƿ� Ÿ��
 */
function imageTypeLayerChange(subtype)
{
	var temp_div;
	if(layout_type_selected == "free")
	{
		for(var i = 1; i <= max_layout_free_type_count; i++)
		{
			temp_div = document.getElementById(layout_type_selected + "_layout" + i);
			if(temp_div != null && subtype == i) temp_div.style.display = "";
			else if(temp_div != null) temp_div.style.display = "none";
		}
	}
}

/* ���̾ƿ����� ������ �̹��� �ִ� ���ε� ���� ���� ��ȯ
 * 
 * mosaicType1 : ������ ����
 * mosaicType2 : �ٰ��� ����
 * */
function getSortLayoutPhotoMaxImageCount(mosaicType1, mosaicType2)
{
	var max_upload_count_info;
	max_upload_count_info = parseInt(mosaicType1) * parseInt(mosaicType2);
	return max_upload_count_info;
}

/**
 * ������ ����Ÿ�� �ʿ� ���� ���� ����
 * 
 */
function getFreeLayoutTypeNeedCountInfo(select_layout_type)
{
	var need_imagecount;
	if(select_layout_type==1)
	{
		need_imagecount = 3;
	}
	else 	if(select_layout_type==2)
	{
		need_imagecount = 3;
	}
	else 	if(select_layout_type==3)
	{
		need_imagecount = 5;
	}
	else 	if(select_layout_type==4)
	{
		need_imagecount = 7;
	}
	else 	if(select_layout_type==5)
	{
		need_imagecount = 6;
	}
	else 	if(select_layout_type==6)
	{
		need_imagecount = 7;
	}
	return need_imagecount;
}

/**
 * ������ ����Ÿ�� ����� ����
 * 
 */
function getFreeLayoutTypeSizeInfo(need_imagecount, select_layout_type)
{
	var max_info;
	if(select_layout_type==1)
	{
		max_info = new Array(need_imagecount);
		max_info[0] = "3:362";
		max_info[1] = "2:179";
		max_info[2] = "2:179";
	}
	else 	if(select_layout_type==2)
	{
		nedd_imagecount = 3;
		max_info = new Array(need_imagecount);
		max_info[0] = "2:179";
		max_info[1] = "3:362";
		max_info[2] = "2:179";
	}
	else 	if(select_layout_type==3)
	{
		max_info = new Array(need_imagecount);
		max_info[0] = "2:133";
		max_info[1] = "3:271";
		max_info[2] = "2:133";
		max_info[3] = "2:133";
		max_info[4] = "2:133";
	}
	else 	if(select_layout_type==4)
	{
		max_info = new Array(need_imagecount);
		max_info[0] = "2:106";
		max_info[1] = "3:326";
		max_info[2] = "2:106";
		max_info[3] = "2:106";
		max_info[4] = "2:106";
		max_info[5] = "2:106";
		max_info[6] = "2:106";
	}
	else 	if(select_layout_type==5)
	{
		max_info = new Array(need_imagecount);
		max_info[0] = "3:271";
		max_info[1] = "3:271";
		max_info[2] = "2:135"; 
		max_info[3] = "2:135";
		max_info[4] = "2:135";
		max_info[5] = "2:135";
		max_info[6] = "2:135";
	}
	else 	if(select_layout_type==6)
	{
		max_info = new Array(need_imagecount);
		max_info[0] = "3:269";
		max_info[1] = "3:269";
		max_info[2] = "2:108";
		max_info[3] = "2:108";
		max_info[4] = "2:108";
		max_info[5] = "2:108";
		max_info[6] = "2:108";
	}
	return max_info;
}


/**
 * ������ ����Ÿ�� üũ.
 * 
 */
function getFreeLayoutSubTypeCheck()
{
	var select_layout_type = "";
	var lay_type = document.getElementsByName("laytype");
	for(var count = 0; count < lay_type.length; count++)
	{
		if(lay_type[count].checked)
		{
			select_layout_type = lay_type[count].value;
			break;
		}
	}
	return select_layout_type;
}

/**
 * �̸����� ȭ�� �ʱ�ȭ
 * 
 * ty1 : free �ϰ��, ���� ���η��̾ƿ� Ÿ��  |  sort �ϰ��, col_size
 * ty2 : ���� ���̾ƿ��� ���� Ÿ�� ��ȣ
 * ty3 : sort �ϰ��, row_size
 */
function imageEditViewInit()
{
	if(layout_type_selected == null || layout_type_selected == "") return;

	var imagecount = 0;
	var select_layout_type;
	var col_size;
	var row_size;
	var max_info;
	
	/* ������ */
	if(layout_type_selected == "free")
	{
		select_layout_type = getFreeLayoutSubTypeCheck();
		need_imagecount = getFreeLayoutTypeNeedCountInfo(select_layout_type)
		max_info = getFreeLayoutTypeSizeInfo(need_imagecount, select_layout_type);
	}
	/* ������ */
	else	if(layout_type_selected == "sort")
	{
		col_size = document.getElementById("col_size").value;
		row_size = document.getElementById("row_size").value;

		max_info = CheckSortThunbnailSize(col_size);
		need_imagecount = parseInt(col_size) * parseInt(row_size);
	}
	
	imageTypeLayerItemAllClear(20);
	
	for(var i = 0; i < need_imagecount; i++)
	{
		if(document.getElementById("srcImg" + i) != null)
		{
			var temp_image_url = "";
			var temp_image_url1 = "";
			var temp_image_url2 = "";
			var temp_object;
			var temp_thunmbnail_type;
			var temp_size;
			var imgid = parseInt((Math.random()*10000000));

			if(layout_type_selected == "free")
			{
				temp_object = document.getElementById( layout_type_selected + "_layout" + select_layout_type + "_item" + (i+1));
				var temp_split = max_info[i].split(":");
				temp_thunmbnail_type = temp_split[0];
				temp_size = temp_split[1];
			}
			else if(layout_type_selected == "sort")
			{
				temp_object = document.getElementById( layout_type_selected + "_layout_item" + (i+1));				
				temp_thunmbnail_type = max_info[0];
				temp_size = max_info[1];
			}
			
			if(temp_object != null)
			{
				temp_image_url = document.getElementById("srcImg" + i).src; //alert( temp_image_url );
//				temp_image_url = temp_image_url.replace(attach_url, ""); //alert( temp_image_url );
				temp_image_url1 = temp_image_url.replace("?type=s1", "?type=s" + temp_thunmbnail_type); //alert( temp_image_url1 );
				
				temp_image_url2 = temp_image_url.replace(thumbnail_url, attach_url); //alert( temp_image_url2 );
				temp_image_url2 = temp_image_url2.replace("?type=s1", ""); //alert( temp_image_url2 );
				
//				temp_object.innerHTML = "<img src='" + thumbnail_url + temp_image_url + "?type=s" + temp_thunmbnail_type + "' width='" + temp_size + "' height='" + temp_size + "' id='userImg" + imgid + "' style='cursor: pointer' rel='" + document.getElementById("srcImg" + i).src + "' div_id>";
				temp_object.innerHTML = "<img src='" + temp_image_url1 + "' width='" + temp_size + "' height='" + temp_size + "' id='userImg" + imgid + "' style='cursor: pointer' rel='" + temp_image_url2 + "' div_id>";
//				alert(temp_object.innerHTML);
			}
		}
	}

}

/**
 * ���̾ƿ� Ÿ�� ����.
 * 
 */
function imageChange(imgid)
{
	if(imgid == 0)
		layout_type_selected = "sort";
	else
		layout_type_selected = "free";

	document.getElementById("imageViewLayer").style.background = "";
	imageTypeLayerAllHidden();
	imageTypeLayerChange(imgid);
	
	for(var i = 1; i <= max_layout_free_type_count; i++)
	{
		if(i == imgid)
		{
			document.getElementById("lay" + i).src = image_url + "img_lay0" + i + "_on.gif";
			document.getElementsByName("laytype")[i].checked = true;
		}
		else
			document.getElementById("lay" + i).src = image_url + "img_lay0" + i + ".gif";
	}
	
	imageEditViewInit();
}


/**
 * ���̺� ��ü tr ����
 * 
 * tbody : ���̺� ��ü
 */
function clearTableRow(tbody)
{
	while(tbody.hasChildNodes())
		tbody.removeChild(tbody.firstChild);
}

/**
 * �������� ���� ����ϻ�����
 * 
 */
function CheckSortThunbnailSize(col_size)
{
	var returnSize = new Array(2);
	if(col_size == 2)
	{
		returnSize[0] = "3";
		returnSize[1] = "271";
	}
	else if(col_size == 3)
	{
		returnSize[0] = "2";
		returnSize[1] = "179";
	}
	else if(col_size == 4)
	{
		returnSize[0] = "2";
		returnSize[1] = "133";
	}
	else if(col_size == 5)
	{
		returnSize[0] = "2";
		returnSize[1] = "106";
	}

	return returnSize;
}

/**
 * ������ �̸����� ���̺� ����.
 * 
 * main_div_id : ���� ���� div id
 * col_size : ������
 * row_size : �ٰ���
 */
function sortTypeSelect(main_div_id, col_size, row_size)
{
	if(document.getElementById(main_div_id) != null)
	{
		document.getElementById("imageViewLayer").style.background = "";
		document.getElementById(main_div_id).style.display = "";
		var tbody = document.getElementById(main_div_id).getElementsByTagName("TBODY")[0];
		clearTableRow(tbody);
		var thumbnailSize = CheckSortThunbnailSize(col_size);
		var spanId = 1;
		for(var rowCount = 0; rowCount < row_size; rowCount++)
		{
			var temp_row = document.createElement("<TR>");
			var temp_col;
			var temp_span;
			for(var colCount = 0; colCount < col_size; colCount++)
			{
				temp_col = document.createElement("<TD>");
				temp_col.className = "i" + spanId + " y" + col_size;
				temp_col.width = thumbnailSize[1]; //alert(temp_col.width);
				temp_col.height = thumbnailSize[1]; //alert(temp_col.height);
				temp_span = document.createElement("<SPAN>");
				temp_span.id = "sort_layout_item" + (spanId);

				temp_col.appendChild(temp_span);
				temp_row.appendChild(temp_col);
				spanId++;
			}
			tbody.appendChild(temp_row);
		}
//		alert( tbody.innerHTML );
	}
}

/**
 * �����ÿ� ���� �ټ� ����.
 * 
 * col_size_object : ������ ��ü��
 * row_size_object : ������ ��ü��
 */
function sortRowSizeCheck(col_size_object, row_size_object)
{
	var temp_col = document.getElementById(col_size_object);
	if(temp_col)
	{
		var temp_row = document.getElementById(row_size_object); //alert(temp_row.value);		
		if(temp_row)
		{
			var selectedIndex = temp_row.selectedIndex;
			while(temp_row.hasChildNodes()) temp_row.removeChild(temp_row.firstChild);
			
			var temp_option;
			for(var count = 0; count <= 5; count++)
			{				
				temp_option = document.createElement("<option>");
				
				if(count > 0)
				{
					if(count == 5 && temp_col.value == 5) break;
					
					temp_option.text = count + "��"; //alert(temp_option.text);
					temp_option.value = count; //alert(temp_option.value);
				}
				else
				{
					temp_option.text = "����";
					temp_option.value = "";
				}
				temp_row.options.add( temp_option );
			}
			temp_row.selectedIndex = selectedIndex;
		}
	}
}

/**
 * ������ �̸�����.
 * 
 * col_size_object : ������ ��ü��
 * row_size_object : ������ ��ü��
 */
function sortTypePreview(col_size_object, row_size_object)
{
	var temp_col = document.getElementById(col_size_object); //alert(temp_col.value);
	var temp_row = document.getElementById(row_size_object); //alert(temp_row.value);
	if(temp_row.value > 0 && temp_col.value > 0)
	{
		document.getElementsByName("laytype")[0].checked = true;
		layout_type_selected = "sort";
		sortTypeSelect("sort_layout", temp_col.value, temp_row.value);
		imageEditViewInit();
	}
	else
	{
		layout_type_selected = "";
	}
}


/**
 * ���ε� ���� ���� ����.
 * 
 */
function deleteUploadFileFromLocal(real_filename)
{
//	alert("real_filename = " + real_filename);
	if(real_filename != null && real_filename.length > 0)
	{
		var fileName = real_filename.replaceAll(thumbnail_url, "");
		fileName = fileName.replaceAll("?type=s1", "");
//		alert("fileName = " + fileName);
		if(fileName != null && fileName.length > 0)
		{
			var checkIndex = false;
			
			if(opener.document.getElementById("filelist"))
			{
				for(var i = 0; i < opener.document.getElementById("filelist").options.length; i++)
				{
					var temp_filename = opener.document.getElementById("filelist").options[i].value.split("@");			
//					alert("temp_filename[0] = " + temp_filename[0]);
//					alert("encodeURIComponent(temp_filename[0]) = " + encodeURIComponent(temp_filename[0]));
					if(temp_filename[0] != "" && temp_filename[0] == fileName)
					{
						if(i > 0)
						{
							opener.document.getElementById("filelist").options.selectedIndex = i;
//							alert(opener.document.getElementById("filelist").options.selectedIndex);
							checkIndex = true;
							break;
						}
					}
				}
				
				if(checkIndex) opener.DelFileList(blogID,'','');
			}
		}
	}
}
