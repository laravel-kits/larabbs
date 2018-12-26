<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{url('/')}}">
                LaraBBs
            </a>
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="{{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}">话题</a>
                </li>
                @foreach($categories as $category)
                    <li class="{{ active_class((if_route('categories.show') && if_route_param('category', $category->id))) }}">
                        <a href="{{ route('categories.show', $category->id) }}">{{$category->name}}</a>
                    </li>
                @endforeach
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{route('login')}}">登录</a></li>
                    <li><a href="{{route('register')}}">注册</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px;margin-top:-5px">
                            <img src="{{Auth::user()->avatar}}" width="30px" height="30px">
                            </span>
                            {{Auth::user()->name}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('users.show', Auth::id()) }}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    个人中心
                                </a>
                            </li>
                            <li>
                                <a href="{{route('users.edit',Auth::id())}}">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    编辑资料
                                </a>
                            </li>
                            <li>
                                <a href="{{route('logout')}}"
                                   onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit()">
                                    <span class="glyphicon glyphicon-log-out">
                                    退出登录
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>