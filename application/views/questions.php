<!DOCTYPE html>
<html>
<head>
    <title>Question Search</title>
</head>
<body>
    <h2>Home page</h2>
    <!-- <form action="<?php echo site_url('movies/search');?>" method="get">
        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre">
        <input type="submit" value="Search">
    </form>
    <br>
    <a href="<?php echo site_url('movies/allmovies');?>">View All Movies</a>   <br>
    <a href="<?php echo site_url('movies/index');?>">Back to Landing page</a> -->

    <?php foreach ($questions as $question): ?>
    <h2><a href="<?php echo base_url('questions/view/'.$question['id']); ?>"><?php echo $question['title']; ?></a></h2>
    <p><?php echo $question['content']; ?></p>
    <!-- Display other question details -->
    <?php endforeach; ?>

</body>
</html>