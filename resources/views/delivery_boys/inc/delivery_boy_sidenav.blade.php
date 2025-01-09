<div class="aiz-user-sidenav-wrap position-relative z-1 rounded-0">
    <div class="aiz-user-sidenav overflow-auto c-scrollbar-light px-4 pb-4">
        <!-- Close button -->
        <div class="d-xl-none">
            <button class="btn btn-sm p-2 " data-toggle="class-toggle" data-backdrop="static"
                data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb">
                <i class="las la-times la-2x"></i>
            </button>
        </div>

        <!-- Customer info -->
        <div class="p-4 text-center mb-4 border-bottom position-relative">
            <!-- Image -->
            <span class="avatar avatar-md mb-3">
                @if (Auth::user()->avatar_original != null)
                    <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                @else
                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                @endif
            </span>
            <!-- Name -->
            <h4 class="h5 fs-14 mb-1 fw-700 text-dark">{{ Auth::user()->name }}</h4>
            <!-- Phone -->
            @if (Auth::user()->phone != null)
                <div class="text-truncate opacity-60 fs-12">{{ Auth::user()->phone }}</div>
            <!-- Email -->
            @else
                <div class="text-truncate opacity-60 fs-12">{{ Auth::user()->email }}</div>
            @endif
        </div>

        <!-- Menus -->
        <div class="sidemnenu">
            <ul class="aiz-side-nav-list mb-3 pb-3 border-bottom" data-toggle="aiz-side-menu">
                
                <!-- Dashboard -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('dashboard') }}" class="aiz-side-nav-link {{ areActiveRoutes(['dashboard']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_24768" data-name="Group 24768" transform="translate(3495.144 -602)">
                              <path id="Path_2916" data-name="Path 2916" d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z" transform="translate(-3495.144 602)" fill="#b5b5bf"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Dashboard') }}</span>
                    </a>
                </li>
                <!-- Assigned Delivery -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('assigned-deliveries') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['completed-delivery']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_8109" data-name="Group 8109" transform="translate(-27.466 -542.963)">
                                <path id="Path_2953" data-name="Path 2953" d="M14.5,5.963h-4a1.5,1.5,0,0,0,0,3h4a1.5,1.5,0,0,0,0-3m0,2h-4a.5.5,0,0,1,0-1h4a.5.5,0,0,1,0,1" transform="translate(22.966 537)" fill="#b5b5bf"/>
                                <path id="Path_2954" data-name="Path 2954" d="M12.991,8.963a.5.5,0,0,1,0-1H13.5a2.5,2.5,0,0,1,2.5,2.5v10a2.5,2.5,0,0,1-2.5,2.5H2.5a2.5,2.5,0,0,1-2.5-2.5v-10a2.5,2.5,0,0,1,2.5-2.5h.509a.5.5,0,0,1,0,1H2.5a1.5,1.5,0,0,0-1.5,1.5v10a1.5,1.5,0,0,0,1.5,1.5h11a1.5,1.5,0,0,0,1.5-1.5v-10a1.5,1.5,0,0,0-1.5-1.5Z" transform="translate(27.466 536)" fill="#b5b5bf"/>
                                <g id="Group_25728" data-name="Group 25728" transform="translate(-188.535 -279.77)">
                                <rect id="Rectangle_19508" data-name="Rectangle 19508" width="8" height="1" rx="0.5" transform="translate(222.233 834.389) rotate(-45)" fill="#b5b5bf"/>
                                <rect id="Rectangle_19509" data-name="Rectangle 19509" width="1" height="5" rx="0.5" transform="translate(219.404 831.561) rotate(-45)" fill="#b5b5bf"/>
                                </g>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Assigned Delivery') }}</span>
                    </a>
                </li>
                <!-- Pickup Delivery -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('pickup-deliveries') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['completed-delivery']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.002" height="16.002" viewBox="0 0 16.002 16.002">
                            <g id="Group_25713" data-name="Group 25713" transform="translate(-322 -432)">
                                <rect id="Rectangle_19531" data-name="Rectangle 19531" width="10" height="1" rx="0.5" transform="translate(328 445)" fill="#b5b5c0"/>
                                <rect id="Rectangle_19533" data-name="Rectangle 19533" width="5" height="1" rx="0.5" transform="translate(322 432)" fill="#b5b5c0"/>
                                <rect id="Rectangle_19532" data-name="Rectangle 19532" width="1" height="12" rx="0.5" transform="translate(326 432)" fill="#b5b5c0"/>
                                <path id="Subtraction_202" data-name="Subtraction 202" d="M16414.5-2335a2.5,2.5,0,0,1-2.5-2.5,2.5,2.5,0,0,1,2.5-2.5,2.5,2.5,0,0,1,2.5,2.5A2.5,2.5,0,0,1,16414.5-2335Zm0-4a1.5,1.5,0,0,0-1.5,1.5,1.5,1.5,0,0,0,1.5,1.5,1.5,1.5,0,0,0,1.5-1.5A1.5,1.5,0,0,0,16414.5-2339Z" transform="translate(-16088 2783)" fill="#b5b5c1"/>
                                <path id="Subtraction_204" data-name="Subtraction 204" d="M16420-2332h-6a2,2,0,0,1-2-2v-1a2,2,0,0,1,2-2h6a2,2,0,0,1,2,2v1A2,2,0,0,1,16420-2332Zm-6-4a1,1,0,0,0-1,1v1a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1v-1a1,1,0,0,0-1-1Z" transform="translate(-16084 2776)" fill="#b5b5c0"/>
                                <path id="Subtraction_205" data-name="Subtraction 205" d="M16418-2332h-3a2,2,0,0,1-2-2v-1a2,2,0,0,1,2-2h3a2,2,0,0,1,2,2v1A2,2,0,0,1,16418-2332Zm-3-4a1,1,0,0,0-1,1v1a1,1,0,0,0,1,1h3a1,1,0,0,0,1-1v-1a1,1,0,0,0-1-1Z" transform="translate(-16085.004 2772.001)" fill="#b5b5c0"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Picked Up Delivery') }}</span>
                    </a>
                </li>
                <!-- On The Way Delivery -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('on-the-way-deliveries') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['completed-delivery']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.002" height="16" viewBox="0 0 16.002 16">
                            <g id="Group_25718" data-name="Group 25718" transform="translate(-238 -476)">
                                <g id="Group_25717" data-name="Group 25717">
                                <g id="Group_25716" data-name="Group 25716" transform="translate(0 -0.363)">
                                    <path id="Subtraction_208" data-name="Subtraction 208" d="M16418.693-2333.546l0,0c-.027-.251-.293-.487-.744-.664a2.5,2.5,0,0,0,.75-1.788,2.5,2.5,0,0,0-2.5-2.5,2.5,2.5,0,0,0-2.5,2.5,2.5,2.5,0,0,0,.75,1.788c-.451.177-.715.412-.746.663a3.47,3.47,0,0,1-1.006-2.451,3.5,3.5,0,0,1,3.5-3.5,3.505,3.505,0,0,1,3.5,3.5,3.468,3.468,0,0,1-1.006,2.453Z" transform="translate(-16165.697 2815.861)" fill="#b5b5c1"/>
                                    <g id="Group_25715" data-name="Group 25715" transform="translate(-0.627 1)">
                                    <rect id="Rectangle_19547" data-name="Rectangle 19547" width="4" height="1" rx="0.5" transform="translate(250.421 483.121) rotate(-45)" fill="#b5b5c2"/>
                                    <rect id="Rectangle_19548" data-name="Rectangle 19548" width="1" height="4" rx="0.5" transform="translate(248.3 481) rotate(-45)" fill="#b5b5c2"/>
                                    </g>
                                    <ellipse id="Ellipse_618" data-name="Ellipse 618" cx="1" cy="1" rx="1" ry="1" transform="translate(249.5 478.86)" fill="#b5b5c1"/>
                                </g>
                                <path id="Subtraction_211" data-name="Subtraction 211" d="M16311-2162.958h-5a2,2,0,0,1-2-2v-5a2,2,0,0,1,2-2h5a2,2,0,0,1,2,2v5A2,2,0,0,1,16311-2162.958Zm-5-8a1,1,0,0,0-1,1v5a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1v-5a1,1,0,0,0-1-1Z" transform="translate(-16066 2654.958)" fill="#b5b5c0"/>
                                <path id="Rectangle_19552" data-name="Rectangle 19552" d="M0,0H1A0,0,0,0,1,1,0V2.5A.5.5,0,0,1,.5,3h0A.5.5,0,0,1,0,2.5V0A0,0,0,0,1,0,0Z" transform="translate(242 484)" fill="#b5b5c1"/>
                                <path id="Rectangle_19559" data-name="Rectangle 19559" d="M0,0H1A0,0,0,0,1,1,0V2.5A.5.5,0,0,1,.5,3h0A.5.5,0,0,1,0,2.5V0A0,0,0,0,1,0,0Z" transform="translate(248 491) rotate(-90)" fill="#b5b5c1"/>
                                </g>
                                <rect id="Rectangle_19556" data-name="Rectangle 19556" width="1" height="3" rx="0.5" transform="translate(250.5 485.104) rotate(45)" fill="#b5b5c1"/>
                                <rect id="Rectangle_19557" data-name="Rectangle 19557" width="3" height="1" rx="0.5" transform="translate(250.5 485.104) rotate(45)" fill="#b5b5c1"/>
                                <rect id="Rectangle_19558" data-name="Rectangle 19558" width="1" height="5" rx="0.5" transform="translate(250 486)" fill="#b5b5c1"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('On The Way Delivery') }}</span>
                    </a>
                </li>
                <!-- Pending Delivery -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('pending-deliveries') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['pending-delivery']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_25705" data-name="Group 25705" transform="translate(-215.999 -752)">
                                <path id="Path_39414" data-name="Path 39414" d="M221.069,0a8,8,0,1,0,8,8,8,8,0,0,0-8-8m0,15a7,7,0,1,1,7-7,7,7,0,0,1-7,7" transform="translate(2.93 752)" fill="#b5b5bf"/>
                                <rect id="Rectangle_19508" data-name="Rectangle 19508" width="6" height="1" rx="0.5" transform="translate(224.057 759.525) rotate(45)" fill="#b5b5bf"/>
                                <rect id="Rectangle_19509" data-name="Rectangle 19509" width="1" height="5" rx="0.5" transform="translate(223.501 755)" fill="#b5b5bf"/>
                                <circle id="Ellipse_612" data-name="Ellipse 612" cx="1" cy="1" r="1" transform="translate(223 759)" fill="#b5b5c0"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Pending Delivery') }}</span>
                    </a>
                </li>
                <!-- Completed Delivery -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('completed-deliveries') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['completed-delivery']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_25708" data-name="Group 25708" transform="translate(-216.001 -824)">
                                <path id="Path_39411" data-name="Path 39411" d="M221.069,0a8,8,0,1,0,8,8,8,8,0,0,0-8-8m0,15a7,7,0,1,1,7-7,7,7,0,0,1-7,7" transform="translate(2.932 824)" fill="#b5b5bf"/>
                                <g id="Group_25704" data-name="Group 25704" transform="translate(0 0.268)">
                                <rect id="Rectangle_19508" data-name="Rectangle 19508" width="8" height="1" rx="0.5" transform="translate(222.233 834.389) rotate(-45)" fill="#b5b5bf"/>
                                <rect id="Rectangle_19509" data-name="Rectangle 19509" width="1" height="5" rx="0.5" transform="translate(219.404 831.561) rotate(-45)" fill="#b5b5bf"/>
                                </g>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Completed Delivery') }}</span>
                    </a>
                </li>
                <!-- Cancelled Delivery -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('cancelled-deliveries') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['cancelled-delivery']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_25707" data-name="Group 25707" transform="translate(-216.001 -799)">
                                <path id="Path_2961" data-name="Path 2961" d="M221.069,0a8,8,0,1,0,8,8,8,8,0,0,0-8-8m0,15a7,7,0,1,1,7-7,7,7,0,0,1-7,7" transform="translate(2.932 799)" fill="#b5b5bf"/>
                                <rect id="Rectangle_18942" data-name="Rectangle 18942" width="8" height="1" rx="0.5" transform="translate(221.526 803.818) rotate(45)" fill="#b5b5bf"/>
                                <rect id="Rectangle_19510" data-name="Rectangle 19510" width="8" height="1" rx="0.5" transform="translate(227.184 804.525) rotate(135)" fill="#b5b5bf"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Cancelled Delivery') }}</span>
                    </a>
                </li>
                <!-- Request to Cancel -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('cancel-request-list') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['cancel-request-list']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_25714" data-name="Group 25714" transform="translate(-216.001 -799)">
                                <path id="Path_2961" data-name="Path 2961" d="M221.069,0a8,8,0,1,0,8,8,8,8,0,0,0-8-8m0,15a7,7,0,1,1,7-7,7,7,0,0,1-7,7" transform="translate(2.932 799)" fill="#b5b5bf"/>
                                <rect id="Rectangle_18942" data-name="Rectangle 18942" width="5" height="1" rx="0.5" transform="translate(224.975 807.268) rotate(45)" fill="#b5b5bf"/>
                                <path id="Subtraction_207" data-name="Subtraction 207" d="M16308-2165h-2a2.006,2.006,0,0,1-2.006-2v-3a2,2,0,0,1,2.006-2h3a2,2,0,0,1,2,2v2h-1v-2a1,1,0,0,0-.994-.995h-3a1,1,0,0,0-1,.995v3a1,1,0,0,0,1,1h2v1Z" transform="translate(-16084.001 2975)" fill="#b5b5c0"/>
                                <rect id="Rectangle_19541" data-name="Rectangle 19541" width="5" height="1" rx="0.5" transform="translate(228.51 807.975) rotate(135)" fill="#b5b5bf"/>
                                <rect id="Rectangle_19542" data-name="Rectangle 19542" width="1" height="3" rx="0.5" transform="translate(223 803)" fill="#b5b5bf"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Request to Cancel') }}</span>
                    </a>
                </li>
                <!-- Total Collections -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('total-collection') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['today-collection']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_25711" data-name="Group 25711" transform="translate(-218 -680)">
                                <g id="Group_25710" data-name="Group 25710" transform="translate(0.582 0.817)">
                                <g id="Group_25709" data-name="Group 25709">
                                    <path id="Union_28" data-name="Union 28" d="M16419.58-2334.818a.5.5,0,0,1-.414-.179l-6.736-3.887a.5.5,0,0,1-.182-.68.5.5,0,0,1,.686-.186l6.646,3.838,6.648-3.838a.5.5,0,0,1,.684.186.5.5,0,0,1-.186.68L16420-2335a.5.5,0,0,1-.385.18Z" transform="translate(-16194.165 3029.5)" fill="#b5b5bf"/>
                                    <path id="Union_29" data-name="Union 29" d="M16419.58-2334.818a.5.5,0,0,1-.414-.179l-6.736-3.887a.5.5,0,0,1-.182-.68.5.5,0,0,1,.686-.186l6.646,3.838,6.648-3.838a.5.5,0,0,1,.684.186.5.5,0,0,1-.186.68L16420-2335a.5.5,0,0,1-.385.18Z" transform="translate(-16194.165 3026.5)" fill="#b5b5bf"/>
                                    <path id="Union_30" data-name="Union 30" d="M16419.58-2334.818a.5.5,0,0,1-.414-.179l-6.736-3.887a.5.5,0,0,1-.182-.68.5.5,0,0,1,.686-.186l6.646,3.838,6.648-3.838a.5.5,0,0,1,.684.186.5.5,0,0,1-.186.68L16420-2335a.5.5,0,0,1-.385.18Z" transform="translate(-16194.165 3023.5)" fill="#b5b5bf"/>
                                    <path id="Union_31" data-name="Union 31" d="M.065,4.749a.5.5,0,0,1,.184-.682L6.983.178a.569.569,0,0,1,.827,0l6.735,3.888a.5.5,0,0,1-.5.866L7.4,1.094.748,4.933a.5.5,0,0,1-.683-.184Z" transform="translate(218.019 679.683)" fill="#b5b5bf"/>
                                </g>
                                </g>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Total Collection') }}</span>
                    </a>
                </li>
                <!-- Total Earnings -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('total-earnings') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['total-earnings']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_25706" data-name="Group 25706" transform="translate(-216.001 -775)">
                                <path id="Path_39412" data-name="Path 39412" d="M221.069,0a8,8,0,1,0,8,8,8,8,0,0,0-8-8m0,15a7,7,0,1,1,7-7,7,7,0,0,1-7,7" transform="translate(2.932 775)" fill="#b5b5bf"/>
                                <path id="Path_39413" data-name="Path 39413" d="M120.688,9.323v-1a.5.5,0,0,0-1,0v1a2,2,0,0,0-2,2v.5a2,2,0,0,0,2,2h1a1,1,0,0,1,1,1v.5a1,1,0,0,1-1,1h-1a1,1,0,0,1-1-1,.5.5,0,1,0-1,0,2,2,0,0,0,2,2v1a.5.5,0,0,0,1,0v-1a2,2,0,0,0,2-2v-.5a2,2,0,0,0-2-2h-1a1,1,0,0,1-1-1v-.5a1,1,0,0,1,1-1h1a1,1,0,0,1,1,1,.5.5,0,0,0,1,0,2,2,0,0,0-2-2" transform="translate(103.813 769.677)" fill="#b5b5bf"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Earnings') }}</span>
                    </a>
                </li>
                <!-- Manage Profile -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('profile') }}" class="aiz-side-nav-link {{ areActiveRoutes(['profile']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_8094" data-name="Group 8094" transform="translate(3176 -602)">
                              <path id="Path_2924" data-name="Path 2924" d="M331.144,0a4,4,0,1,0,4,4,4,4,0,0,0-4-4m0,7a3,3,0,1,1,3-3,3,3,0,0,1-3,3" transform="translate(-3499.144 602)" fill="#b5b5bf"/>
                              <path id="Path_2925" data-name="Path 2925" d="M332.144,20h-10a3,3,0,0,0,0,6h10a3,3,0,0,0,0-6m0,5h-10a2,2,0,0,1,0-4h10a2,2,0,0,1,0,4" transform="translate(-3495.144 592)" fill="#b5b5bf"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Manage Profile') }}</span>
                    </a>
                </li>
            </ul>
        
            <!-- logout -->
            <a href="{{ route('logout') }}" class="btn btn-primary btn-block fs-14 fw-700 mb-5 mb-md-0" style="border-radius: 25px;">{{ translate('Sign Out') }}</a>
        </div>

    </div>
</div>
