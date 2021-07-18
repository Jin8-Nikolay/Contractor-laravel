@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создайте сокращенную ссылку.</h1>

        <div class="card">
            <div class="card-header">
                <form id="ajaxForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="link" class="form-control" placeholder="URl">
                        <div class="input-group-append">
                            <button id="send" class="btn btn-success" type="submit">Сократить ссылку</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div style="display: none; opacity: 0" class="alert alert-success">
                    <p id="alertSuccess"></p>
                </div>
                <div style="display: none; opacity: 0" class="alert alert-danger">
                    <p id="alertError"></p>
                </div>
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Сокращенная ссылка</th>
                        <th>Ссылка</th>
                        <th>Переходов</th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    @foreach($shortLinks as $link)
                        <tr>
                            <td>{{ $link->id }}</td>
                            <td>
                                <a href="{{ route('short.link', $link->code) }}" target="_blank">
                                    {{ route('short.link', $link->code) }}
                                </a>
                            </td>
                            <td>{{ $link->link }}</td>
                            <td>{{ $link->count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function animAlert(context){
            context.css({
                'display': 'block',
            });
            context.animate({
                opacity: 1,
            }, 500, function () {
                setTimeout(function (){
                    context.animate({
                        opacity: 0,
                    }, 500, function () {
                        context.css({
                            'display': 'none',
                        })
                    })
                }, 2000);
            });
        }
        let error = $('.alert-danger');
        let success = $('.alert-success');
        $("#send").click(function (event) {
            event.preventDefault();
            let link = $("input[name=link]").val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            console.log(link);
            $.ajax({
                type: "POST",
                url: "{{ route('generate.short.link.post') }}",
                data: {
                    link: link,
                    _token: _token,
                },
                success: function (response) {
                    $("#tbody").prepend(
                        "<tr>" +
                        "<td>" + response.recording.id + "</td>" +
                        "<td> <a href='http://contractor/"+response.recording.code+"' target='_blank' >http://contractor/" + response.recording.code + "</a></td>" +
                        "<td>" + response.recording.link + "</td>" +
                        "<td>" + response.recording.count + "</td>" +
                        "</tr>"
                    );
                    $('#alertSuccess').text(response.success);
                    animAlert(success);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    json = JSON.parse(xhr.responseText);
                    $('#alertError').text(json.errors.link);
                    animAlert(error);
                }
            });
        });
    </script>
@endsection

