<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        @php
          $admin_info = \DB::table('admins')->orderBy('id', 'desc')->first();
          $admin_name = $admin_info->name; 
        @endphp
        <p>{{ $admin_name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('main.online') }}</a>
      </div>
    </div>
   
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">{{ trans('main.main') }}</li>
      <li class="active">
        <a href="{{ route('admin.dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>{{ trans('main.dashboard') }}</span> 
        </a>
       
      </li>

            {{-- Start treeview for store information --}}
      <li class="treeview">
        <a>
          <i class="fa fa-database fa-fw"></i> <span>{{ trans('store_info.titile') }}</span> 
          <i class="fa fa-angle-left pull-right"></i>
        </a>

       
        <ul class="treeview-menu">
        @php
          $store_id = \DB::table('store_information')->orderBy('id', 'desc')->first()->id;
        @endphp
          <li>
            <a href="{{ route('store_info.update', $store_id ) }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('store_info.update_store') }}</a>
          </li>
          <li>
            <a href="{{ route('store_info.view', $store_id) }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('store_info.view_store') }}</a>
          </li>

           <li>
            <a href="{{ route('store_info.view', $store_id) }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('store_info.update_social_media') }}</a>
          </li>

           <li>
            <a href="{{ route('store_info.update_times', $store_id) }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('store_info.update_work_times') }}</a>
          </li>
        </ul>
       
      </li>

      {{-- End treeview for store information --}}

      {{-- Start Slider --}}

       <li class="treeview">
        <a>
          <i class="fa fa-image"></i> <span>{{ trans('slider.slider') }}</span> 
          <i class="fa fa-angle-left pull-right"></i>
        </a>

        <!-- Start treeview Manage items -->
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('sliders.index') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('slider.slider_manage') }}</a>
          </li>
          <li>
            <a href="{{ route('sliders.create') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('slider.add_slider') }}</a>
          </li>
        </ul>
       
      </li>
      {{-- End Slider --}}
  
       <li class="treeview">
        <a>
          <i class="fa fa-tags"></i> <span>{{ trans('main.items') }}</span> 
          <i class="fa fa-angle-left pull-right"></i>
        </a>

        <!-- Start treeview Manage items -->
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('items.index') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('main.manage_items') }}</a>
          </li>
          <li>
            <a href="{{ route('items.create') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('main.add_item') }}</a>
          </li>
        </ul>
       
      </li>

      {{-- Start treeview for categories --}}
      <li class="treeview">
        <a>
          <i class="fa fa-tag"></i> <span>{{ trans('categories.box_title') }}</span> 
          <i class="fa fa-angle-left pull-right"></i>
        </a>

       
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('category.index', 1) }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('categories.manage_title_blog') }}</a>
          </li>
           <li>
            <a href="{{ route('category.index', 0) }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('categories.manage_title_items') }}</a>
          </li>
          <li>
            <a href="{{ route('category.create') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('categories.add_category') }}</a>
          </li>
        </ul>
       
      </li>

      {{-- End treeview for categories --}}

      {{-- Start treeview for webpages --}}
      <li class="treeview">
        <a>
          <i class="fa fa-file"></i> <span>{{ trans('cms.manage_title') }}</span> 
          <i class="fa fa-angle-left pull-right"></i>
        </a>

       
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('web_pages.index') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('cms.manage_webpage') }}</a>
          </li>
          <li>
            <a href="{{ route('web_pages.create') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('cms.add_cms') }}</a>
          </li>
        </ul>
       
      </li>

      {{-- End treeview for webpages --}}

       {{-- Start treeview for blogs --}}
      <li class="treeview">
        <a>
          <i class="fa fa-file-o"></i> <span>{{ trans('blog.manage_title') }}</span> 
          <i class="fa fa-angle-left pull-right"></i>
        </a>

       
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('blogs.index') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('blog.manage_title') }}</a>
          </li>
          <li>
            <a href="{{ route('blogs.create') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('blog.add_blog') }}</a>
          </li>
        </ul>
       
      </li>

      {{-- End treeview for blogs --}}

      {{-- Start treeview for homepage_blocks --}}
      <li class="treeview">
        <a>
          <i class="fa fa-star"></i> <span>{{ trans('blocks.homepage_blocks') }}</span> 
          <i class="fa fa-angle-left pull-right"></i>
        </a>

       
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('homepage_blocks.index') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('blocks.manage_block') }}</a>
          </li>
          <li>
            <a href="{{ route('homepage_blocks.create') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('blocks.add_block') }}</a>
          </li>
        </ul>
       
      </li>

      {{-- End treeview for homepage_blocks --}}

       {{-- Start treeview for admins --}}
      <li class="">
      @php
        $admin_id = \DB::table('admins')->orderBy('id', 'desc')->first()->id;
      @endphp
        <a href="{{ route('admins.view', $admin_id) }}">
          <i class="fa fa-briefcase"></i> <span>{{ trans('admins.manage_title') }}</span> 
         
        </a>

       
       
      </li>

      {{-- End treeview for admins --}}

      {{-- Start treeview for users --}}
      <li class="">
        <a href="{{ route('users.index') }}">
          <i class="fa fa-users"></i> <span>{{ trans('user.manage_title') }}</span> 
         
        </a>

       
       
      </li>

      {{-- End treeview for users --}}

        {{-- Start treeview for enquiries --}}
      <li class="">
        <a href="{{ route('enquiries.index') }}">
          <i class="fa fa-envelope"></i> <span>{{ trans('enquiries.manage_tilte') }}</span> 
         
        </a>

       
       
      </li>

      {{-- End treeview for enquiries --}}

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
