<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Eslam Elbadry</p>
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

        <!-- Start treeview Manage items -->
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('category.index') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('categories.manage_title') }}</a>
          </li>
          <li>
            <a href="{{ route('category.create') }}">
            <i class="fa fa-circle-o"></i>
            {{ trans('categories.add_category') }}</a>
          </li>
        </ul>
       
      </li>

      {{-- End treeview for categories --}}

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
