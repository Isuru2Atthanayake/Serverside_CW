<!DOCTYPE html>
<html>
<head>
    <title>Movies Search</title>
</head>
<body>
    <h2>Search for ask</h2>
    <!-- <form action="<?php echo site_url('movies/search');?>" method="get">
        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre">
        <input type="submit" value="Search">
    </form> -->
    <form  action="<?php echo base_url('questions/ask'); ?>" method="post">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="content" placeholder="Your question" required></textarea><br>
    <button type="submit">Ask</button>
    </form>

    <br>
    <!-- <a href="<?php echo site_url('movies/allmovies');?>">View All Movies</a>   <br>
    <a href="<?php echo site_url('movies/index');?>">Back to Landing page</a> -->
</body>
</html>