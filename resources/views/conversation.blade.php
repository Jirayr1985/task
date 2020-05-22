@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header ">Conversation with {{ $peer->name }}</div>
                    <div class="conversation">
                        @if($conversation)
                            @foreach($conversation->messages as $message)
                                <div class="card-body"
                                     style="border: solid 1px black">
                                    {{ $message->text }}
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <input class="message" placeholder="message" type="text" style="width:100%; padding: 10px">
            </div>

            <div class="col-md-1">
                <button style="padding: 10px 20px;" class="btn btn-success send">Send</button>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>

        $(document).ready(function () {
            $('.send').click(function () {

                $.ajax({
                    url: "/api/users/{{ $peer->id }}/message",
                    type: "POST",
                    data: {
                        'text': $('.message').val(),
                        'author_id': {{ $owner->id }}
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })

            })
        });

    </script>
@endsection
