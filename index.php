<?php
/*
http://localhost/sites/bissresearchapi/sitemeta/read.php
http://localhost/sites/bissresearchapi/sitemeta/read_one.php?urlID=345
http://localhost/sites/bissresearchapi/sitemeta/read_paging.php?page=1
http://localhost/sites/bissresearchapi/sitemeta/search.php?s=xrp
*/
$response = file_get_contents('http://localhost/sites/bissresearchapi/sitemeta/read_one.php?urlID=366');
if ( ! is_array ( $response ) ){
    echo $response;
} else
    {
        foreach ($response as $arr) {
            foreach ($arr as $res) {
                if ( isset( $res->urlID ) ){
                    echo $res->urlID . '<br>';
                    echo $res->urlTitle . '<br>';
                    echo $res->urlLink . '<br>';
                    echo $res->urlDescription . '<br>';
                    echo $res->urlSource . '<br>';
                    echo $res->urlDate . '<br>';
                }
            }
        }
    }
?>