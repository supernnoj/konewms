<nav class="navbar navbar-expand-lg be-sub-header">
    <div class="container">
        <!--+mega-menu('dashboard1','home')-->
        <!-- Mega Menu structure-->
        <nav class="navbar navbar-expand-md">
            <button class="navbar-toggler hidden-md-up collapsed" type="button" data-toggle="collapse"
                data-target="#be-mega-menu-collapse" aria-controls="#be-mega-menu-collapse" aria-expanded="false"
                aria-label="Toggle navigation"><a class="mega-menu-toggle" href="#">Mega Menu</a></button>
            <div class="navbar-collapse collapse be-nav-tabs" id="be-mega-menu-collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item parent {{ request()->routeIs('dashboard.kpi') ? 'open section-active' : '' }}">
                        <a class="nav-link" href="#" role="button" aria-expanded="false"><span
                                class="icon mdi mdi-view-dashboard"></span><span>Dashboard</span></a>
                        <ul class="be-nav-tabs-sub be-sub-nav nav">
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('dashboard.kpi') ? 'active' : '' }}"
                                    href="{{ route('dashboard.kpi') }}" wire:navigate><span
                                        class="icon mdi mdi-trending-up"></span><span class="name">KPIs</span></a>
                        </ul>
                    </li>
                    <li
                        class="nav-item parent {{ request()->routeIs(['inventory.list', 'inventory.create']) ? 'open section-active' : '' }}">
                        <a class="nav-link" href="#" role="button" aria-expanded="false"><span
                                class="icon mdi mdi-dropbox"></span><span>Inventory</span></a>
                        <ul class="be-nav-tabs-sub be-sub-nav nav">
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('inventory.list') ? 'active' : '' }}"
                                    href="{{ route('inventory.list') }}" wire:navigate><span class="name"><span
                                            class="icon mdi mdi-view-list-alt"></span>List of All Items</span></a>
                            </li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('inventory.create') ? 'active' : '' }}" href="{{ route('inventory.create') }}" wire:navigate><span
                                        class="name"><span class="icon mdi mdi-plus-square"></span>Add New
                                        Item</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item parent {{ request()->routeIs(['transactions.create', 'transactions.list']) ? 'open section-active' : '' }}"><a class="nav-link" href="#" role="button"
                            aria-expanded="false"><span
                                class="icon mdi mdi-swap-vertical"></span><span>Transactions</span></a>
                        <ul class="be-nav-tabs-sub be-sub-nav nav">
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('transactions.list') ? 'active' : '' }}" href="{{ route('transactions.list') }}"><span
                                        class="icon mdi mdi-view-list-alt"></span><span class="name">List of All
                                        Transactions</span></a>
                            </li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('transactions.create') ? 'active' : '' }}" href="{{ route('transactions.create') }}"><span
                                        class="icon mdi mdi-plus-square"></span><span class="name">Create New
                                        Transaction</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item parent"><a class="nav-link" href="#" role="button"
                            aria-expanded="false"><span class="icon mdi mdi-settings"></span><span>System</span></a>
                        <ul class="be-nav-tabs-sub be-sub-nav nav">
                            <li class="nav-item"><a class="nav-link" href="tables-general.html"><span
                                        class="icon mdi mdi-key"></span><span class="name">User Management</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</nav>
