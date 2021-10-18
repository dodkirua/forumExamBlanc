 <?php

 use Dodkirua\Forum\Model\Entity\Topic;
?>
<div id="main">

        <?php

        $i = 1;
        /* @var array $var parameter of controller*/
        foreach ($var['subject'] as $sub){
            $subject = $sub->getAllData();
            echo "<div id='subject$i' class='subject'>";
            echo "<div class='subjectTitle'>
                    <a href='/index.php?ctrl=category&sub=" . $subject['id'] . "' title='" . $subject['description'] . "'>" . $subject['name']. "</a>";
            if ($subject['archived']) {
                echo "<span>Sujet archivé</span>";
            }

            echo "</div>
                    <div class = 'topicParent'>";
            foreach ($var['topic'][$i-1] as $topic ){
                /* @var Topic $topic  */
                echo "
                <div class='topic'>
                    <a href='/index.php?ctrl=topic&val=" . $topic->getId() . "' title = '" . $topic->getDescription() . "'>" . $topic->getName() . "</a>
                </div>
                ";
            }
             $i++;
            echo "</div>";
            echo "</div>";
        }
        ?>

</div>

