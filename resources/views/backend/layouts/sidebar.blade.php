<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <!--<h3>商家恋管理后台</h3>-->
        <ul class="nav side-menu">
            <li><a><i class="fa fa-home"></i> 活动 <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/activity/industry">行业管理</a></li>
                    <li><a href="/activity/general">通用活动</a></li>
                    <li><a href="/activity/bargain">砍价活动</a></li>
                    <li><a href="/activity/manage">活动管理</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-user"></i> 用户 <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/consumer">商家用户</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-mobile"></i> C端 <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="/mobile/skeleton">首页搭建</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{$be['endpoint']}}/logout">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- /menu footer buttons -->

