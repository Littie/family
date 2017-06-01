<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info login-panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-3"><h4>Distribute tasks</h4></div>
                        <div class="col-sm-9"><a href="/logout" class="pull-right">
                                <button class="btn btn-primary">Logout</button>
                            </a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Distribute</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tasks as $row){ ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td>
                                <select name="users" id="user">
                                    <option>Select user ...</option>
                                    <?php foreach ($users as $user) { ?>
                                    <option value="<?= $user['id']?>"><?= $user['name']?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

