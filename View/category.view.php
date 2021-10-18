<?php
use Dodkirua\Forum\Model\Entity\Topic;
?>
<div id="main">
    <div class = 'topicParent'>
        <?php
        /* @var array $var argument of render's controller*/



        foreach ($var['topic'] as $topic ) {
            var_dump($topic);
            /* @var Topic $topic */
            echo "
        <div class='topic'>
            <a href='/index.php?ctrl=topic&val=" . $topic->getId() . "' title = '" . $topic->getDescription() . "'>" . $topic->getName() . "</a>
            ";

        echo "</div>
        ";
        }
        ?>
    </div>
</div>