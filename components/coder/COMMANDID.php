<?php

namespace app\components\coder;

/**
 * 消息头标识号
 * 4位长为记录集读取
 */

class COMMANDID
{

	public static $LOGIN = 1;	//用户登录
	
	//社区管理相关
    public static $COMMUNITYGET = 10; 	//获取社区信息
    public static $COMMUNITYSAVE = 11; 	//保存社区信息
    public static $COMMUNITYDEL = 12; 	//删除社区信息
    public static $COMMUNITYLIST = 1000;	//列取社区信息
    public static $COMMUNITYSIMPLELIST = 1001;	//列取社区名称信息
    public static $COMMUNITYPHOTOLIST = 1002;	//获取社区照片列表
    
    //楼宇管理相关
    public static $HOUSINGGET = 20;		//获取楼宇信息
    public static $HOUSINGSAVE = 21;	//保存楼宇信息
    public static $HOUSINGDEL = 22;		//删除楼宇信息
    public static $HOUSINGFLOORGET = 23; 	//获取楼层信息
    public static $HOUSINGFLOORSAVE = 24; 	//保存楼层信息
    public static $HOUSINGFLOORDEL = 25; 	//删除楼层信息   
    public static $HOUSINGROOMGET = 26; 	//获取房间信息
    public static $HOUSINGROOMSAVE = 27; 	//保存房间信息
    public static $HOUSINGROOMDEL = 28; 	//删除房间信息
    public static $HOUSINGLIST = 2000;		//获取楼宇列表
    public static $HOUSINGFLOORLIST = 2001;	//获取楼层列表
    public static $HOUSINGROOMLIST = 2002;	//获取房间列表
    public static $HOUSINGSTATSLIST = 2003;	//获取楼宇入驻情况
    public static $HOUSINGSIMPLELIST = 2004;//获取楼宇列表
    public static $HOUSINGFLOORSTATSLIST = 2005;	//获取楼宇各楼层入驻情况
    public static $HOUSINGPHOTOLIST = 2006;//获取楼宇各照片列表
    public static $HOUSINGCOMPANYLIST = 2007;//获取楼宇入驻企业列表
    
    public static $COMPANYGET = 30;	//获取企业信息
    public static $COMPANYSAVE = 31;//添加企业信息
    public static $COMPANYDEL = 32;	//删除企业信息
    public static $COMPANYGETLOGOUT = 33;	//获取企业注销信息
    public static $COMPANYSAVELOGOUT = 34;	//企业注销信息
    public static $COMPANYSAVELOGOUTCHECK = 35;	//企业注销审核
    public static $COMPANYLIST = 3000;//获取企业列表
    public static $COMPANYSIMPLELIST = 3001;//获取企业名称列表  
    
    public static $RENTGET = 40; 	//获取出租详情
    public static $RENTSAVE = 41;	//保存出租信息
    public static $RENTDEL = 42;	//删除出租信息
    public static $SELLGET = 43;	//获取出售详情
    public static $SELLSAVE = 44;	//保存出售信息
    public static $SELLDEL = 45;	//删除出售信息
    public static $RENTLIST = 4000;	//列表出租信息
    public static $SELLLIST = 4001;	//列表出售信息
    public static $RESOURCENAMELIST = 4002; //列表出租或出售名称列表
    
    public static $CUSTOMFIELD_ADD = 90; //添加自定义字段
    public static $CUSTOMFIELD_GET = 91; //获取自定义字段
    
}
