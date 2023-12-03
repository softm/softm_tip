			<div class="search_box">
				<div class="top">
					<form action="" class="search" name="topSForm" id="topSForm" method="POST">
						<label for="s_top_search" class="blind">검색어</label>
<?
$s_top_search = $_POST[s_top_search]?$_POST[s_top_search]:Session::getSession("s_top_search");
?>
						<input type="text" id="s_top_search" name="s_top_search" value="<?=$s_top_search?>">
						<a href="#" id="btn_top_search">검색</a>
					</form>
					<a href="qna.php" class="btn_qna" title="새창으로 열기">Q&amp;A</a>
				</div>
			</div>
