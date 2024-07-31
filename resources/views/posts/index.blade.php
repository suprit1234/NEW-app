<!DOCTYPE html>
<html>
<head>
    <title>Laravel Yajra DataTables</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Posts</h1>

        <!-- Add Post Form -->
        <form id="add-post-form" method="POST" action="{{ route('posts.store') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Post</button>

        </form>

        <table id="posts-table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
        </table>
    </div>


</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

  <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('posts.data') }}',
                columns: [
                    { data: 'post_id', name: 'id' },
                    { data: 'post_title', name: 'title' },
                    { data: 'post_content', name: 'content' },
                    { data: 'post_created_at', name: 'created_at' },
                    { data: 'post_updated_at', name: 'updated_at' }
                ]
            });

            $('#add-post-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('posts.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#add-post-form')[0].reset();
                        table.ajax.reload();
                    },
                    error: function(response) { 
                        console.log('Error:', response);
                    }
                });
            });
        });
    </script>
</html>
