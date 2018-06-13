@extends('layouts.app')
@section('content')
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <style type="text/css">
        #messages{
            border: 1px solid black;
            height: 300px;
            margin-bottom: 8px;
            overflow: scroll;
            padding: 5px;
        }
    </style>
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat Message Module</div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-8" >
                                <div id="messages" ></div>
                            </div>
                            <div class="col-lg-8" >
                                <form action="{{route('sendmessage')}}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
                                    <textarea class="form-control msg"></textarea>
                                    <br/>
                                    <input type="button" value="Send" class="btn btn-success sendmsg">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            console.log('ccc');
            var socket = io.connect('http://larednod.iskytest.com:8890');

            socket.on('message', function (data) {
                data = jQuery.parseJSON(data);
                console.log(data.user);
                $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
            });

            $(".sendmsg").on('click', function(e){
                console.log('vvv');
                e.preventDefault();
                var token = $("input[name='_token']").val();
                var user = $("input[name='user']").val();
                var msg = $(".msg").val();
                if(msg != ''){
                    $.ajax({
                        type: "POST",
                        url: '/sendmessage',
                        dataType: "json",
                        data: {'_token':token,'message':msg,'user':user},
                        success:function(data){
                            console.log(data);
                            $(".msg").val('');
                        }
                    });
                }else{
                    alert("Please Add Message.");
                }
            })
        });
    </script>
@endsection