@extends('templates.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <?php // TODO: Finish form ?>
            <input type="text" name="student_id" placeholder="Student ID"><br />
            {{ csrf_field() }}
            <input type="submit" value="submit">
        </div>
    </div>
@stop
