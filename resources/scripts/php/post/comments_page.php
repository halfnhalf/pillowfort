<?php
function generateComments($postId) {
    $comments = $_SERVER['DOCUMENT_ROOT'].'/database/comments/'.$postId[1].'.txt';
    $content = NULL;
    $handle = fopen($comments, 'r');
    while($line = fgets($handle)) {
        $commentElements = explode('::', $line); //0 = author, 1 = comment
        $content = $content.'<div class="well"><h4>'.$commentElements[0].'</h4><p>'.htmlspecialchars($commentElements[1]).'</p></div>';
    }
    return $content;
}
?>