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

            @media screen and (max-width:800px) and (min-width: 600px)  {
                * { font-size: 1.3rem }
            }

            @media screen and (max-width:599px)  {
                * { font-size: 1.1rem }
            }
        </style>
    </head>
    <body>
        <h1>smolik.xyz CDN server</h1>
        <p>Available endpoints:</p>
        
        <?php
        # disable displaying endpoints that shall not be displayed (those should also be disabled via .htaccess)
        $invalid_endpoints = array("index.php", ".env", ".", "..", "api", "domains", "subdom", ".htaccess", ".log");

        # Lists the content of a directory and all subdirs in <ul> > <li> fashion
        function CreateTree($inv_endpoints, $dir, $curr_dirname) {
            if ($dir == "./s/")
                echo "<ul>";
            else
                echo "<ul class=\"sub-dir\">" . $curr_dirname;
   
            foreach (scandir($dir) as $file) {
                if (!in_array($file, $inv_endpoints)) {
                    $file_path = $dir . $file;

                    if (is_dir($file_path))
                        CreateTree($inv_endpoints, $file_path . "/", $file);
                        
                    else
                        echo "<li class=\"is-link\"> <a href=\"" . $dir . $file . "\">" . $file . "</a></li>";
                }
            }

            echo "</ul>";
        }

        CreateTree($invalid_endpoints, "./s/", "./s/");
        ?>
    </body>
</html>