<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Hệ thống quản lý nhân sự và tiền lương
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{date("Y")}} <a href="#">{{empty($companies->firstWhere('id', Auth::user()->company_id))? 'HP' : $companies->firstWhere('id', Auth::user()->company_id)->code}}</a>.</strong> All rights reserved.
  </footer>