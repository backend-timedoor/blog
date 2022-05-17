<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="#">Timedoor Blog</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="#">TB</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">HIGHLIGHT</li>
        <li class="dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-newspaper"></i> <span>Post</span></a>
            <ul class="dropdown-menu">
                <li>
                    <a class="nav-link" href="{{ route('admin-blog.category.index') }}">
                        <span>Category</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('admin-blog.tag.index') }}">
                        <span>Tag</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('admin-blog.blog.index') }}">
                        <span>Blog</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('admin-blog.blog-featured.index') }}">
                        <span>Blog Featured</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="nav-link" href="{{ route('admin-blog.language.setting.index') }}">
                <span><i class="fas fa-language"></i> Language Setting</span>
            </a>
        </li>
    </ul>
</aside>