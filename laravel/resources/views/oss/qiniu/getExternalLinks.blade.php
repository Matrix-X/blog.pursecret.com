@extends('header')
@section('content')

<div class="container">
    <form name="getExternalLinks" action="" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="bucketList"> bucket list: </label>
            <select class="form-control" id="bucketList">
            @foreach( $bucketList as $bucket)
                @if(!is_null($bucket[0]))
                    <option>{!! $bucket[0] !!}</option>
                @endif
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="prefix"> Prefix:</label>
            <input name="prefix" value="{{ $prefix }}"/>
        </div>
        <div class="form-group">

        </div>

        <button type="submit" class="btn btn-primary">查询</button>

        <br/><br/>
        <label for="">总共：{{ count($imagesList) }}</label>
        <br/>
        <div class="form-group">

            <textarea cols="100" rows="20">{!! $strImageList !!}</textarea>
        </div>
    </form>




</div>

@endsection
