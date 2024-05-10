<!DOCTYPE html>
<html>
<head>
    <title>Post Question</title>
</head>
<body>
    <h2>Post a Question</h2>
    <form action="<?php echo base_url('questions/post_question'); ?>" method="post">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="content" placeholder="Your question" required></textarea><br>
        <button type="submit">Post Question</button>
    </form>
</body>
</html>
