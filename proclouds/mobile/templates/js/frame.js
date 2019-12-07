//站点设备选择
function SelSiteEQ()
{
	$.get("ajax_do.php?action=selsiteeq&eq=pc",function(data){
		if(data == 1){
			window.top.location.href = "default.php";
		}
	});
}