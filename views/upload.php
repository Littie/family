<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info login-panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-3"><h4>Upload list</h4></div>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form" method="POST" action="/upload" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file">File input</label>
                            <input type="file" id="file" name="file">
                            <p class="help-block">File format: csv</p>
                        </div>
                        <button type="submit" name="upload" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
