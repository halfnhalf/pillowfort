<title>PillowFort</title>
<body>
	<form id="submit" action="/submit/" method="post">
	   Title: <input type="text" name ="title">
        <br>
        Link: <input type="text" name="link"><input type="submit" name="submit" value="Submit">
        <br>
        Text: <textarea name="textarea" cols=50 rows=10></textarea><input type="submit" name="submit" value="Submit">
	</form>

 	<table id="posts-table">
    	<thead>
        	<tr>
        	   	<th class="posts-table" scope="col">Posts</th>
        	</tr>
     	</thead>
     	<?php /*new posts are generated here */ $H = new Html(); $H->outputContent($H->generate('posts'));?> 
	</table>
</body>