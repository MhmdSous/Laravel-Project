@extends('admin.admin_master')
@section('admin')
    <div class="py-12">
        <div class="container">

            <div class="row">  <h4>Home Slider</h4>
                <a href=""> <button class="btn btn-info">Add Slider</button> </a>
                <br><br>l

                <div class="col-md-8">

                    <div class="card">


                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        <div class="card-header"> All Sliders </div>


                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SL </th>
                            <th scope="col">Slider Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- @php($i = 1) -->
                        @foreach ($sliders as $slider)
                            <tr>
                                <th scope="row"> {{ $sliders->firstItem() + $loop->index }} </th>
                                <td> {{ $slider->title }} </td>
                                <td> {{ $slider->description }} </td>
                                <td> <img src="{{ asset($slider->image) }}" style="height:40px; width:50px"> </td>
                                <td>
                                    <a href="{{ url('slider/edit/' . $slider->id) }}"
                                        class="btn btn-sm btn-info">Edit</a>
                                    <a href="{{ url('softdelete/slider/' . $slider->id) }}"
                                        onclick="return confirm('Are u sure?')"
                                        class="btn btn-sm btn-danger">Delete</a>
                                </td>


                            </tr>
                        @endforeach


                    </tbody>
                        </table>
                        {{-- {{ $sliders->links() }} --}}
                    </div>
                </div>

                </div>



            </div>

        </div>
    @endsection
