@extends('frontend.layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="form-group mt-5">
                <select class="form-control" id="sel1" name="sellist1">
                    <option>Posts</option>
                    <option>Notifications</option>
                </select>
            </div>
            <div class="col-md-2">
                <a  href="{{url('/download')}}" class="btn btn-primary mt-5 ">Export</a>
            </div>
        </div>
        <table class="table mt-5">
            <thead>
            <tr>
                <th scope="col">Export</th>
                <th scope="col">Process</th>
                <th scope="col">Download</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

@endsection
