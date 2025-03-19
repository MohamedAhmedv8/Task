@extends('layout.app')
@section('title-content','Update Note')
@section('body')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('note_update') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label">Title *</label>
                                        <input type="hidden" class="form-control" name="id" value="{{ $note->id }}">
                                        <input type="text" class="form-control" name="title" value="{{ $note->title }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Description *</label>
                                        <textarea name="description" class="form-control h_100" cols="30" rows="10" >{{ $note->description }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label"></label>
                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection