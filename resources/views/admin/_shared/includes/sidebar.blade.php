<aside class="aside-container">
    <!-- START Sidebar (left)-->
    <div class="aside-inner">
        <nav class="sidebar" data-sidebar-anyclick-close="{{sizeof($sidebarMenu)}}">
            <!-- START sidebar nav-->
            <ul class="sidebar-nav">
                @foreach ($sidebarMenu as $item)
                    {{-- Headings --}}
                    @if (isset($item['heading']))
                        <li class="nav-heading ">
                            <span data-localize="{{$item['translate'] ?? ''}}">{{$item['text']}}</span>
                        </li>

                    {{-- Handle Submenus --}}
                    @elseif (isset($item['submenu']))
                        <?php $collapseId = 'menu-'.Str::slug($item['text']); ?>
                        <li class="{{ \Request::is($item['route'].'*') ? ' active' : '' }}">
                            <a href="{{'#'.$collapseId}}" title="{{$item['text']}}" data-toggle="collapse">
                                <em class="{{$item['icon']}}"></em>
                                <span data-localize="{{$item['translate'] ?? ''}}">{{$item['text']}}</span>
                            </a>
                            <ul class="sidebar-nav sidebar-subnav collapse {{ \Request::is($item['route'].'/*') ? 'show' : '' }}" id="{{$collapseId}}">
                                <li class="sidebar-subnav-header">{{$item['text']}}</li>

                                @foreach ($item['submenu'] as $subitem)

                                    {{-- 2nd Level Handle Submenus --}}
                                    @if (isset($subitem['submenu']))

                                        <?php $collapseId = 'submenu-'.Str::slug($subitem['text']); ?>
                                        <li class="{{ \Request::is($subitem['route'].'*') ? ' active' : '' }}">
                                            <a href="{{'#'.$collapseId}}" title="{{$subitem['text']}}" data-toggle="collapse">
                                                <em class="{{$subitem['icon']}}"></em>
                                                <span data-localize="{{$subitem['translate'] ?? ''}}">{{$subitem['text']}}</span>
                                            </a>
                                            <ul class="sidebar-nav sidebar-subnav collapse {{ \Request::is($subitem['route'].'/*') ? 'show' : '' }}" id="{{$collapseId}}">
                                                <li class="sidebar-subnav-header">{{$subitem['text']}}</li>

                                                @foreach ($subitem['submenu'] as $subsubitem)
                                                    <li class="{{ \Request::is($subsubitem['route']) ? ' active' : '' }}">
                                                        <a href="{{ url($subsubitem['route']) }}" title="{{$subsubitem['text']}}">
                                                            <span data-localize="{{$subsubitem['translate'] ?? ''}}">{{$subsubitem['text']}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach

                                            </ul>
                                        </li>

                                    {{-- 2nd Level Defualt to Single item --}}
                                    @else
                                        <li class="{{ \Request::is($subitem['route']) ? ' active' : '' }}">
                                            <a href="{{ url($subitem['route']) }}" title="{{$subitem['text']}}">
                                                <span data-localize="{{$subitem['translate'] ?? ''}}">{{$subitem['text']}}</span>
                                            </a>
                                        </li>
                                    @endif

                                @endforeach

                            </ul>
                        </li>

                    {{-- Default to Single item --}}
                    @else
                        <li class="{{ \Request::is($item['route']) ? ' active' : '' }}">
                            <a href="{{ url($item['route']) }}" title="{{$item['text']}}">
                                <em class="{{$item['icon']}}"></em>
                                <span data-localize="{{$item['translate'] ?? ''}}">
                                    {{$item['text']}}

                                    @if(isset($item['count']))
                                        <b class="badge badge-{{ $item['count_class'] ?? 'warning' }} inline">{{ $item['count']() }}</b>
                                    @endif
                                </span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <!-- END sidebar nav-->
        </nav>
    </div>
    <!-- END Sidebar (left)-->
</aside>
