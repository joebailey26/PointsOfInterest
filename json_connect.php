<?php

    if (ctype_alnum(trim(str_replace(' ','',$_GET["search"])))) {
        $a = urlencode($_GET["search"]);
        $result = file_get_contents("https://edward2.solent.ac.uk/~assign217/slim/search/$a");
        $result_decode = json_decode($result, true);
        if ($result_decode) {
            foreach ($result_decode as $poi) {
                echo "<a href='poi.php?name=".$poi["name"]."'><article class='poi card wide'>
                        <h2 class='title'>".$poi["name"]."</h2>
                        <p class='type'>".$poi["type"]."</p>
                        <p class='description'>".$poi["description"]."</p>
                    </article></a>";
            };
        }
        else {
            echo "<p class='wide'>No results found.</p>";
        }
    }
    else {
        echo "<p class='wide'>We only allow letters, numbers, and spaces. Please try again.</p>";
    };

?>