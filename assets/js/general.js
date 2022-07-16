$(document).ready(function () {
    // Playing with URL
    var url = window.location.href;
    var indicator = '';

    indicator = url.indexOf('dashboard');
    if (indicator != -1) {
      $("li#dashboard-nav-item").addClass("active");
    }

    indicator = url.indexOf('sales');
    if (indicator != -1) {
      $("li#sales-nav-item").addClass("active");
    }

    if ((url == 'http://localhost/store/sales') || (url.indexOf('sales/page-no') != -1)) {
      $("li#sales-list-nav-item").addClass("active");
    }

    indicator = url.indexOf('step-1');
    if (indicator != -1) {
      $("li#add-sale-nav-item").addClass("active");
    }

    indicator = url.indexOf('goods');
    if (indicator != -1) {
      $("li#goods-nav-item").addClass("active");
      $("li#goods-list-nav-item").addClass("active");
    }

    indicator = url.indexOf('people-finances');
    if (indicator != -1) {
      $("li#finances-nav-item").addClass("active");
      $("li#people-finances-nav-item").addClass("active");
    }

    if ((url == 'http://localhost/store/perm-customers-finances') || (url.indexOf('perm-customers-finances/page-no') != -1)) {
      $("li#finances-nav-item").addClass("active");
      $("li#perm-customers-finances-nav-item").addClass("active");
    }

    indicator = url.indexOf('perm-customers');
    if ((url == 'http://localhost/store/perm-customers') || (url.indexOf('perm-customers/page-no') != -1)) {
      $("li#perm-customers-nav-item").addClass("active");
    }

    indicator = url.indexOf('reports');
    if (indicator != -1) {
      $("li#reports-nav-item").addClass("active");
    }

    indicator = url.indexOf('expenses');
    if (indicator != -1) {
      $("li#expenses-nav-item").addClass("active");
    }
});
