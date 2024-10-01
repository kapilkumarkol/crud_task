@extends('master')
@section('title','task List')
@section('content')
<div class="container">
<div id="response"></div>
<form action="javascript:void(0)" id="taskForm">
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" name="title" >
      <div id="response" class="form-text"></div>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <input type="text" class="form-control" id="description" name="description">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">S.No</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
        <th>
            <input type="search" id="search" placeholder="Find Task using ID" >
            <input type="button" value="Search" onclick="getResponse()">
        </th>
      </tr>
    </thead>
    <tbody id="data">
        @if($tasks->count() <=0)
        No Data Found
        @else

        @foreach($tasks as $key => $task)
        <tr>
            <th scope="row">{{  ++$key }}</th>
            <td>{{ ucwords($task->title ?? '') }}</td>
            <td>{{ ucwords($task->description ?? '') }}</td>
            <td>{{ ucwords($task->completed == '0' ? 'Pending' : 'Completed') }}</td>
            <td>
                <button class="btn btn-secondary">Pending</button>
                <button class="btn btn-success">Completed</button>
                <button class="btn btn-info" onclick="editTask('{{ $task->id ?? 0 }}')">Edit</button>
                <button class="btn btn-danger"  onclick="deleteTask('{{ $task->id ?? 0 }}')">Delete</button>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
  </table>
</div>

<script>
    $(document).ready(function() {
        $('#taskForm').submit(function(e) {
            e.preventDefault();
            let formData = {
                title: $('#title').val(),
                description: $('#description').val(),
            };

            $.ajax({
                url: '/api/tasks',
                type: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify(formData),
                success: function(response) {
                    console.log(response);
                $('#data').empty();


                const tasks = Array.isArray(response) ? response : [response];

                if (tasks.length === 0) {

                    $('#data').append('<tr><td colspan="5" class="text-center">No Data Found</td></tr>');
                } else {

                    const newRows = tasks.map((task, index) => {
                        return `
                            <tr>
                                <th scope="row">${$('#data tr').length + 1 + index}</th>
                                <td>${task.title}</td>
                                <td>${task.description}</td>
                                <td>${task.completed == 0 ? 'Pending' : 'Completed'}</td>
                                <td>
                                    <button class="btn btn-secondary">Pending</button>
                                    <button class="btn btn-success">Completed</button>
                                    <button class="btn btn-info" onclick="editTask('${task.id}')">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteTask('${task.id}')">Delete</button>
                                </td>
                            </tr>
                        `;
                    }).join('');


                    $('#data').append(newRows);
                }


                $('#title').val('');
                $('#description').val('');
                },
                error: function(error) {
                    console.log(error);
                    $('#response').html('<p>An error occurred: ' + error.responseText + '</p>');
                }
            });
        });
    });

    function getResponse(){
        var value = document.getElementById('search').value;

        $.ajax({
            url: '/api/tasks/' + value,
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#data').empty();


                const tasks = Array.isArray(response) ? response : [response];

                if (tasks.length === 0) {

                    $('#data').append('<tr><td colspan="5" class="text-center">No Data Found</td></tr>');
                } else {

                    const newRows = tasks.map((task, index) => {
                        if ((typeof task === 'object' && Object.keys(response).length === 0) ) {
                            $('#data').append('<tr><td colspan="5" class="text-center">No Data Found</td></tr>');
                            return
                        }

                        return `
                            <tr>
                                <th scope="row">${$('#data tr').length + 1 + index}</th>
                                <td>${task.title}</td>
                                <td>${task.description}</td>
                                <td>${task.completed == 0 ? 'Pending' : 'Completed'}</td>
                                <td>
                                    <button class="btn btn-secondary">Pending</button>
                                    <button class="btn btn-success">Completed</button>
                                    <button class="btn btn-info" onclick="editTask('${task.id}')">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteTask('${task.id}')">Delete</button>
                                </td>
                            </tr>
                        `;
                    }).join('');


                    $('#data').append(newRows);
                }
                $('#title').val('');
                $('#description').val('');
                },
            error: function(error) {
                console.log(error);
                $('#response').html('<p>No Data Found</p>');
            }
        });
    }

    function editTask(taskId) {
        $.ajax({
            url: '/api/tasks/' + taskId,
            type: 'GET',
            success: function(response) {
                $('#title').val(response.title);
                $('#description').val(response.description);
            },
            error: function(error) {
                console.log(error);
                $('#response').html('<p>An error occurred: ' + error + '</p>');
            }
        });
    }

    function deleteTask(id){
        console.log(id);
        $.ajax({
            url: '/api/tasks/' + id,
            type: 'DELETE',
            success: function(response) {
                console.log(response);

                },
            error: function(error) {
                console.log(error);
                $('#response').html('<p>No Data Found</p>');
            }
        });
    }
</script>
@endsection
