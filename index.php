<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>smolik.xyz CDN</title>
        <style>
            * {
                font-family: "Segoe UI";
                font-size: 1.5rem;
                background: #222;
                color: #ddd;
                text-decoration: none;
                text-align: center;
            }
            a {
                color: #ab5;
            }
            body {
                margin: 2em;
            }
            ul,
            li,
            p {
                text-align: left;
            }

            li {
                padding-left: 1em;
                list-style-type: none;
            }

            ul.sub-dir:before {
                content: '📁';
            }
        </style>        
    </head>
    <body>
        <h1>smolik.xyz CDN server</h1>
        <p>Available endpoints:</p>
        
        <?php

        //echo is_dir("./a/b");
        $invalid_endpoints = array("index.php", ".", "..", "api", "domains", "subdom", ".htaccess", "log", ".log", "upload");

        function CreateTree($inv_endpoints, $dir, $curr_dirname) {
            if ($dir == "./")
                echo "<ul>";
            else
                echo "<ul class=\"sub-dir\">" . $curr_dirname;
   
            foreach (scandir($dir) as $file) {
                if (!in_array($file, $inv_endpoints)) {
                    $file_path = $dir . $file;

                    if (is_dir($file_path)) {
                        $dir_path = $file_path . "/";
                        CreateTree($inv_endpoints, $dir_path, $file);
                    }
                    else
                        echo "<li class=\"is-link\"> <a href=\"" . $dir . "/" . $file . "\">" . $file . "</a></li>";
                }
            }
                
            echo "</ul>";
        }

        CreateTree($invalid_endpoints, "./", './');
        ?>
    </body>
</html>