
<!-- assume header and logo is already included by the main class-->
<body>
<?php $H = new Html(); $H->outputContent($H->generate('posts_page', $_GET['id']/*get the dictionary key of the post*/)); //Dynamic data is inserted here?>
</body>