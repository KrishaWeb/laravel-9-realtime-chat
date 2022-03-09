<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/chat.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            @foreach($users as $user)
                                 <li class="clearfix">
                                    <div class="about">
                                        <div class="name"><a href="{{ route('user.get-messages', ['id' => $user->id])}}">{{ucwords($user->name)}}</a></div>
                                    </div>
                                </li>
                            @endforeach       
                        </ul>
                    </div>
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{ucwords($receiver_user->name ?? '')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0">
                                @if($messages)
                                     @foreach($messages as $message)
                                        @if($message->sender_id == Auth()->user()->id)
                                            <li class="clearfix">
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">{{$message->created_at}}</span>
                                                </div>
                                                <div class="message other-message float-right">{{ $message->message }}</div>
                                            </li>
                                        @else
                                            <li class="clearfix">
                                                <div class="message-data">
                                                    <span class="message-data-time">{{ $message->created_at }}</span>
                                                </div>
                                                <div class="message my-message">{{ $message->message }}</div>                                    
                                            </li>  
                                        @endif
                                    @endforeach
                                @else
                                    Start Your Conversation!
                               @endif
                            </ul>
                        </div>
                        @if(isset($receiver_id))
                            <div class="chat-message clearfix">
                                <div class="input-group mb-0">
                                    <input type="hidden" name="receiver_id" value="{{ $receiver_id ?? '' }}" id="receiver_id">
                                    <input type="text" name="message" class="form-control" placeholder="Enter your message…" id="message">
                                    <a class="btn btn-link" type="submit" style="background-color: silver;" id="send_message">Send Message</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
