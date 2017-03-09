# Sux Admin
Free and easy to use admin theme.

## Components
* jQuery
* Bootstrap
* iScroll
* metisMenu
* Font-Awesome

[Demo](https://rawgit.com/fesuydev/sux-admin/master/index.html)

### Starter Template
``` html
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1, user-scalable=yes">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sux Admin</title>
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="css/sux-admin.min.css">
</head>

<body>
  <!-- .navbar-top -->
  <nav class="navbar navbar-top" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inline-collapse">
          <span class="fa fa-chevron-down"></span>
        </button>
        <a class="navbar-brand" href="#">Sux Admin</a>
      </div>
      <ul class="nav navbar-toolbar">
        <li><a href="#" data-toggle="sidebar-collapse"><span class="fa fa-chevron-left"></span></a></li>
        <li>
          <a href="#" class="search-toggle" data-toggle="collapse" data-target=".form-search-collapse"><span class="fa fa-search"></span></a>
          <form class="collapse form-search-collapse" method="GET">
            <div class="form-group">
              <input type="text" class="form-control" name="search">
            </div>
           </form>
        </li>
      </ul>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-inline-collapse">
        <div class="navbar-scroller">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown dropdown-nav">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-info-circle badge-ico"><span class="badge"></span></span> Notification <b class="caret"></b></a>
              <ul class="dropdown-menu dropdown-media">
                <li class="dropdown-body">
                  <ul>
                    <li>
                      <a href="#">
                        <div class="media">
                          <div class="pull-left">
                            <span class="fa fa-envelope media-icon"></span>
                          </div>
                          <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                            <p>Lorem ipsum Occaecat laboris exercitation voluptate est reprehenderit laboris consectetur pariatur labore eu sunt exercitation commodo veniam quis Excepteur mollit in incididunt ex.</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="media">
                          <div class="pull-left">
                            <span class="fa fa-envelope media-icon"></span>
                          </div>
                          <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                            <p>Lorem ipsum Occaecat laboris exercitation voluptate est reprehenderit laboris consectetur pariatur labore eu sunt exercitation commodo veniam quis Excepteur mollit in incididunt ex.</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="media">
                          <div class="pull-left">
                            <span class="fa fa-envelope media-icon"></span>
                          </div>
                          <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                            <p>Lorem ipsum Occaecat laboris exercitation voluptate est reprehenderit laboris consectetur pariatur labore eu sunt exercitation commodo veniam quis Excepteur mollit in incididunt ex.</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="media">
                          <div class="pull-left">
                            <span class="fa fa-envelope media-icon"></span>
                          </div>
                          <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                            <p>Lorem ipsum Occaecat laboris exercitation voluptate est reprehenderit laboris consectetur pariatur labore eu sunt exercitation commodo veniam quis Excepteur mollit in incididunt ex.</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="media">
                          <div class="pull-left">
                            <span class="fa fa-paper-plane media-icon"></span>
                          </div>
                          <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                            <p>Text goes here...</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="media">
                          <div class="pull-left">
                            <span class="fa fa-comments media-icon"></span>
                          </div>
                          <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                            <p>Text goes here...</p>
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="dropdown-footer">
                  <a href="#">
                    <span class="fa fa-list"></span> See all
                  </a>
                </li>
              </ul>
            </li>
            <li class="dropdown dropdown-nav">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user"></span> Hello, user <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="fa fa-gear"></span> Setting</a></li>
                <li><a href="#"><span class="fa fa-power-off"></span> Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.navbar-collapse -->
    </div>
  </nav>
  <!-- /.navbar-top -->

  <!-- .sidebar -->
  <div class="sidebar">
    <div class="sidebar-nav">
      <div class="sidebar-scroller">
        <ul class="sidebar-menu">
          <li>
            <a href="#" title="Dashboard">
              <span class="fa fa-dashboard sidebar-icon"></span>Dashboard
            </a>
          </li>
          <li>
            <a href="#" title="Site Menu">
              <span class="fa fa-file sidebar-icon"></span> Site Menu <span class="arrow"></span>
            </a>
            <ul class="sidebar-submenu">
              <li><a href="#"><span class="fa fa-plus"></span> Sub Menu 1</a></li>
              <li><a href="#"><span class="fa fa-list"></span> Sub Menu 2</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- /.sidebar -->

  <div class="content-wrapper">
    <!-- Site content right here -->
    <h2 class="widget-title">Dashboard</h2>
    <div class="widget">
    </div>
   </div>


   <!-- Javascript -->
  <script type="text/javascript" src="js/vendor.js"></script>
  <script type="text/javascript" src="js/sux-admin.min.js"></script>
</body>

</html>
```

Author Fesuy <fesuydev@gmail.com>
