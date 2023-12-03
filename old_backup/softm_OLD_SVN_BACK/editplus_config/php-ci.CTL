#TITLE=php-ci
#INFO
New Cliptext library
#SORT=n

#T=$this->session->userdata('userID')
$this->session->userdata('userID')
#T=<script>
<script>

VideoPoster();

function VideoPoster() {
    var VideoWrap = $('.VideoWrap');

    VideoWrap.each(function() {
        var VideoL = $(this)
            , Poster = VideoL.find('.Poster')
            , Play = VideoL.find('.Play')
            , Video = VideoL.find('video')
            , Larger = VideoL.find('.Larger');

        Play.hammer().on({
            tap : function() {
                Poster.hide();
                Video.show();
                Larger.show();
                Video[0].play();

            }
        });

        Larger.hammer().on({

            tap : function(){
                if ( VideoL.hasClass("Full") ) {
                    VideoL.removeClass("Full");
                } else {
                    VideoL.addClass("Full");
                }
                
            }
        });
        
        Video.on({
        });

    });

    
}
</script>
#T=<style half
<style>
.VideoArea { position:relative; padding-top:0 !important; margin-top:30px !important;}
.VideoArea.Width1 { width:800px; height:450px;}
.VideoArea.Size2 { width:440px !important; height:258px !important;}
.VideoArea.Size3 { width:440px !important; height:288px !important;}
.VideoArea.Size4 { width:355px !important; height:239px !important;}
.VideoArea .Poster { position:absolute; left:0; top:0; width:100%; height:100%;}
.VideoArea .Poster .Play { position:absolute; left:50%; top:50%; margin-left:-61px; margin-top:-61px;}
.VideoArea .Larger { display:none; position:absolute; right:18px; bottom:7px; padding:2px; background-color:#000;}

.VideoArea.Full { position:fixed; top:0px; left:0; margin:0 !important; width:1280px; height:800px;}
.VideoArea.Full > video { width:1280px; height:800px;}
.VideoArea.Full > .Larger { right:258px;}
</style>
#T=<style>
<style>
.VideoArea { position:relative; padding-top:0 !important; margin-top:30px !important;}
.VideoArea.Width1 { width:800px; height:450px;}
.VideoArea.Size2 { width:440px; height:258px;}
.VideoArea.Size3 { width:440px; height:288px;}
.VideoArea.Size4 { width:355px; height:239px;}
.VideoArea .Poster { position:absolute; left:0; top:0; width:100%; height:100%;}
.VideoArea .Poster .Play { position:absolute; left:50%; top:50%; margin-left:-61px; margin-top:-61px;}
.VideoArea .Larger { display:none; position:absolute; right:18px; bottom:7px; padding:2px; background-color:#000;}

.VideoArea.Full { position:fixed; top:0px; left:0; margin:0 !important; width:1280px; height:800px;}
.VideoArea.Full > video { width:1280px; height:800px;}
.VideoArea.Full > .Larger { right:258px;}
</style>
<script>

VideoPoster();

function VideoPoster() {
	var VideoWrap = $('.VideoWrap');

	VideoWrap.each(function() {
		var VideoL = $(this)
			, Poster = VideoL.find('.Poster')
			, Play = VideoL.find('.Play')
			, Video = VideoL.find('video')
			, Larger = VideoL.find('.Larger');

		Play.hammer().on({
			tap : function() {
				Poster.hide();
				Video.show();
				Larger.show();
				Video[0].play();

			}
		});

		Larger.hammer().on({

			tap : function(){
				if ( VideoL.hasClass("Full") ) {
					VideoL.removeClass("Full");
				} else {
					VideoL.addClass("Full");
				}
				
			}
		});
		
		Video.on({
		});

	});

	
}
</script>
#T=<div class="VideoArea Width1 VideoWrap">
			<div class="VideoArea Width1 VideoWrap">
				<div class="Poster">
					<button type="button" class="Play"><img src="../images/btn/btn_video_play.png" alt="" /></button>
					<img src="../data/act1/video1_poster.jpg" alt="" />
				</div>
				<video id="Video1" controls preload="none" width="800" height="450">
					<source src="../data/act1/video-001.mp4" type='video/mp4' />				
				</video>	
				<button type="button" class="Larger"><img src="../images/btn/btn_video_larger.png" alt="" /></button>
			</div>
#T=<div class="VideoArea VideoWrap Type2 Size2">
                        <div class="VideoArea VideoWrap Type2 Size2">
                            <div class="Poster">
                                <button type="button" class="Play"><img src="../images/btn/btn_video_play.png" alt="" /></button>
                                <img src="../data/act1/video4b_poster.jpg" alt="" />
                            </div>
                            <video controls preload="none" width="440" height="258" style="display:none">
                                <source src="../data/act1/video-004b.mp4" type='video/mp4' />             
                            </video>    
                            <button type="button" class="Larger"><img src="../images/btn/btn_video_larger.png" alt="" /></button>
                        </div>
#T=VideoPoster() {
<script>

VideoPoster();

function VideoPoster() {
	var VideoWrap = $('.VideoWrap');

	VideoWrap.each(function() {
		var VideoL = $(this)
			, Poster = VideoL.find('.Poster')
			, Play = VideoL.find('.Play')
			, Video = VideoL.find('video')
			, Larger = VideoL.find('.Larger');

		Play.hammer().on({
			tap : function() {
				Poster.hide();
				Video.show();
				Larger.show();
				Video[0].play();

			}
		});

		Larger.hammer().on({

			tap : function(){
				if ( VideoL.hasClass("Full") ) {
					VideoL.removeClass("Full");
				} else {
					VideoL.addClass("Full");
				}
				
			}
		});
		
		Video.on({
		});

	});

	
}
</script>
#T=$query->row()->cnt;
	function appListCount()
	{
		$this->db->select("COUNT(*) AS cnt");
// 		$this->db->from("info_app");
// 		$this->db->where("field", $value);
		$query = $this->db->get('info_app');
// 		print_r( $query->result(0));
// 		echo '$query->result() : ' . $query->result()->MyCount;
		return  $query->row()->cnt;
	}
#