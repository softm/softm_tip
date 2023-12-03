    function dplayer_item() {
        this.id         = ''; // 게시판 번호
        this.no         = ''; // 재생 파일 번호
        this.url        = ''; // 경로
        this.title      = ''; // 제목
        this.artist     = 'unknown'; // 음악가
        this.lyricsUrl  = 'dp_lyrics_sample'; // 가사 경로
        this.albumNo    = ''; // 앨범   번호
        this.album      = ''; // 앨범
        this.composer   = ''; // 작곡가
        this.genre      = ''; // 장르
        this.length     = ''; // 길이
        this.fSize      = ''; // 크기
        this.kind       = ''; // 종류
        this.makeDate   = ''; // 만든 날짜
        this.bitPerSec  = ''; // 비트 전송률
        this.playCnt    = ''; // 재생횟수
        this.fileName   = ''; // 파일 이름
        this.protect    = ''; // 보호
        this.license    = ''; // 저작권

        this.setId        = setId       ; // 게시판 번호
        this.setNo        = setNo       ; // 재생 파일 번호
        this.setUrl       = setUrl      ; // 경로
        this.setTitle     = setTitle    ; // 제목
        this.setArtist    = setArtist   ; // 음악가
        this.setLyricsUrl = setLyricsUrl; // 가사 경로
        this.setAlbumNo   = setAlbumNo  ; // 앨범 번호
        this.setAlbum     = setAlbum    ; // 앨범
        this.setComposer  = setComposer ; // 작곡가
        this.setGenre     = setGenre    ; // 장르
        this.setLength    = setLength   ; // 길이
        this.setFsize     = setFsize    ; // 크기
        this.setKind      = setKind     ; // 종류
        this.setMakeDate  = setMakeDate ; // 만든 날짜
        this.setBitPerSec = setBitPerSec; // 비트 전송률
        this.setPlayCnt   = setPlayCnt  ; // 재생횟수
        this.setFileName  = setFileName ; // 파일 이름
        this.setProtect   = setProtect  ; // 보호
        this.setLicense   = setLicense  ; // 저작권

        this.getId        = getId       ; // 게시판 번호
        this.getNo        = getNo       ; // 재생 파일 번호
        this.getUrl       = getUrl      ; // 경로
        this.getTitle     = getTitle    ; // 제목
        this.getArtist    = getArtist   ; // 음악가
        this.getLyricsUrl = getLyricsUrl; // 가사 경로
        this.getAlbumNo   = getAlbumNo  ; // 앨범 번호
        this.getAlbum     = getAlbum    ; // 앨범
        this.getComposer  = getComposer ; // 작곡가
        this.getGenre     = getGenre    ; // 장르
        this.getLength    = getLength   ; // 길이
        this.getFsize     = getFsize    ; // 크기
        this.getKind      = getKind     ; // 종류
        this.getMakeDate  = getMakeDate ; // 만든 날짜
        this.getBitPerSec = getBitPerSec; // 비트 전송률
        this.getPlayCnt   = getPlayCnt  ; // 재생횟수
        this.getFileName  = getFileName ; // 파일 이름
        this.getProtect   = getProtect  ; // 보호
        this.getLicense   = getLicense  ; // 저작권
    }

    function setId       (id      ) { this.id         = id       ; }
    function setNo       (no      ) { this.no         = no       ; }
    function setAlbumNo  (albumNo ) { this.albumNo    = albumNo  ; }
    function setUrl      (url      ) { this.url       = url      ; }
    function setTitle    (title    ) { this.title     = title    ; }
    function setArtist   (artist   ) { this.artist    = artist   ; }
    function setLyricsUrl(lyricsUrl) { this.lyricsUrl = lyricsUrl; }
    function setAlbum    (album    ) { this.album     = album    ; }
    function setComposer (composer ) { this.composer  = composer ; }
    function setGenre    (genre    ) { this.genre     = genre    ; }
    function setLength   (length   ) { this.length    = length   ; }
    function setFsize    (size     ) { this.fSize     = fSize    ; }
    function setKind     (kind     ) { this.kind      = kind     ; }
    function setMakeDate (makeDate ) { this.makeDate  = makeDate ; }
    function setBitPerSec(bitPerSec) { this.bitPerSec = bitPerSec; }
    function setPlayCnt  (playCnt  ) { this.playCnt   = playCnt  ; }
    function setFileName (fileName ) { this.fileName  = fileName ; }
    function setProtect  (protect  ) { this.protect   = protect  ; }
    function setLicense  (license  ) { this.license   = license  ; }

    function getId       () { return this.id       ; }
    function getNo       () { return this.no       ; }
    function getUrl      () { return this.url      ; }
    function getTitle    () { return this.title    ; }
    function getArtist   () { return this.artist   ; }
    function getLyricsUrl() { return this.lyricsUrl; }
    function getAlbumNo  () { return this.albumNo  ; }
    function getAlbum    () { return this.album    ; }
    function getComposer () { return this.composer ; }
    function getGenre    () { return this.genre    ; }
    function getLength   () { return this.length   ; }
    function getFsize    () { return this.fSize    ; }
    function getKind     () { return this.kind     ; }
    function getMakeDate () { return this.makeDate ; }
    function getBitPerSec() { return this.bitPerSec; }
    function getPlayCnt  () { return this.playCnt  ; }
    function getFileName () { return this.fileName ; }
    function getProtect  () { return this.protect  ; }
    function getLicense  () { return this.license  ; }
