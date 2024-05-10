<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do Listg</title>
  
    <link rel="stylesheet" href="<?php echo $bootstrap_css; ?>">
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="<?php echo site_url('todo/add_action'); ?>" method="post">
            <div class="form-group">
                <label for="action_title">Action Title:</label>
                <input type="text" class="form-control" id="action_title" name="action_title">
            </div>
            <button type="submit" class="btn btn-primary">Add Action</button>
        </form>
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');  ?>">
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="<?php echo site_url('todo/add_action'); ?>" method="post">
            <div class="form-group">
                <label for="action_title">Action Title:</label>
                <input type="text" class="form-control" id="action_title" name="action_title">
            </div>
            <button type="submit" class="btn btn-primary">Add Action</button>
        </form>
        <br>
        <h2>Existing Actions:</h2>
        <?php if (!empty($todo_actions)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Action Title</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todo_actions as $action): ?>
                        <tr>
                            <td><?php echo $action->id; ?></td>
                            <td><?php echo $action->user_id; ?></td>
                            <td><?php echo $action->action_title; ?></td>
                            <td><?php echo $action->date_added; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No actions found.</p>
        <?php endif; ?>
    </div>
</body>
</html>


