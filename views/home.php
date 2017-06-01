<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info login-panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-3"><h4>Home page</h4></div>
                        <?php if (in_array('distribute', $permissions)) { ?>
                        <div class="col-sm-4"><a href="/distribute" class="pull-right"><button class="btn btn-primary">Distribute</button></a></div>
                        <?php } elseif (in_array('import', $permissions)) { ?>
                        <div class="col-sm-4"><a href="/upload" class="pull-right"><button class="btn btn-primary">Upload</button></a></div>
                        <?php } ?>
                        <div class="col-sm-5"><a href="/logout" class="pull-right"><button class="btn btn-primary">Logout</button></a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>User</th>
                            <th>Completed</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $row){ ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $user['name'] ?></td>
                                <td>
                                    <input type="checkbox" name="completed" value="<?= $row['is_complete'] ?>" <?php if ($row['is_complete']) {?> checked <?php } ?>>
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

