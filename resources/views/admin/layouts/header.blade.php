 <div class="navbar navbar-expand-md d-print-none">
     <div class="container-xl d-flex justify-content-end">
         <div class="nav-item dropdown">
             <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu"
                 aria-expanded="false">
                 <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)">
                 </span>
                 <div class="d-none d-xl-block ps-2">
                     <div>Admin</div>
                 </div>
             </a>
             <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                 <a href="{{ route('admin.auth.profile') }}" class="dropdown-item">Profile</a>
                 <a href="./profile.html" class="dropdown-item">Change Password</a>
                 <div class="dropdown-divider"></div>
                 <a href="./sign-in.html" class="dropdown-item">Logout</a>
             </div>
         </div>
     </div>
 </div>
