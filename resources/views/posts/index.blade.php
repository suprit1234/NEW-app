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
            <a href="{{ route('dashboard') }}" style="">
                Go back
            </a>
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
                    <th>Actions</th>
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
                    { data: 'post_updated_at', name: 'updated_at' },
                    { data: 'actions', name: 'actions', oderable:false, searchable: false}
                ],
                columnDefs: [
                    {
                        targets: -1,
                        render: function(data, type, row) {
                            return `
                                <a href="{{ url('posts') }}/${row.post_id}/edit" class="btn btn-info btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${row.post_id}">Delete</button>
                            `;
                        }
                    }
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

            // Handle delete button click
            $('#posts-table').on('click', '.delete-btn', function() {
                var postId = $(this).data('id');
                if (confirm('Are you sure you want to delete this post?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ url('posts') }}/' + postId,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            table.ajax.reload();
                        },
                        error: function(response) {
                            console.log('Error:', response);
                        }
                    });
                }
            });
        });
        
    </script>
</html>
