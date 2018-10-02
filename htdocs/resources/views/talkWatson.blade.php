@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="message_to_watson" placeholder="何か入れて下さい" class="form-control"/>
        </div>
        <div class="col-md-2">
            <input type="button" id="send_message" value="聞いてみる" class="btn btn-primary"/>        
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>ユーザー入力</label>
            <ul id="input"></ul>
        </div>
        <div class="col-md-6">
            <label>Watsonからの返答</label>
            <ul id="responseFromWatson"></ul>
        </div>    
    </div>
</div>
@endsection

@section('script')
<script>
    $("#send_message").click(function(){
        $('#input').append('<li>'+$("#message_to_watson").val()+'</li>')
        $('#responseFromWatson').append('<li>'+'Watson is thinking...'+'</li>')
        $.ajax({
            type: "POST",
            url:  "{{route('talk_to_watson')}}",
            data: {spokenword:$("#message_to_watson").val()},
            dataType: 'json'
        }).done(function(response){
            for (var i = 0, len = response.output.text.length; i < len; i++) {
                if(response.output.text[i] !== ''){ 
                    $('#responseFromWatson li:last-child').text(response.output.text[i]);
                }
            }
        }).fail(function(){
            alert(errorHandler(arguments));
        });
    });
</script>
@endsection