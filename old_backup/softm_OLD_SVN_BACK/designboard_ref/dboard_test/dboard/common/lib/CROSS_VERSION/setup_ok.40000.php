<?
                        $postFile = @file("./post.dat");
            //          $cnt = 1;
                        simpleSQLExecute("ALTER TABLE {$tb_post} DISABLE KEYS;");
                        while ( $post = each($postFile) ) {
                //            $cnt++;
                //            if ( $cnt > 50) break;

                            $postData = explode ('^', $post[1]);
            //135-773^����^������^����4��^�ÿ�����Ʈ^(1��25��)^1
            //121-803^����ϵ�����繫��^02-715-6366^234-2^���� ������
                            if ( $postData[6] == 1 ) {
                                $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '$postData[1]', '$postData[2]', '$postData[3]', '$postData[4]', '$postData[5]', '$postData[6]' );";
                            } else {
            // 556-855^�ʵ������^061-690-2637^�ʵ��� 300^���� �����á�
                                $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '', '$postData[4]', '$postData[1]', '$postData[2]', '$postData[3]', '2' );";
                            }
                // START TRANSACTION
                // commit;
                //          logs ( '$sql :  / ' . $sql . '<BR>' , true);
                            simpleSQLExecute($sql, $driver);
                        }
                        simpleSQLExecute("ALTER TABLE {$tb_post} ENABLE  KEYS;");

?>