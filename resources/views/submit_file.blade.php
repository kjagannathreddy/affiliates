@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Show affiliates 
                </div>

                <div class="card-body">
                    @isset($data)
                        @if(!empty($data))
                        <div class="container mt-5">
                            <table class="table table-bordered mb-5">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">Affiliate ID</th>
                                        <th scope="col">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ $value['affiliate_id'] }}</td>
                                        <th scope="row">{{ $value['name'] }}</th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
