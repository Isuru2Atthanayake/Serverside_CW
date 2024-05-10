<!DOCTYPE html>
<html>
<head>
    <title>Question Search</title>
</head>
<body>
    <!-- <h2>Search for Movies 1</h2>
    <form action="<?php echo site_url('movies/search');?>" method="get">
        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre">
        <input type="submit" value="Search">
    </form>
    <br> -->

    <h2><?php echo $question['title']; ?></h2>
<p><?php echo $question['content']; ?></p>
<!-- Display other question details -->

<h3>Answers:</h3>
<?php foreach ($answers as $answer): ?>
    <p><?php echo $answer['content']; ?></p>
    <!-- Display other answer details -->
<?php endforeach; ?>

<h3>Post your answer:</h3>
<form method="post" action="<?php echo base_url('questions/answer/'.$question['id']); ?>">
    <textarea name="content" placeholder="Your answer" required></textarea><br>
    <button type="submit">Answer</button>
</form>
    <!-- <a href="<?php echo site_url('movies/allmovies');?>">View All Movies</a>   <br>
    <a href="<?php echo site_url('movies/index');?>">Back to Landing page</a> -->
</body>
</html>