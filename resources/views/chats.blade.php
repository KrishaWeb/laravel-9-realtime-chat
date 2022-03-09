<x-app-layout>
    <x-slot name="header">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row col-12">
                        <div class="col-8" style="width:800px; float:left;">
                            <div class="card card-default">
                                <div class="card-header" style="text-align:center; font-size: 20px;"><strong>Messages</strong></div>
                                <strong style="font-size: 20px; color:red;">{{strtoupper($receiver_user->name ?? '')}}</strong >
                                <div class="card-body p-0">
                                    <ul style="height: 300px; overflow-y:scroll;">
                                        <li class="p-2" id="chats">
                                           @if($messages)
                                                 @foreach($messages as $message)
                                                    @if($message->sender_id == Auth()->user()->id)
                                                        <strong>{{$message->user->name}} : </strong><label>{{ $message->message }}</label><br><br>
                                                    @else
                                                        <strong>{{$message->user->name}} : </strong><label>{{ $message->message }}</label><br><br>
                                                    @endif
                                                @endforeach
                                            @else
                                                Start Your Conversation!
                                           @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if(isset($receiver_id))
                                {{-- <form method="POST" action="{{route('user.send-messages', ['id'=>$receiver_id])}}"> --}}
                                    <input type="hidden" name="receiver_id" value="{{ $receiver_id }}" id="receiver_id">
                                    <input type="text" name="message" class="form-control" placeholder="Enter your message…" id="message">
                                    <a class="btn btn-link" type="submit" style="background-color: silver;" id="send_message">Send Message</a>
                                {{-- </form> --}}
                            @endif
                            {{-- <span>user is typing</span> --}}
                        </div>
                        <div class="col-4" style="margin-left: 10px; float:left;">
                            <div class="card card-default">
                                <div class="card-header" style="text-align:center; font-size: 20px;"><strong>Your Contats</strong></div>
                                <div class="card-body p-0">
                                    <ul>
                                        @foreach($users as $user)
                                            <a href="{{ route('user.get-messages', ['id' => $user->id])}}"><li class="ml-4 mt-2">{{ucwords($user->name)}}</li></a>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="/js/app.js"></script>
    <script type="text/javascript">
        var receiver_id = document.getElementById('receiver_id').value;
        var sender_id = {{Auth::user()->id}};
        var sender_name = '{{Auth::user()->name}}';
        Echo.channel('channel_'+receiver_id+'_'+sender_id)
            .listen('WebsocketDemoEvent', (e) => {
                var message = JSON.parse(JSON.stringify(e));
                document.getElementById("chats").innerHTML += "<strong>"+message.sender_name+" : </strong><label>"+message.data+"</label><br><br>";
            });

        $( "#send_message" ).click(function() {
            var message = document.getElementById('message').value;
            document.getElementById('message').value = " ";
            $.post("{{route('user.send-messages', ['id'=>$receiver_id ?? ''])}}",{
                '_token': '{{csrf_token()}}',
                'receiver_id':receiver_id,
                'message':message,
            },function(data){
                    $("#chats").append("<strong>"+sender_name+" : </strong><label>"+message+"</label><br><br>");
            }).catch(function(error){
                console.log(error);
            });
        });
        
    </script>
</x-app-layout>
