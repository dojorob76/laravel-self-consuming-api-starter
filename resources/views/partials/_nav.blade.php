<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
      <div class="navbar-header">
          <a class="navbar-brand" href="{{$main_route}}">
              <span class="glyphicon glyphicon-home"></span>
          </a>
      </div>
      <ul class="nav navbar-nav">
          <li><a href="/intro">Intro</a></li>
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                 aria-expanded="false">Subdomains <span class="caret"></span></a>
              <ul class="dropdown-menu">
                  <li><a href="{{$mobile_route}}">Mobile</a></li>
                  <li><a href="{{$admin_route}}">Admin</a></li>
              </ul>
          </li>
      </ul>
      <div class="navbar-right" style="margin-right: 15px;">
          @if(Auth::check())
            <a class="btn btn-default navbar-btn" href="/logout">Log Out</a>
          @endif
      </div>
  </div>
</nav>