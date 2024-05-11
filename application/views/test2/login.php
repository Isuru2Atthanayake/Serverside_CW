<h1>Register</h1>
<?php echo form_open('auth/register'); ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Register</button>
<?php echo form_close(); ?>