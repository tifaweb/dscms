$(function () {
	//日期选择区间
	 var locale = {
	"format": 'YYYY-MM-DD',
	"separator": " 至 ",//
	"applyLabel": "确定",
	"cancelLabel": "取消",
	"fromLabel": "起始时间",
	"toLabel": "结束时间'",
	"customRangeLabel": "自定义",
	"weekLabel": "W",
	"daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
	"monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
	"firstDay": 1
	};
	$('.timeInterval').daterangepicker({
	"locale": locale,
	"ranges" : {
	'最近1小时': [moment().subtract('hours',1), moment()],
	'今日': [moment().startOf('day'), moment()],
	'昨日': [moment().subtract('days', 1).startOf('day'), moment().subtract('days', 1).endOf('day')],
	'最近7日': [moment().subtract('days', 6), moment()],
	'最近30日': [moment().subtract('days', 29), moment()],
	'本月': [moment().startOf("month"),moment().endOf("month")],
	'上个月': [moment().subtract(1,"month").startOf("month"),moment().subtract(1,"month").endOf("month")]
	},
	"opens":"right",
	"timePicker":true,
	"timePickerIncrement" : 60,
	})
	//表单样式
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
	//切换模板
	/**
   * Get a prestored setting
   *
   * @param String name Name of of the setting
   * @returns String The value of the setting | null
   */
  function get(name) {
    if (typeof (Storage) !== 'undefined') {
      return localStorage.getItem(name)
    } else {
      window.alert('请正确使用现代浏览器来查看此模板!')
    }
  }

  /**
   * Store a new settings in the browser
   *
   * @param String name Name of the setting
   * @param String val Value of the setting
   * @returns void
   */
  function store(name, val) {
    if (typeof (Storage) !== 'undefined') {
      localStorage.setItem(name, val)
    } else {
      window.alert('请正确使用现代浏览器来查看此模板!')
    }
  }
  
  $('#adminTheme .full-opacity-hover').click(function(){
		var themedata=$(this).attr('data-skin');
		$('body').removeClass(get('adminTheme'));
		$('body').addClass(themedata);
		store('adminTheme',themedata);	 
		
  	
  })
 
  if (get('adminTheme') !== null) {
  	$('body').removeClass("skin-blue");
	$('body').addClass(get('adminTheme'));
  }
  
  //左侧导航
  /**
   * Get a prestored setting
   *
   * @param String name Name of of the setting
   * @returns String The value of the setting | null
   */
  function sessionget(name) {
    if (typeof (Storage) !== 'undefined') {
      return sessionStorage.getItem(name)
    } else {
      window.alert('请正确使用现代浏览器来查看此模板!')
    }
  }

  /**
   * Store a new settings in the browser
   *
   * @param String name Name of the setting
   * @param String val Value of the setting
   * @returns void
   */
  function sessionstore(name, val) {
    if (typeof (Storage) !== 'undefined') {
      sessionStorage.setItem(name, val)
    } else {
      window.alert('请正确使用现代浏览器来查看此模板!')
    }
  }
  
  $('.goindex').click(function(){
		sessionStorage.removeItem('leftNavigationOne');
		sessionStorage.removeItem('leftNavigationTwo');
  })
  $('#leftNavigation .sidebar-menu li .treeview-menu li').click(function(){
  		var two=$(this).index();
		var one=$(this).parents('li').index();
		sessionstore('leftNavigationOne',one);
		sessionstore('leftNavigationTwo',two);
  })
  var leftNavigationOne=sessionget('leftNavigationOne');
  var leftNavigationTwo=sessionget('leftNavigationTwo');
  if (typeof (leftNavigationOne) !== 'undefined' && leftNavigationOne !== null) {
	$('#leftNavigation .sidebar-menu .active').removeClass('active');
  	$('#leftNavigation .sidebar-menu ').children('li:eq('+leftNavigationOne+')').addClass('active');
	$('#leftNavigation .sidebar-menu ').children('li:eq('+leftNavigationOne+')').addClass('menu-open');
	$('#leftNavigation .sidebar-menu ').children('li:eq('+leftNavigationOne+')').find('.treeview-menu li:eq('+leftNavigationTwo+')').addClass('active');
  }
  
  //管理员头像选择
  $('.adminlogo .img-circle').click(function(){
	  var img=$(this).attr('src');
	  var data=$(this).attr('alt');
	  $('.adminlogo .img-circle').removeClass('on');
	  $(this).addClass('on');
	  $('.imgupPortraitLoad img').attr('src',img);
	  $('#adminportraitvar').val(data);
  })

})