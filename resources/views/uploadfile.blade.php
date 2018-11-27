<h1>Загрузите файл для обработки</h1>
<form method="POST" enctype="multipart/form-data"
      action="{{ route('uploadFile') }}">
    <div>
        @csrf
        <div class="input-group row">
            <label for="fileName">Загрузить файл: </label>
            <label class="btn btn-default btn-file">
                <input type="file" name="fileName">
            </label>
        </div>
        <div>
            <label for="field" class="col-sm-2 col-form-label">Название поля: </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="field">
            </div>
        </div>
        <br>
        <div class="input-group row">
            <label for="count" class="col-sm-2 col-form-label">Колличесвто строк: </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="count">
            </div>
        </div>
        <br>
        <div class="input-group row">
            <label for="count" class="col-sm-2 col-form-label">Очередь: </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="queue">
            </div>
        </div>
        <br>
            <button class="btn btn-success">Загрузить</button>
        </div>
</form>