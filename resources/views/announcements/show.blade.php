@extends('layout.layout')

@section('head')
@endsection

@section('content')
    <!-- Show -->
    {{-- <div id="show" class="card">
        <div class="flex justify-between align-items-center px-12 py-6">
            <h3 class="fw-bold pt-4">
                Announcement Details
            </h3>
            <a href="javascript:void(0);" onclick="hide()" class="btn"><i class=" fa fa-xmark"
                    style="font-size: 23px;"></i></a>
        </div>

        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline mt-3">
                            <input name="title" type="text" class="form-control" id="showtitle" readonly
                                placeholder="Title of your Announcement" style="border: none;">
                            <label for="showtitle">Title</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline mb-4">
                            <input id="showdescription" name="description" class="form-control"
                                placeholder="Details of your Announcement" readonly style="border: none;">
                            <label for="showdescription">Details</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <x-layout>
        <div class="card h-100">
            <div class="card-header mt-4 ml-4 uppercase">
                <h2>
                    {{ $data->title }}
                </h2>
            </div>
            <div class="card-body" style="padding: 0 75px;">
                <div class="row mt-4 border rounded-xl h-75">
                    <div class="col-xs-12 col-sm-12 col-md-12 my-3 ml-2">
                        <p>
                            <strong>
                                Details
                            </strong>
                        </p>


                        <div class="ml-8">
                            <p>
                                {{ $data->description }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-layout>
@endsection
