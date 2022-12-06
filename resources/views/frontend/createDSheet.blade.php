@extends('frontend.layouts.main')
@section('main-container')



    <div class="container pt-5">


    </div>
    <div class="main">


        <h4>{{$title}}</h4>

        <hr>
        <br>
        <form action="{{$url}}" method="post">
            @csrf

            <div class="form-row pr-5">
                <div class="form-group col-4 pr-5">
                    <label for="inputArea">Select Area <span class="required">*</span></label>
                    <select id="inputArea" onchange="showForDriver22(this)" name="area" class="form-control"
                            required>

                        @foreach($area as $ar)
                        <option value={{$ar->area_id}}
                        >{{$ar->areaName}}</option>

                        @endforeach
                    </select>

                </div>
            </div>
                    <div class="form-row pt-5">

                        <div>
                            <a href="{{url('/frontend/dsheet')}}">
                                <button id="cancel" type="button" style="width: 8em; margin-right: 2em;" class="btn btn-danger">Cancel
                                </button>
                            </a>
                        </div>
                        <div>

                            <button type="submit" style="width: 8em; margin-right: 2em;  background-color: rgb(0, 74, 111);"
                                    class="btn btn-primary">Generate
                            </button>
                        </div>

                    </div>

        </form>
    </div>

@endsection



