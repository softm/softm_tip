    function dplayer_item() {
        this.id         = ''; // �Խ��� ��ȣ
        this.no         = ''; // ��� ���� ��ȣ
        this.url        = ''; // ���
        this.title      = ''; // ����
        this.artist     = 'unknown'; // ���ǰ�
        this.lyricsUrl  = 'dp_lyrics_sample'; // ���� ���
        this.albumNo    = ''; // �ٹ�   ��ȣ
        this.album      = ''; // �ٹ�
        this.composer   = ''; // �۰
        this.genre      = ''; // �帣
        this.length     = ''; // ����
        this.fSize      = ''; // ũ��
        this.kind       = ''; // ����
        this.makeDate   = ''; // ���� ��¥
        this.bitPerSec  = ''; // ��Ʈ ���۷�
        this.playCnt    = ''; // ���Ƚ��
        this.fileName   = ''; // ���� �̸�
        this.protect    = ''; // ��ȣ
        this.license    = ''; // ���۱�

        this.setId        = setId       ; // �Խ��� ��ȣ
        this.setNo        = setNo       ; // ��� ���� ��ȣ
        this.setUrl       = setUrl      ; // ���
        this.setTitle     = setTitle    ; // ����
        this.setArtist    = setArtist   ; // ���ǰ�
        this.setLyricsUrl = setLyricsUrl; // ���� ���
        this.setAlbumNo   = setAlbumNo  ; // �ٹ� ��ȣ
        this.setAlbum     = setAlbum    ; // �ٹ�
        this.setComposer  = setComposer ; // �۰
        this.setGenre     = setGenre    ; // �帣
        this.setLength    = setLength   ; // ����
        this.setFsize     = setFsize    ; // ũ��
        this.setKind      = setKind     ; // ����
        this.setMakeDate  = setMakeDate ; // ���� ��¥
        this.setBitPerSec = setBitPerSec; // ��Ʈ ���۷�
        this.setPlayCnt   = setPlayCnt  ; // ���Ƚ��
        this.setFileName  = setFileName ; // ���� �̸�
        this.setProtect   = setProtect  ; // ��ȣ
        this.setLicense   = setLicense  ; // ���۱�

        this.getId        = getId       ; // �Խ��� ��ȣ
        this.getNo        = getNo       ; // ��� ���� ��ȣ
        this.getUrl       = getUrl      ; // ���
        this.getTitle     = getTitle    ; // ����
        this.getArtist    = getArtist   ; // ���ǰ�
        this.getLyricsUrl = getLyricsUrl; // ���� ���
        this.getAlbumNo   = getAlbumNo  ; // �ٹ� ��ȣ
        this.getAlbum     = getAlbum    ; // �ٹ�
        this.getComposer  = getComposer ; // �۰
        this.getGenre     = getGenre    ; // �帣
        this.getLength    = getLength   ; // ����
        this.getFsize     = getFsize    ; // ũ��
        this.getKind      = getKind     ; // ����
        this.getMakeDate  = getMakeDate ; // ���� ��¥
        this.getBitPerSec = getBitPerSec; // ��Ʈ ���۷�
        this.getPlayCnt   = getPlayCnt  ; // ���Ƚ��
        this.getFileName  = getFileName ; // ���� �̸�
        this.getProtect   = getProtect  ; // ��ȣ
        this.getLicense   = getLicense  ; // ���۱�
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
