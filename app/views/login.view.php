<h1>this is login view page </h1>

<form action="" method="post">
    <input value="<?=old_value('email')?>" name="email" placeholder="Email"> <br>
    <div><?= $user->getError('email') ?></div>
    <input value="<?=old_value('password')?>" name="password" placeholder="password"> <br>
    <div><?= $user->getError('password') ?></div>
    <button>Login</button>
</form><?php
