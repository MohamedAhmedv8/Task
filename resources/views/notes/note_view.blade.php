@extends('layout.app')
@section('title-content','Notes')
@section('body')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example1">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($notes as $note)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $note->title }}</td>
                                    <td>{{ $note->description }}</td>
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('note_edit',$note->id) }}" class="btn btn-primary">Edit</a>
                                        <a href="{{ route('note_delete',$note->id) }}" class="btn btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection