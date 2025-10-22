<h1>this is home view page </h1>

<form action="" method="post">
    <input value="<?=old_value('email')?>" name="email"> <br>
    <div><?= $user->getError('email') ?></div>
    <input value="<?=old_value('username')?>" name="username"> <br>
    <div><?= $user->getError('username') ?></div>
    <input value="<?=old_value('password')?>" name="password"> <br>
    <div><?= $user->getError('password') ?></div>
    <button>signup</button>
</form>