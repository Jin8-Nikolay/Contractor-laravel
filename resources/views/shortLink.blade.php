@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создайте сокращенную ссылку.</h1>

        <div class="card">
            <div class="card-header">
                <form id="ajaxForm" action="{{ route('generate.short.link.post') }}">
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
@endsection

