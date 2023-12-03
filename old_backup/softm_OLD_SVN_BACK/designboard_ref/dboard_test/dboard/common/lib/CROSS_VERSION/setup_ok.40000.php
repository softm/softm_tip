<?
                        $postFile = @file("./post.dat");
            //          $cnt = 1;
                        simpleSQLExecute("ALTER TABLE {$tb_post} DISABLE KEYS;");
                        while ( $post = each($postFile) ) {
                //            $cnt++;
                //            if ( $cnt > 50) break;

                            $postData = explode ('^', $post[1]);
            //135-773^서울^강남구^개포4동^시영아파트^(1∼25동)^1
            //121-803^전라북도서울사무소^02-715-6366^234-2^서울 마포구
                            if ( $postData[6] == 1 ) {
                                $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '$postData[1]', '$postData[2]', '$postData[3]', '$postData[4]', '$postData[5]', '$postData[6]' );";
                            } else {
            // 556-855^초도출장소^061-690-2637^초도리 300^전남 여수시　
                                $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '', '$postData[4]', '$postData[1]', '$postData[2]', '$postData[3]', '2' );";
                            }
                // START TRANSACTION
                // commit;
                //          logs ( '$sql :  / ' . $sql . '<BR>' , true);
                            simpleSQLExecute($sql, $driver);
                        }
                        simpleSQLExecute("ALTER TABLE {$tb_post} ENABLE  KEYS;");

?>