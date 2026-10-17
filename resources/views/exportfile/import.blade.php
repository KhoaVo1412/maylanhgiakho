
<form action="/import" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="col-lg-12 py-3">
                                        <label for="users">Upload Users File</label>
                                        <input type="file" class="form-control" style="padding: 3px;" name="file" required />
                                        </div>
                                        <button type="submit" class="btn btn-success" name="upload">Upload</button>
                                </form>
