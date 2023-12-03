<?
if( defined("_dboard_search_included") ) return;
	define ("_dboard_search_included", true);
// $search_pattern = "/$search/i";
// $title   = preg_replace($search_pattern, "<font color=FF001E style=background-color:FFF000;>$search</font>", $title  );
// $content = preg_replace($search_pattern, "<font color=FF001E style=background-color:FFF000;>$search</font>", $content);
function searchWord() {
	global $search, $search_condition, $search,$search_start_tag, $search,$search_end_tag, $title, $content, $name, $cat_name, $search_cat_no;
	if ( $search ) {
		if ( !$$search_condition || $$search_condition == 'title' ) {
			$title   = str_replace($search,$search_start_tag.$search.$search_end_tag, $title);
		}
		if ( !$$search_condition || $$search_condition == 'content' ) {
			$content = str_replace($search,$search_start_tag.$search.$search_end_tag, $content);
		}
		if ( !$$search_condition || $$search_condition == 'name' ) {
			$name	= str_replace($search,$search_start_tag.$search.$search_end_tag, $name);
		}
	}

	if ( $search_cat_no ) {
		$cat_name = $search_start_tag.$cat_name.$search_end_tag;
	}
}
?>