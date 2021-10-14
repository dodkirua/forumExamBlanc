
<div id="main">
    <div id="title"></div>
    <div id="body">
        <?php
        $i = 1;
        /* @var array $var parameter of controller*/
        foreach ($var['subject'] as $sub){
            $subject = $sub->getAllData();
            echo "<div class='subject$i'>";
            echo "<a href='/index.php?ctrl=subject&sub=" . $subject['id'] . "' title='" . $subject['description'] . "'>" . $subject['name']. "</a>";
            if ($subject['archived']) {
                echo "Sujet archivé";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>
