@if(isset($menu) && $menu)
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                @include(config('settings.theme').'.admin.customAdminMenuItems', ['items'=>$menu->roots()])
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
@endif