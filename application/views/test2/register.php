<h1>Login</h1>
<?php echo form_open('auth/login'); ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
<?php echo form_close(); ?>