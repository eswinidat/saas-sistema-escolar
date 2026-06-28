<header class="app-header navbar navbar-expand bg-body">

    <div class="container-fluid">

        <!-- Botón Sidebar -->

        <ul class="navbar-nav">

            <li class="nav-item">

                <a class="nav-link"
                   data-lte-toggle="sidebar"
                   href="#"
                   role="button">

                    <i class="bi bi-list"></i>

                </a>

            </li>

        </ul>

        <!-- Menú derecho -->

        <ul class="navbar-nav ms-auto">

            <li class="nav-item dropdown">

                <a class="nav-link"
                   data-bs-toggle="dropdown"
                   href="#">

                    <i class="bi bi-person-circle fs-5"></i>

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <span class="dropdown-item-text">
                            {{ Auth::user()->name }}
                        </span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form method="POST"
                              action="{{ route('logout') }}">

                            @csrf

                            <button
                                class="dropdown-item">

                                Cerrar sesión

                            </button>

                        </form>

                    </li>

                </ul>

            </li>

        </ul>

    </div>

</header>