<?
function strlen_pixels($text) {
    /*
        Pixels utilized by each char (Verdana, 10px, non-bold)
        04: j
        05: I\il,-./:; <espace>
        06: J[]f()
        07: t
        08: _rz*
        09: ?csvxy
        10: Saeko0123456789$
        11: FKLPTXYZbdghnpqu
        12: AÇBCERV
        13: <=DGHNOQU^+
        14: w
        15: m
        16: @MW
    */

    // CREATING ARRAY $ps ('pixel size')
    // Note 1: each key of array $ps is the ascii code of the char.
    // Note 2: using $ps as GLOBAL can be a good idea, increase speed
    // keys:    ascii-code
    // values:  pixel size

    // $t: array of arrays, temporary
    $t[] = array_combine(array(106), array_fill(0, 1, 4));

    $t[] = array_combine(array(73,92,105,108,44), array_fill(0, 5, 5));
    $t[] = array_combine(array(45,46,47,58,59,32), array_fill(0, 6, 5));
    $t[] = array_combine(array(74,91,93,102,40,41), array_fill(0, 6, 6));
    $t[] = array_combine(array(116), array_fill(0, 1, 7));
    $t[] = array_combine(array(95,114,122,42), array_fill(0, 4, 8));
    $t[] = array_combine(array(63,99,115,118,120,121), array_fill(0, 6, 9));
    $t[] = array_combine(array(83,97,101,107), array_fill(0, 4, 10));
    $t[] = array_combine(array(111,48,49,50), array_fill(0, 4, 10));
    $t[] = array_combine(array(51,52,53,54,55,56,57,36), array_fill(0, 8, 10));
    $t[] = array_combine(array(70,75,76,80), array_fill(0, 4, 11));
    $t[] = array_combine(array(84,88,89,90,98), array_fill(0, 5, 11));
    $t[] = array_combine(array(100,103,104), array_fill(0, 3, 11));
    $t[] = array_combine(array(110,112,113,117), array_fill(0, 4, 11));
    $t[] = array_combine(array(65,195,135,66), array_fill(0, 4, 12));
    $t[] = array_combine(array(67,69,82,86), array_fill(0, 4, 12));
    $t[] = array_combine(array(78,79,81,85,94,43), array_fill(0, 6, 13));
    $t[] = array_combine(array(60,61,68,71,72), array_fill(0, 5, 13));
    $t[] = array_combine(array(119), array_fill(0, 1, 14));
    $t[] = array_combine(array(109), array_fill(0, 1, 15));
    $t[] = array_combine(array(64,77,87), array_fill(0, 3, 16));  
  
    // merge all temp arrays into $ps
    $ps = array();
    foreach($t as $sub) $ps = $ps + $sub;
  
    // USING ARRAY $ps
    $total = 1;
    for($i=0; $i<strlen($text); $i++) {
        $temp = $ps[ord($text[$i])];
        if (!$temp) $temp = 10.5; // default size for 10px
        $total += $temp;
    }
    return $total;
} 
echo strlen_pixels('OS_ELEXESS_P20_OV');
?>