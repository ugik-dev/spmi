    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('b3817a58314330fee505', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('user.1');
        channel.bind('new_notification', function(data) {
            alert(JSON.stringify(data));
        });
    </script>

    <li class="nav-item dropdown notification-dropdown">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-bell">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg><span class="badge badge-success"></span>
        </a>

        <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
            <div class="notification-scroll">
                <div class="drodpown-title notification mt-2">
                    <h6 class="d-flex justify-content-between"><span class="align-self-center">Notifications</span>
                        <span class="badge badge-secondary">16 New</span>
                    </h6>
                </div>

                {{-- <div class="dropdown-item">
                    <div class="media server-log">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-server">
                            <rect x="2" y="2" width="20" height="8" rx="2" ry="2">
                            </rect>
                            <rect x="2" y="14" width="20" height="8" rx="2" ry="2">
                            </rect>
                            <line x1="6" y1="6" x2="6" y2="6"></line>
                            <line x1="6" y1="18" x2="6" y2="18"></line>
                        </svg>
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">Server Rebooted</h6>
                                <p class="">45 min ago</p>
                            </div>

                            <div class="icon-status">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18">
                                    </line>
                                    <line x1="6" y1="6" x2="18" y2="18">
                                    </line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="dropdown-item">
                    <div class="media file-upload">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">Permohonan Usulan Dipa</h6>
                            </div>
                            <div class="icon-status">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18">
                                    </line>
                                    <line x1="6" y1="6" x2="18" y2="18">
                                    </line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </li>
