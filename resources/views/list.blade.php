<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">


            <div class="content">

                @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
                <form method="POST" action="{{url('/addList')}}">
	                {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Добавление задачи</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="text">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выберите список</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="select">
                            @foreach ($items as $value )
                                <option>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
                <div class="links">
                    <a href="{{ url('/addGroup') }}">Нету списка задач? Добавьте</a>
                </div>
                <h1>Ваши списки задач:</h1>
                @foreach ($items as $value)

                    <h3><a href="{{url('/view/'.$value)}}">
                        <span class="badge badge-secondary">
                         {{$value}}

                                <a href="{{url('/del/'.$value) }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <a href="{{ url('/edit/'.$value) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                        </span></a>
                    </h3>

                @endforeach


                <?/*
                <!--Вывод задач -->
                <h1>Ваши задачи:</h1>
                @foreach ($items as $key => $value)
                    <h3>
                        <span class="badge badge-secondary">
                            {{$key}}

                                <a href="{{url('/del/'.$key) }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <a href="{{ url('/edit/'.$key) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ url('/sort/'.$key) }}">
                                    <i class="fas fa-sort"></i>
                                </a>
                        </span>
                    </h3>
                    <ul class="list-group">
                        @foreach($value as $k=>$v)
                        <li class="list-group-item">
                            {{$v}}
                            <span class="badge "><a href="{{ url('/del/'.$key.'/'.$k) }}"><i class="fas fa-trash-alt"></i></a></span>
                        </li>
                        @endforeach

                        @if (is_object($items[$key]) )
                        <div class="flex-center">
                            {{ $items[$key]->links() }}
                        </div>
                        @endif
                    </ul>
                @endforeach
                */?>

               <?
               /* @if (session()->has('ToDoList'))
                    @foreach (session('ToDoList') as $key => $value )
                        <h3>
                            <span class="badge badge-secondary">
                                {{$key}}

                                    <a href="{{url('/del/'.$key) }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <a href="{{ url('/edit/'.$key) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ url('/sort/'.$key) }}">
                                        <i class="fas fa-sort"></i>
                                    </a>
                            </span>
                        </h3>
                        <ul class="list-group">
                            @foreach($value as $k=>$v)
                            <li class="list-group-item">
                                {{$v}}
                                <span class="badge "><a href="{{ url('/del/'.$key.'/'.$k) }}"><i class="fas fa-trash-alt"></i></a></span>
                            </li>
                            @endforeach

                        </ul>

                    @endforeach
                @endif
                */?>


        </div>
    </body>
</html>
